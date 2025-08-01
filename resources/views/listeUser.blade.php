@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- En-tête avec design moderne -->
            <div class="d-flex align-items-center mb-5">
                <div class="bg-primary rounded-circle p-3 me-3">
                    <i class="fas fa-users text-white fa-lg"></i>
                </div>
                <div>
                    <h2 class="mb-1 fw-bold text-dark">Gestion des Utilisateurs</h2>
                    <p class="text-muted mb-0">Administrez les comptes utilisateurs de votre plateforme</p>
                </div>
            </div>

            <!-- Message de succès avec style moderne -->
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4" style="border-left: 4px solid #28a745 !important;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Carte avec tableau -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white border-bottom-0 py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold text-dark">
                            <i class="fas fa-list me-2 text-primary"></i>
                            Liste des Utilisateurs
                        </h5>
                        <span class="badge bg-primary px-3 py-2 rounded-pill">
                            {{ count($users) }} utilisateur{{ count($users) > 1 ? 's' : '' }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th class="border-0 py-3 px-4 fw-semibold text-dark">
                                        <i class="fas fa-user me-2 text-muted"></i>Nom
                                    </th>
                                    <th class="border-0 py-3 px-4 fw-semibold text-dark">
                                        <i class="fas fa-envelope me-2 text-muted"></i>Email
                                    </th>
                                    <th class="border-0 py-3 px-4 fw-semibold text-dark">
                                        <i class="fas fa-shield-alt me-2 text-muted"></i>Rôle
                                    </th>
                                    <th class="border-0 py-3 px-4 fw-semibold text-dark text-center">
                                        <i class="fas fa-cogs me-2 text-muted"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr class="border-bottom">
                                    <td class="py-4 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <span class="fw-medium text-dark">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="text-muted">{{ $user->email }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        @php
                                            $roleBadges = [
                                                'admin' => 'bg-danger text-white',
                                                'user' => 'bg-success text-white',
                                                'moderator' => 'bg-warning text-dark',
                                                'super admin' => 'bg-dark text-white',
                                                'default' => 'bg-secondary text-white'
                                            ];
                                            $badgeClass = $roleBadges[strtolower($user->role)] ?? $roleBadges['default'];
                                        @endphp
                                        <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        @if(strtolower($user->role) !== 'admin')
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('utilisateurs.edit', $user->id) }}"
                                                class="btn btn-outline-warning btn-sm rounded-pill me-2 px-3">
                                                    <i class="fas fa-edit me-1"></i>Modifier
                                                </a>
                                                <form action="{{ route('utilisateurs.destroy', $user->id) }}"
                                                    method="POST"
                                                    style="display:inline-block;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                                        <i class="fas fa-trash-alt me-1"></i>Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted">Aucune action</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pied de carte -->
                <div class="card-footer bg-light border-top-0 py-3">
                    <div class="d-flex justify-content-between align-items-center text-muted">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            Dernière mise à jour: {{ date('d/m/Y à H:i') }}
                        </small>
                        <small>
                            <i class="fas fa-database me-1"></i>
                            Total: {{ count($users) }} enregistrement{{ count($users) > 1 ? 's' : '' }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles CSS personnalisés -->
<style>
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transform: translateY(-1px);
        transition: all 0.3s ease;
    }

    .card {
        border-radius: 15px;
        overflow: hidden;
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .alert {
        border-radius: 10px;
    }

    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .bg-primary {
        background: linear-gradient(135deg, #007bff, #0056b3) !important;
    }
</style>

<!-- Inclusion de Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
