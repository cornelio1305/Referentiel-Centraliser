<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Script;
use App\Models\ScriptView;
use App\Models\Favorite;

class ScriptController extends Controller
{
    /**
     * Afficher la liste de tous les scripts
     */
    public function index(Request $request)
    {
        $query = Script::with('creator');
        
        // Filtres
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Tri
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $query->orderBy($sort, $order);
        
        $scripts = $query->paginate(12);
        
        return view('scripts.index', compact('scripts'));
    }

    /**
     * Afficher le formulaire de création d'un nouveau script
     */
    public function create()
    {
        return view('scripts.create', [
            'title' => 'Nouveau Script',
            'message' => 'Créer un nouveau script'
        ]);
    }

    /**
     * Afficher seulement les scripts actifs
     */
    public function active()
    {
        return view('scripts.active', [
            'title' => 'Scripts Actifs',
            'message' => 'Liste des scripts actuellement actifs'
        ]);
    }

    /**
     * Afficher l'historique d'exécution des scripts
     */
    public function history()
    {
        return view('scripts.history', [
            'title' => 'Historique des Scripts',
            'message' => 'Historique d\'exécution des scripts'
        ]);
    }

    // Méthodes temporaires pour éviter les erreurs
    public function store(Request $request)
    {
        return redirect()->route('scripts.index')->with('success', 'Fonctionnalité en cours de développement');
    }

    public function show(Script $script)
    {
        $user = Auth::user();
        
        // Enregistrer la vue
        ScriptView::create([
            'user_id' => $user->id,
            'script_id' => $script->id,
            'viewed_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        // Incrémenter le compteur de vues
        $script->incrementViews();
        
        // Charger les relations
        $script->load(['creator', 'updater']);
        
        // Vérifier si l'utilisateur a mis en favori
        $isFavorited = $script->isFavoritedBy($user);
        
        return view('scripts.show', compact('script', 'isFavorited'));
    }

    public function edit($id)
    {
        return view('scripts.edit', [
            'title' => 'Modifier le Script',
            'message' => 'Modifier le script #' . $id,
            'id' => $id
        ]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('scripts.index')->with('success', 'Fonctionnalité en cours de développement');
    }

    public function destroy($id)
    {
        return redirect()->route('scripts.index')->with('success', 'Fonctionnalité en cours de développement');
    }
}
