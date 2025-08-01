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
                'label' => 'Consulter les Scripts',
                'icon' => 'fas fa-search',
                'route' => 'lecteur.scripts',
            ],
            [
                'label' => 'Mes Favoris',
                'icon' => 'fas fa-heart',
                'route' => 'lecteur.favorites',
            ],
            [
                'label' => 'Historique de Lecture',
                'icon' => 'fas fa-history',
                'route' => 'lecteur.history',
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
