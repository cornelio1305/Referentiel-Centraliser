@php
    $user = auth()->user();
    $role = $user->role ?? 'lecteur';

    // Configuration des couleurs par rôle
    $roleConfig = [
        'admin' => [
            'title' => 'Administration',
            'bg_gradient' => 'linear-gradient(180deg, #343a40 0%, #495057 100%)',
            'border_color' => '#dc3545',
            'text_color' => '#ffffff',
            'icon_color' => '#dc3545',
            'hover_bg' => 'rgba(220, 53, 69, 0.2)',
            'active_bg' => '#dc3545',
            'logo_border' => '#dc3545',
            'logo_shadow' => 'rgba(220, 53, 69, 0.3)'
        ],
        'editeur' => [
            'title' => 'Éditeur Panel',
            'bg_gradient' => 'linear-gradient(135deg, #e3f2fd, #bbdefb)',
            'border_color' => '#2196f3',
            'text_color' => '#212529',
            'icon_color' => '#2196f3',
            'hover_bg' => 'rgba(33, 150, 243, 0.15)',
            'active_bg' => 'rgba(33, 150, 243, 0.2)',
            'logo_border' => '#2196f3',
            'logo_shadow' => 'rgba(33, 150, 243, 0.2)'
        ],
        'lecteur' => [
            'title' => 'Lecteur Panel',
            'bg_gradient' => 'linear-gradient(135deg, #e8f5e8, #c8e6c9)',
            'border_color' => '#28a745',
            'text_color' => '#212529',
            'icon_color' => '#28a745',
            'hover_bg' => 'rgba(40, 167, 69, 0.15)',
            'active_bg' => 'rgba(40, 167, 69, 0.2)',
            'logo_border' => '#28a745',
            'logo_shadow' => 'rgba(40, 167, 69, 0.2)'
        ]
    ];

    $config = $roleConfig[$role];

    // Configuration des menus par rôle
    $menuConfig = [
        'admin' => [
            [
                'label' => 'Tableau de bord',
                'route' => 'dashboard',
                'icon' => 'fas fa-tachometer-alt'
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
                        'route' => 'scripts.versions',
                        'icon' => 'fas fa-history'
                    ],
                ],
            ],
            [
                'label' => 'Gestion des Utilisateurs',
                'route' => 'utilisateurs.index',
                'icon' => 'fas fa-users'
            ],
            [
                'label' => 'Import/Export',
                'route' => 'import-export.index',
                'icon' => 'fas fa-exchange-alt'
            ],
            [
                'label' => 'Rapports',
                'route' => 'reports.index',
                'icon' => 'fas fa-chart-bar'
            ],
            [
                'label' => 'Mon Profil',
                'route' => 'profile.show',
                'icon' => 'fas fa-user'
            ]
        ],
        'editeur' => [
            [
                'label' => 'Tableau de bord',
                'route' => 'editeur.dashboard',
                'icon' => 'fas fa-tachometer-alt'
            ],
            [
                'label' => 'Gestion des Scripts',
                'route' => 'scripts.index',
                'icon' => 'fas fa-code'
            ],
            [
                'label' => 'Import/Export',
                'route' => 'import-export.index',
                'icon' => 'fas fa-exchange-alt'
            ],
            [
                'label' => 'Rapports',
                'route' => 'reports.index',
                'icon' => 'fas fa-chart-bar'
            ],
            [
                'label' => 'Mon Profil',
                'route' => 'profile.show',
                'icon' => 'fas fa-user'
            ]
        ],
        'lecteur' => [
            [
                'label' => 'Tableau de bord',
                'route' => 'lecteur.dashboard',
                'icon' => 'fas fa-tachometer-alt'
            ],
            [
                'label' => 'Consulter les Scripts',
                'route' => 'scripts.index',
                'icon' => 'fas fa-search'
            ],
            [
                'label' => 'Mes Favoris',
                'route' => '', // Route vide pour éviter l'erreur
                'icon' => 'fas fa-heart'
            ],
            [
                'label' => 'Mon Profil',
                'route' => 'profile.show',
                'icon' => 'fas fa-user'
            ]
        ]
    ];

    $menuItems = $menuConfig[$role];
@endphp

<div class="sidebar sidebar-custom text-dark p-3" style="width: 250px; height: 100vh; position: fixed; top: 0; z-index: 1000;">
    <!-- Logo circulaire centré -->
    <div class="logo-container mb-4 mx-auto">
        <div class="logo-circle">
            <img src="{{ asset('images/ceet_officiel_logo-removebg-preview.png') }}" alt="Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
            <i class="fas fa-building fa-3x" style="display: none; color: {{ $config['border_color'] }};"></i>
        </div>
    </div>

    <h4 class="text-center mb-4 fw-bold">{{ $config['title'] }}</h4>

    <ul class="nav flex-column">
        @foreach ($menuItems as $index => $item)
            @php
                $hasRoute = !empty($item['route']);
                $hasChildren = isset($item['children']) && !empty($item['children']);
                $isActive = $hasRoute && request()->routeIs($item['route']);
                $uniqueId = 'submenu-' . $index;
            @endphp

            <li class="nav-item">
                @if($hasChildren)
                    <!-- Menu avec sous-menu -->
                    <a class="nav-link dropdown-toggle {{ $isActive ? 'active' : '' }}"
                       href="#"
                       data-bs-toggle="collapse"
                       data-bs-target="#{{ $uniqueId }}"
                       aria-expanded="false">
                        <i class="{{ $item['icon'] ?? 'fas fa-link' }}"></i>
                        {{ $item['label'] }}
                        <i class="fas fa-chevron-down ms-auto toggle-icon"></i>
                    </a>

                    <!-- Sous-menu -->
                    <div class="collapse" id="{{ $uniqueId }}">
                        <ul class="nav flex-column ms-3">
                            @foreach($item['children'] as $child)
                                @php
                                    $childHasRoute = !empty($child['route']);
                                    $childIsActive = $childHasRoute && request()->routeIs($child['route']);
                                @endphp

                                <li class="nav-item">
                                    @if($childHasRoute)
                                        <a class="nav-link sub-nav-link {{ $childIsActive ? 'active' : '' }}"
                                           href="{{ route($child['route']) }}">
                                            <i class="{{ $child['icon'] ?? 'fas fa-circle' }}"></i>
                                            {{ $child['label'] }}
                                        </a>
                                    @else
                                        <span class="nav-link sub-nav-link text-muted">
                                            <i class="{{ $child['icon'] ?? 'fas fa-ban' }}"></i>
                                            {{ $child['label'] }}
                                        </span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @elseif($hasRoute)
                    <!-- Menu simple avec route -->
                    <a class="nav-link {{ $isActive ? 'active' : '' }}"
                       href="{{ route($item['route']) }}">
                        <i class="{{ $item['icon'] ?? 'fas fa-link' }}"></i> {{ $item['label'] }}
                    </a>
                @else
                    <!-- Menu désactivé -->
                    <span class="nav-link text-muted">
                        <i class="{{ $item['icon'] ?? 'fas fa-ban' }}"></i> {{ $item['label'] }}
                    </span>
                @endif
            </li>
        @endforeach

        <hr class="my-3" style="border-color: {{ $config['border_color'] }};">

        <!-- Déconnexion -->
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link bg-transparent border-0 w-100 text-start logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </li>
    </ul>
</div>

<style>
    .sidebar-custom {
        background: {{ $config['bg_gradient'] }} !important;
        border-right: 4px solid {{ $config['border_color'] }};
        box-shadow: 4px 0 15px {{ $config['logo_shadow'] }};
        position: relative;
    }

    .logo-container {
        text-align: center;
    }

    .logo-circle {
        width: 100px;
        height: 100px;
        background: white;
        border: 4px solid {{ $config['logo_border'] }};
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px {{ $config['logo_shadow'] }};
    }

    .logo-circle img {
        width: 90%;
        height: 90%;
        object-fit: cover;
        border-radius: 50%;
    }

    .sidebar-custom h4 {
        color: {{ $config['border_color'] }};
        text-shadow: 1px 1px 2px {{ $config['logo_shadow'] }};
        border-bottom: 2px solid {{ $config['border_color'] }};
        padding-bottom: 10px;
    }

    .sidebar-custom .nav-link {
        color: {{ $config['text_color'] }} !important;
        border-radius: 8px;
        margin: 4px 0;
        padding: 10px 12px;
        font-weight: 500;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .sidebar-custom .nav-link i {
        color: {{ $config['icon_color'] }};
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .sidebar-custom .nav-link:hover {
        background-color: {{ $config['hover_bg'] }} !important;
        border-left: 4px solid {{ $config['border_color'] }};
        transform: translateX(5px);
    }

    .sidebar-custom .nav-link.active {
        background-color: {{ $config['active_bg'] }} !important;
        font-weight: bold;
        border-left: 5px solid {{ $config['border_color'] }};
        color: {{ $config['text_color'] }} !important;
        box-shadow: 0 2px 8px {{ $config['logo_shadow'] }};
    }

    /* Styles pour les sous-menus */
    .sidebar-custom .sub-nav-link {
        font-size: 0.9em;
        padding: 8px 10px;
        margin: 2px 0;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .sidebar-custom .sub-nav-link i {
        font-size: 0.8em;
        margin-right: 8px;
        width: 16px;
    }

    .sidebar-custom .sub-nav-link:hover {
        background-color: {{ $config['hover_bg'] }} !important;
        border-left: 3px solid {{ $config['border_color'] }};
        transform: translateX(3px);
    }

    .sidebar-custom .sub-nav-link.active {
        background-color: {{ $config['active_bg'] }} !important;
        border-left: 4px solid {{ $config['border_color'] }};
        font-weight: 600;
    }

    /* Animation de l'icône chevron */
    .dropdown-toggle .toggle-icon {
        transition: transform 0.2s ease;
        font-size: 0.8em;
    }

    .dropdown-toggle[aria-expanded="true"] .toggle-icon {
        transform: rotate(180deg);
    }

    .logout-btn:hover {
        background-color: {{ $config['hover_bg'] }} !important;
        border-left: 4px solid {{ $config['border_color'] }};
    }

    .sidebar-custom hr {
        border-color: {{ $config['border_color'] }};
        margin: 1rem 0.5rem;
    }

    /* Styles pour Bootstrap collapse */
    .collapse {
        transition: height 0.3s ease;
    }
</style>

<script>
// Script pour gérer l'animation des sous-menus
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('[data-bs-toggle="collapse"]');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();

            const target = document.querySelector(this.getAttribute('data-bs-target'));
            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            // Toggle l'état
            this.setAttribute('aria-expanded', !isExpanded);

            // Toggle la classe collapse
            if (isExpanded) {
                target.classList.add('collapse');
                target.classList.remove('show');
            } else {
                target.classList.remove('collapse');
                target.classList.add('show');
            }
        });
    });
});
</script>
