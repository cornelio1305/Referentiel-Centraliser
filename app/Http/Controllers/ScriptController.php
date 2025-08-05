<?php

namespace App\Http\Controllers;

use App\Models\Script;
use App\Models\ScriptVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ScriptController extends Controller
{
    /**
     * Afficher la liste des scripts
     */
    public function index(Request $request)
    {
        $query = Script::with(['creator', 'updater']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('db_target')) {
            $query->where('db_target', $request->db_target);
        }

        if ($request->filled('author')) {
            $query->where('author', 'like', '%' . $request->author . '%');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $scripts = $query->paginate(15);

        $dbTargets = [
            'postgresql' => 'PostgreSQL',
            'mysql' => 'MySQL',
            'sqlserver' => 'SQL Server',
            'db2' => 'DB2',
            'oracle' => 'Oracle',
            'other' => 'Autre',
        ];

        $statuses = [
            'draft' => 'Brouillon',
            'active' => 'Actif',
            'inactive' => 'Inactif',
            'archived' => 'Archivé',
        ];

        return view('scripts.index', compact('scripts', 'dbTargets', 'statuses'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $dbTargets = [
            'postgresql' => 'PostgreSQL',
            'mysql' => 'MySQL',
            'sqlserver' => 'SQL Server',
            'db2' => 'DB2',
            'oracle' => 'Oracle',
            'other' => 'Autre',
        ];

        $statuses = [
            'draft' => 'Brouillon',
            'active' => 'Actif',
            'inactive' => 'Inactif',
            'archived' => 'Archivé',
        ];

        return view('scripts.create', compact('dbTargets', 'statuses'));
    }

    /**
     * Enregistrer un nouveau script
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'version' => 'required|string|max:50',
            'status' => 'required|in:draft,active,inactive,archived',
            'db_target' => 'nullable|in:postgresql,mysql,sqlserver,db2,oracle,other',
            'server_name' => 'nullable|string|max:255',
            'database_name' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'affected_objects' => 'nullable|array',
            'related_application' => 'nullable|string|max:255',
            'related_job' => 'nullable|string|max:255',
            'documentation' => 'nullable|string',
            'dependencies' => 'nullable|array',
        ]);

        $script = Script::create([
            ...$validated,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        // Créer la première version
        $script->createVersion('Création initiale');

        return redirect()->route('scripts.show', $script)
            ->with('success', 'Script créé avec succès.');
    }

    /**
     * Afficher un script
     */
    public function show(Script $script)
    {
        // Incrémenter les vues
        $script->incrementViews();

        $versions = $script->versions()->orderBy('created_at', 'desc')->get();

        return view('scripts.show', compact('script', 'versions'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Script $script)
    {
        $dbTargets = [
            'postgresql' => 'PostgreSQL',
            'mysql' => 'MySQL',
            'sqlserver' => 'SQL Server',
            'db2' => 'DB2',
            'oracle' => 'Oracle',
            'other' => 'Autre',
        ];

        $statuses = [
            'draft' => 'Brouillon',
            'active' => 'Actif',
            'inactive' => 'Inactif',
            'archived' => 'Archivé',
        ];

        return view('scripts.edit', compact('script', 'dbTargets', 'statuses'));
    }

    /**
 * Affiche la page de gestion des versions
 */
public function versions(Request $request)
{
    $query = Script::with(['author', 'versions']);

    // Filtres
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('database')) {
        $query->where('database', $request->database);
    }

    if ($request->filled('author')) {
        $query->where('author_id', $request->author);
    }

    // Ajouter le comptage des versions
    $query->withCount('versions');

    $scripts = $query->orderBy('updated_at', 'desc')->paginate(15);

    // Statistiques
    $totalScripts = Script::count();
    $totalVersions = ScriptVersion::count(); // Ajustez selon votre modèle
    $recentlyModified = Script::where('updated_at', '>=', now()->subDays(7))->count();
    $averageVersions = round($totalVersions / max($totalScripts, 1), 1);

    // Liste des auteurs pour le filtre
    $authors = User::whereHas('scripts')->get();

    return view('scripts.versions', compact(
        'scripts',
        'totalScripts',
        'totalVersions',
        'recentlyModified',
        'averageVersions',
        'authors'
    ));
}
    /**
     * Mettre à jour un script
     */
    public function update(Request $request, Script $script)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'version' => 'required|string|max:50',
            'status' => 'required|in:draft,active,inactive,archived',
            'db_target' => 'nullable|in:postgresql,mysql,sqlserver,db2,oracle,other',
            'server_name' => 'nullable|string|max:255',
            'database_name' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'affected_objects' => 'nullable|array',
            'related_application' => 'nullable|string|max:255',
            'related_job' => 'nullable|string|max:255',
            'documentation' => 'nullable|string',
            'dependencies' => 'nullable|array',
            'change_reason' => 'nullable|string|max:255',
        ]);

        // Créer une nouvelle version si le contenu a changé
        if ($script->content !== $validated['content'] || $script->version !== $validated['version']) {
            $script->createVersion($validated['change_reason'] ?? 'Mise à jour');
        }

        $script->update([
            ...$validated,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('scripts.show', $script)
            ->with('success', 'Script mis à jour avec succès.');
    }

    /**
     * Supprimer un script
     */
    public function destroy(Script $script)
    {
        $script->delete();

        return redirect()->route('scripts.index')
            ->with('success', 'Script supprimé avec succès.');
    }

    /**
     * Recherche avancée
     */
    public function search(Request $request)
    {
        $query = Script::with(['creator', 'updater']);

        // Filtres de recherche
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('content')) {
            $query->where('content', 'like', '%' . $request->content . '%');
        }

        if ($request->filled('author')) {
            $query->where('author', 'like', '%' . $request->author . '%');
        }

        if ($request->filled('db_target')) {
            $query->where('db_target', $request->db_target);
        }

        if ($request->filled('server_name')) {
            $query->where('server_name', 'like', '%' . $request->server_name . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $scripts = $query->paginate(15);

        return view('scripts.search', compact('scripts'));
    }

    /**
     * Importer des scripts
     */
    public function import(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|file|mimes:sql,txt|max:10240', // 10MB max
        ]);

        $file = $request->file('sql_file');
        $content = file_get_contents($file->getRealPath());

        // Découper le fichier en scripts individuels
        $scripts = $this->parseSqlFile($content);

        $imported = 0;
        foreach ($scripts as $scriptData) {
            $script = Script::create([
                'name' => $scriptData['name'],
                'content' => $scriptData['content'],
                'version' => '1.0',
                'status' => 'draft',
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            $script->createVersion('Import automatique');
            $imported++;
        }

        return redirect()->route('scripts.index')
            ->with('success', "{$imported} scripts importés avec succès.");
    }

    /**
     * Exporter des scripts
     */
    public function export(Request $request)
    {
        $scripts = Script::whereIn('id', $request->script_ids ?? [])->get();

        $content = '';
        foreach ($scripts as $script) {
            $content .= "-- Script: {$script->name}\n";
            $content .= "-- Version: {$script->version}\n";
            $content .= "-- Auteur: {$script->author}\n";
            $content .= "-- Date: {$script->created_at}\n";
            $content .= "-- Description: {$script->description}\n\n";
            $content .= $script->content . "\n\n";
        }

        $filename = 'scripts_export_' . date('Y-m-d_H-i-s') . '.sql';

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }

    /**
     * Afficher l'historique des versions
     */
    public function history(Script $script)
    {
        $versions = $script->versions()->with('creator')->orderBy('created_at', 'desc')->get();

        return view('scripts.history', compact('script', 'versions'));
    }

    /**
     * Restaurer une version
     */
    public function restore(Script $script, ScriptVersion $version)
    {
        $script->update([
            'content' => $version->content,
            'description' => $version->description,
            'version' => $version->version,
            'updated_by' => auth()->id(),
        ]);

        $script->createVersion('Restauration de la version ' . $version->version);

        return redirect()->route('scripts.show', $script)
            ->with('success', 'Version restaurée avec succès.');
    }

    /**
     * Comparer deux versions
     */
    public function compare(Script $script, ScriptVersion $version1, ScriptVersion $version2 = null)
    {
        if (!$version2) {
            $version2 = $script->versions()->latest()->first();
        }

        return view('scripts.compare', compact('script', 'version1', 'version2'));
    }

    /**
     * Parser un fichier SQL
     */
    private function parseSqlFile($content)
    {
        $scripts = [];
        $statements = explode(';', $content);

        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                $scripts[] = [
                    'name' => 'Script importé ' . count($scripts) + 1,
                    'content' => $statement . ';',
                ];
            }
        }

        return $scripts;
    }
}
