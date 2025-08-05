@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Admin -->
        @include('partials.sidebar')

        <!-- Main content -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard Admin</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <span class="badge bg-danger">Connecté en tant qu'Admin</span>
                    </div>
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Total Utilisateurs</h5>
                                    <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Administrateurs</h5>
                                    <h3 class="mb-0">{{ $stats['admin_users'] }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-user-shield fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Éditeurs</h5>
                                    <h3 class="mb-0">{{ $stats['editeur_users'] }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-user-edit fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Lecteurs</h5>
                                    <h3 class="mb-0">{{ $stats['lecteur_users'] }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Actions Rapides</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('scripts.index') }}" class="btn btn-primary w-100">
                                        <i class="fas fa-code me-2"></i>Gérer Scripts
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('utilisateurs.index') }}" class="btn btn-danger w-100">
                                        <i class="fas fa-users me-2"></i>Gérer Utilisateurs
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('reports.index') }}" class="btn btn-info w-100">
                                        <i class="fas fa-chart-bar me-2"></i>Voir Rapports
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('profile.show') }}" class="btn btn-warning w-100">
                                        <i class="fas fa-user me-2"></i>Mon Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scripts récents -->
            @if($recentScripts->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Scripts Récents</h5>
                            <a href="{{ route('scripts.index') }}" class="btn btn-sm btn-outline-primary">Voir tous</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Version</th>
                                            <th>Base de données</th>
                                            <th>Auteur</th>
                                            <th>Statut</th>
                                            <th>Créé le</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentScripts as $script)
                                        <tr>
                                            <td>
                                                <a href="{{ route('scripts.show', $script) }}" class="text-decoration-none">
                                                    {{ $script->name }}
                                                </a>
                                            </td>
                                            <td><span class="badge bg-info">{{ $script->version }}</span></td>
                                            <td>
                                                @if($script->db_target)
                                                    <span class="badge bg-secondary">{{ $script->db_target_label }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $script->author ?? $script->creator->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $script->status === 'active' ? 'success' : ($script->status === 'draft' ? 'warning' : 'secondary') }}">
                                                    {{ $script->status_label }}
                                                </span>
                                            </td>
                                            <td>{{ $script->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Informations système -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Informations Système</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Statut de l'application</h6>
                                    <p class="text-success"><i class="fas fa-check-circle me-2"></i>Application opérationnelle</p>
                                    <p><strong>Version Laravel:</strong> {{ app()->version() }}</p>
                                    <p><strong>Environnement:</strong> {{ config('app.env') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Dernière activité</h6>
                                    <p><strong>Dernière connexion:</strong> {{ auth()->user()->updated_at->format('d/m/Y H:i') }}</p>
                                    <p><strong>Rôle:</strong> {{ ucfirst(auth()->user()->role) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
