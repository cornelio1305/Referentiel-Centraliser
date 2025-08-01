<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


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
                'route' => 'dashboard',
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
                'label' => 'Utilisateurs',
                'icon' => 'fas fa-users',
                'route' => 'users.index',
                'children' => [
                    [
                        'label' => 'Tous les Utilisateurs',
                        'route' => 'users.index',
                        'icon' => 'fas fa-list'
                    ],
                    [
                        'label' => 'Ajout Utilisateur',
                        'route' => 'users.create',
                        'icon' => 'fas fa-user-plus'
                    ],
                ],
            ],
            [
                'label' => 'Rapports',
                'icon' => 'fas fa-chart-bar',
                'route' => 'reports.index',
            ],

            [
                'label' => 'Déconnexion',
                'icon' => 'fas fa-sign-out-alt',
                'action' => 'logout',
            ],
        ];

        return view('dashboard', compact('menuItems'));
    }
}
