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
