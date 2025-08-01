<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                'label' => 'Mon Profil',
                'icon' => 'fas fa-user',
                'route' => 'lecteur.profile',
            ],
            [
                'label' => 'Déconnexion',
                'icon' => 'fas fa-sign-out-alt',
                'action' => 'logout',
            ],
        ];

        return view('lecteurDashboard', compact('menuItems'));
    }
}
