<?php

namespace App\Http\Controllers;

use App\Models\Script;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImportExportController extends Controller
{
    /**
     * Afficher la page d'import/export
     */
    public function index()
    {
        return view('scripts.import-export');
    }

    /**
     * Importer des scripts depuis un fichier SQL
     */
    public function import(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|file|mimes:sql,txt|max:10240',
            'db_target' => 'required|in:postgresql,mysql,sqlserver,db2,oracle,other',
        ]);

        $file = $request->file('sql_file');
        $content = file_get_contents($file->getRealPath());

        $scripts = $this->parseSqlFile($content);

        $imported = 0;
        foreach ($scripts as $scriptData) {
            $script = Script::create([
                'name' => $scriptData['name'],
                'content' => $scriptData['content'],
                'version' => '1.0',
                'status' => 'draft',
                'db_target' => $request->db_target,
                'author' => auth()->user()->name,
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
            $content .= "-- Date: {$script->created_at}\n\n";
            $content .= $script->content . "\n\n";
        }

        $filename = 'scripts_export_' . date('Y-m-d_H-i-s') . '.sql';

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
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
                    'name' => 'Script importé ' . (count($scripts) + 1),
                    'content' => $statement . ';',
                ];
            }
        }

        return $scripts;
    }
}
