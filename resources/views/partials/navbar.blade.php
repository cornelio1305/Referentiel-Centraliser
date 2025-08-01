<nav class="navbar navbar-expand-lg navbar-light navbar-custom ps-3" style="margin-left: 250px;">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">
            @if(Auth::user()->isAdmin())
                <span class="text-danger">{{ ucfirst(auth()->user()->role ?? 'Utilisateur') }} – {{ auth()->user()->name ?? 'Nom inconnu' }}</span>
            @elseif(Auth::user()->isEditeur())
                <span class="text-primary">{{ ucfirst(auth()->user()->role ?? 'Utilisateur') }} – {{ auth()->user()->name ?? 'Nom inconnu' }}</span>
            @else
                <span class="text-success">{{ ucfirst(auth()->user()->role ?? 'Utilisateur') }} – {{ auth()->user()->name ?? 'Nom inconnu' }}</span>
            @endif
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
    @if(Auth::user()->isAdmin())
        background: linear-gradient(135deg, #ffcdd2, #ef9a9a) !important;
        border-bottom: 4px solid #dc3545;
        box-shadow: 0 2px 10px rgba(220, 53, 69, 0.2);
    @elseif(Auth::user()->isEditeur())
        background: linear-gradient(135deg, #e3f2fd, #bbdefb) !important;
        border-bottom: 4px solid #2196f3;
        box-shadow: 0 2px 10px rgba(33, 150, 243, 0.2);
    @else
        background: linear-gradient(135deg, #e8f5e8, #c8e6c9) !important;
        border-bottom: 4px solid #28a745;
        box-shadow: 0 2px 10px rgba(40, 167, 69, 0.2);
    @endif
    height: 70px;
}

.navbar-custom .navbar-brand {
    font-size: 1.2rem;
    @if(Auth::user()->isAdmin())
        color: #dc3545;
        text-shadow: 1px 1px rgba(255, 255, 255, 0.3);
    @elseif(Auth::user()->isEditeur())
        color: #1976d2;
        text-shadow: 1px 1px rgba(255, 255, 255, 0.3);
    @else
        color: #1e7e34;
        text-shadow: 1px 1px rgba(255, 255, 255, 0.3);
    @endif
}

.navbar-custom .nav-link {
    font-weight: 500;
}

.navbar-custom .dropdown-menu {
    @if(Auth::user()->isAdmin())
        border: 1px solid #dc3545;
    @elseif(Auth::user()->isEditeur())
        border: 1px solid #2196f3;
    @else
        border: 1px solid #28a745;
    @endif
    border-radius: 8px;
}

.navbar-custom .dropdown-item:hover {
    @if(Auth::user()->isAdmin())
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    @elseif(Auth::user()->isEditeur())
        background-color: rgba(33, 150, 243, 0.1);
        color: #2196f3;
    @else
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    @endif
}

  </style>
