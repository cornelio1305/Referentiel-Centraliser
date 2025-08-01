<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         View::composer('partials.sidebar', function ($view) {
            $menuItems = [
                [
                    'icon' => 'fas fa-home',
                    'label' => 'Dashboard',
                    'route' => 'dashboard',
                    'children' => []
                ],
                [
                    'icon' => 'fas fa-users',
                    'label' => 'Utilisateurs',
                    'route' => 'users.index',
                    'children' => [
                        ['label' => 'Liste', 'route' => 'utilisateurs.index'],
                        ['label' => 'Créer', 'route' => 'users.create']
                    ]
                ],
                [
                    'icon' => 'fas fa-file-alt',
                    'label' => 'Rapports',
                    'route' => 'reports.index',
                    'children' => []
                ],
                [
                    'icon' => 'fas fa-sign-out-alt',
                    'label' => 'Déconnexion',
                    'route' => null, // Route POST, pas GET
                    'children' => [],
                    'action' => 'logout' // Pour traitement spécial
                ]
            ];

            $view->with('menuItems', $menuItems);
        });
    }

}
