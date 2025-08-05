@php
    $user = auth()->user();
    $role = $user->role ?? 'lecteur';

    // Configuration des couleurs par rôle
    $roleConfig = [
        'admin' => [
            'title' => 'Admin',
            'bg_gradient' => 'linear-gradient(135deg, #ffcdd2, #ef9a9a)',
            'border_color' => '#dc3545',
            'text_color' => '#c82333',
            'shadow_color' => 'rgba(220, 53, 69, 0.2)',
            'hover_color' => 'rgba(220, 53, 69, 0.1)'
        ],
        'editeur' => [
            'title' => 'Éditeur',
            'bg_gradient' => 'linear-gradient(135deg, #e3f2fd, #bbdefb)',
            'border_color' => '#2196f3',
            'text_color' => '#1976d2',
            'shadow_color' => 'rgba(33, 150, 243, 0.2)',
            'hover_color' => 'rgba(33, 150, 243, 0.1)'
        ],
        'lecteur' => [
            'title' => 'Lecteur',
            'bg_gradient' => 'linear-gradient(135deg, #e8f5e8, #c8e6c9)',
            'border_color' => '#28a745',
            'text_color' => '#1e7e34',
            'shadow_color' => 'rgba(40, 167, 69, 0.2)',
            'hover_color' => 'rgba(40, 167, 69, 0.1)'
        ]
    ];

    $config = $roleConfig[$role];
@endphp

<nav class="navbar navbar-expand-lg navbar-light navbar-custom ps-3" style="margin-left: 250px;">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold" style="color: {{ $config['text_color'] }};">
            {{ $config['title'] }} – {{ $user->name ?? 'Nom inconnu' }}
        </span>

        <ul class="navbar-nav ms-auto me-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-dark" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle me-1"></i> {{ $user->name ?? 'User' }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user me-1"></i> Profil</a></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('password.change.form') }}">
                            <i class="fas fa-key me-1"></i> Modifier le mot de passe
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-1"></i> Déconnexion</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<style>
    .navbar-custom {
        background: {{ $config['bg_gradient'] }} !important;
        border-bottom: 4px solid {{ $config['border_color'] }};
        box-shadow: 0 2px 10px {{ $config['shadow_color'] }};
        height: 70px;
    }

    .navbar-custom .navbar-brand {
        font-size: 1.2rem;
        color: {{ $config['text_color'] }};
        text-shadow: 1px 1px rgba(255, 255, 255, 0.3);
    }

    .navbar-custom .nav-link {
        font-weight: 500;
    }

    .navbar-custom .dropdown-menu {
        border: 1px solid {{ $config['border_color'] }};
        border-radius: 8px;
    }

    .navbar-custom .dropdown-item:hover {
        background-color: {{ $config['hover_color'] }};
        color: {{ $config['border_color'] }};
    }
</style>
