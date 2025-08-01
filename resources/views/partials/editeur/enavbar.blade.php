<nav class="navbar navbar-expand-lg navbar-light navbar-custom ps-3" style="margin-left: 250px;">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold text-primary">
            Éditeur – {{ auth()->user()->name ?? 'Nom inconnu' }}
        </span>

        <ul class="navbar-nav ms-auto me-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-dark" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name ?? 'User' }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user me-1"></i> Profil</a></li>
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-1"></i> Modifier le profil</a></li>
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
        background: linear-gradient(135deg, #e3f2fd, #bbdefb) !important;
        border-bottom: 4px solid #2196f3;
        box-shadow: 0 2px 10px rgba(33, 150, 243, 0.2);
        height: 70px;
    }

    .navbar-custom .navbar-brand {
        font-size: 1.2rem;
        color: #1976d2;
        text-shadow: 1px 1px rgba(255, 255, 255, 0.3);
    }

    .navbar-custom .nav-link {
        font-weight: 500;
    }

    .navbar-custom .dropdown-menu {
        border: 1px solid #2196f3;
        border-radius: 8px;
    }

    .navbar-custom .dropdown-item:hover {
        background-color: rgba(33, 150, 243, 0.1);
        color: #2196f3;
    }
</style>
