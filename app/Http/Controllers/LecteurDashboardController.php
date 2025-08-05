<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Script;

class LecteurDashboardController extends Controller
{
    public function index()
    {
        $menuItems = [
            [
                'label' => 'Tableau de bord',
                'icon' => 'fas fa-tachometer-alt',
                'route' => 'lecteur.dashboard',
            ],
            [
                'label' => 'Consulter les Scripts',
                'icon' => 'fas fa-search',
                'route' => 'scripts.index',
            ],
            [
                'label' => 'Recherche Avancée',
                'icon' => 'fas fa-search-plus',
                'route' => 'scripts.search',
            ],
            [
                'label' => 'Mon Profil',
                'icon' => 'fas fa-user',
                'route' => 'profile.show',
            ],
            [
                'label' => 'Déconnexion',
                'icon' => 'fas fa-sign-out-alt',
                'action' => 'logout',
            ],
        ];

        // Statistiques pour le lecteur
        $stats = [
            'total_scripts' => Script::count(),
            'active_scripts' => Script::where('status', 'active')->count(),
            'recent_scripts' => Script::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        // Scripts populaires (les plus consultés)
        $popularScripts = Script::with('creator')
            ->withCount('views')
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        return view('lecteurDashboard', compact('menuItems', 'stats', 'popularScripts'));
    }
}
