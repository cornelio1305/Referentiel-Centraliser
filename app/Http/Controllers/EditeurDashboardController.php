<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Script;

class EditeurDashboardController extends Controller
{
    public function index()
    {
        $menuItems = [
            [
                'label' => 'Tableau de bord',
                'icon' => 'fas fa-tachometer-alt',
                'route' => 'editeur.dashboard',
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
                        'label' => 'Mes Scripts',
                        'route' => 'scripts.index',
                        'icon' => 'fas fa-user-edit'
                    ],
                ],
            ],
            [
                'label' => 'Mon Profil',
                'icon' => 'fas fa-user-edit',
                'route' => 'profile.show',
            ],
            [
                'label' => 'Déconnexion',
                'icon' => 'fas fa-sign-out-alt',
                'action' => 'logout',
            ],
        ];

        // Statistiques pour l'éditeur
        $stats = [
            'total_scripts' => Script::count(),
            'my_scripts' => Script::where('created_by', auth()->id())->count(),
            'active_scripts' => Script::where('status', 'active')->count(),
            'draft_scripts' => Script::where('status', 'draft')->count(),
            'my_active_scripts' => Script::where('created_by', auth()->id())
                ->where('status', 'active')
                ->count(),
        ];

        // Scripts récents de l'éditeur
        $recentScripts = Script::where('created_by', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Mes scripts par base de données
        $myScriptsByDb = Script::where('created_by', auth()->id())
            ->selectRaw('db_target, count(*) as total')
            ->groupBy('db_target')
            ->get();

        return view('editeurDashboard', compact('menuItems', 'stats', 'recentScripts', 'myScriptsByDb'));
    }
}
