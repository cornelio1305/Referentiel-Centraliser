<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Script;
use App\Models\User;
use App\Models\ScriptView;
use App\Models\Favorite;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return $this->adminReports();
        } elseif ($user->isEditeur()) {
            return $this->editeurReports();
        } else {
            return $this->lecteurReports();
        }
    }

    private function adminReports()
    {
        // Statistiques globales
        $totalScripts = Script::count();
        $activeScripts = Script::where('status', 'active')->count();
        $totalUsers = User::count();
        $totalViews = ScriptView::count();
        
        // Scripts par catégorie
        $scriptsByCategory = Script::selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->get();
        
        // Scripts par statut
        $scriptsByStatus = Script::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();
        
        // Utilisateurs par rôle
        $usersByRole = User::selectRaw('role, count(*) as count')
            ->groupBy('role')
            ->get();
        
        // Scripts les plus populaires
        $popularScripts = Script::with('creator')
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get();
        
        return view('reports.admin', compact(
            'totalScripts',
            'activeScripts',
            'totalUsers',
            'totalViews',
            'scriptsByCategory',
            'scriptsByStatus',
            'usersByRole',
            'popularScripts'
        ));
    }

    private function editeurReports()
    {
        $user = Auth::user();
        
        // Scripts de l'éditeur
        $myScripts = Script::where('created_by', $user->id)->count();
        $myActiveScripts = Script::where('created_by', $user->id)
            ->where('status', 'active')
            ->count();
        
        // Vues totales de mes scripts
        $myTotalViews = Script::where('created_by', $user->id)->sum('views_count');
        
        // Scripts par statut
        $myScriptsByStatus = Script::where('created_by', $user->id)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();
        
        // Mes scripts les plus populaires
        $myPopularScripts = Script::where('created_by', $user->id)
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get();
        
        // Activité récente
        $recentActivity = Script::where('created_by', $user->id)
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('reports.editeur', compact(
            'myScripts',
            'myActiveScripts',
            'myTotalViews',
            'myScriptsByStatus',
            'myPopularScripts',
            'recentActivity'
        ));
    }

    private function lecteurReports()
    {
        $user = Auth::user();
        
        // Statistiques du lecteur
        $scriptsViewed = $user->scriptViews()->count();
        $favoritesCount = $user->favorites()->count();
        $thisWeekViews = $user->scriptViews()
            ->whereBetween('viewed_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
        
        // Scripts récemment consultés
        $recentViews = $user->scriptViews()
            ->with('script.creator')
            ->orderBy('viewed_at', 'desc')
            ->limit(10)
            ->get();
        
        // Favoris
        $favorites = $user->favorites()
            ->with('script.creator')
            ->limit(10)
            ->get();
        
        // Catégories préférées
        $preferredCategories = $user->scriptViews()
            ->join('scripts', 'script_views.script_id', '=', 'scripts.id')
            ->selectRaw('scripts.category, count(*) as count')
            ->groupBy('scripts.category')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();
        
        return view('reports.lecteur', compact(
            'scriptsViewed',
            'favoritesCount',
            'thisWeekViews',
            'recentViews',
            'favorites',
            'preferredCategories'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'general');
        $format = $request->get('format', 'pdf');
        
        // Logique d'export selon le type et le format
        // Pour l'instant, retourner un message
        return back()->with('success', "Export $type en format $format en cours de développement");
    }
}
