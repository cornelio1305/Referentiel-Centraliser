<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Script;
use App\Models\ScriptView;

class LecteurScriptController extends Controller
{
    public function index(Request $request)
    {
        $query = Script::with('creator')->where('status', 'active');
        
        // Recherche avancée
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filtres
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        // Tri
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        
        switch ($sort) {
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        $scripts = $query->paginate(12);
        $categories = Script::distinct()->pluck('category')->filter();
        
        return view('lecteur.scripts.index', compact('scripts', 'categories'));
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
        
        return view('lecteur.scripts.show', compact('script', 'isFavorited'));
    }

    public function favorites()
    {
        $favorites = Auth::user()->favorites()->with('script.creator')->paginate(10);
        return view('lecteur.favorites', compact('favorites'));
    }

    public function history()
    {
        $views = Auth::user()->scriptViews()->with('script.creator')
                ->orderBy('viewed_at', 'desc')
                ->paginate(15);
        
        return view('lecteur.history', compact('views'));
    }

    public function popular()
    {
        $scripts = Script::with('creator')
                ->where('status', 'active')
                ->orderBy('views_count', 'desc')
                ->limit(10)
                ->get();
        
        return view('lecteur.popular', compact('scripts'));
    }

    public function recent()
    {
        $scripts = Script::with('creator')
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        
        return view('lecteur.recent', compact('scripts'));
    }
}
