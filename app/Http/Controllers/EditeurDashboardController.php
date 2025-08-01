<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                        'label' => 'Scripts Actifs',
                        'route' => 'scripts.active',
                        'icon' => 'fas fa-play-circle'
                    ],
                    [
                        'label' => 'Historique',
                        'route' => 'scripts.history',
                        'icon' => 'fas fa-history'
                    ],
                ],
            ],
            [
                'label' => 'Mes Rapports',
                'icon' => 'fas fa-chart-bar',
                'route' => 'editeur.reports',
            ],
            [
                'label' => 'Mon Profil',
                'icon' => 'fas fa-user-edit',
                'route' => 'editeur.profile',
            ],
            [
                'label' => 'Déconnexion',
                'icon' => 'fas fa-sign-out-alt',
                'action' => 'logout',
            ],
        ];

        return view('editeurDashboard', compact('menuItems'));
    }
}
