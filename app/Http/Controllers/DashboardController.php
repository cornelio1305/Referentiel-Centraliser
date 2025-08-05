<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Script;

class DashboardController extends Controller
{
    public function index()
    {
        $menuItems = [
            [
                'label' => 'Tableau de bord',
                'icon' => 'fas fa-tachometer-alt',
                'route' => 'dashboard',
            ],
            [
                'label' => 'Gestion des Scripts',
                'icon' => 'fas fa-code',
                'route' => 'scripts.index',
                'children' => [
                    [
                        'label' => 'Tous les Scripts',
                        'route' => 'scripts.index',
                        'icon' => 'fas fa-list-ul'
                    ],
                    [
                        'label' => 'Nouveau Script',
                        'route' => 'scripts.create',
                        'icon' => 'fas fa-plus-circle'
                    ],
                    [
                        'label' => 'Recherche Avancée',
                        'route' => 'scripts.search',
                        'icon' => 'fas fa-search'
                    ],
                    [
                        'label' => 'Import/Export',
                        'route' => 'import-export.index',
                        'icon' => 'fas fa-exchange-alt'
                    ],
                    [
                        'label' => 'Gestion des Versions',
                        'route' => 'scripts.index',
                        'icon' => 'fas fa-history'
                    ],
                ],
            ],
            [
                'label' => 'Gestion des Utilisateurs',
                'icon' => 'fas fa-users',
                'route' => 'utilisateurs.index',
            ],
            [
                'label' => 'Rapports',
                'icon' => 'fas fa-chart-bar',
                'route' => 'reports.index',
                'children' => [
                    [
                        'label' => 'Scripts par Base',
                        'route' => 'reports.scripts-by-database',
                        'icon' => 'fas fa-database'
                    ],
                    [
                        'label' => 'Utilisation Scripts',
                        'route' => 'reports.script-usage',
                        'icon' => 'fas fa-chart-line'
                    ],
                    [
                        'label' => 'Activité Utilisateurs',
                        'route' => 'reports.user-activity',
                        'icon' => 'fas fa-user-clock'
                    ],
                    [
                        'label' => 'Scripts par Statut',
                        'route' => 'reports.scripts-by-status',
                        'icon' => 'fas fa-tags'
                    ],
                ],
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

        // Statistiques complètes pour l'admin
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'editeur_users' => User::where('role', 'editeur')->count(),
            'lecteur_users' => User::where('role', 'lecteur')->count(),
            'total_scripts' => Script::count(),
            'active_scripts' => Script::where('status', 'active')->count(),
            'draft_scripts' => Script::where('status', 'draft')->count(),
            'archived_scripts' => Script::where('status', 'archived')->count(),
        ];

        // Scripts récents
        $recentScripts = Script::with('creator')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Scripts par base de données
        $scriptsByDb = Script::selectRaw('db_target, count(*) as total')
            ->groupBy('db_target')
            ->get();

        return view('dashboard', compact('menuItems', 'stats', 'recentScripts', 'scriptsByDb'));
    }
}
