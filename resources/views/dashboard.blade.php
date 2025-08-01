@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
@include('partials.admin.anavbar')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
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
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Total Scripts</h5>
                                    <h3 class="mb-0">{{ \App\Models\Script::count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-code fa-2x"></i>
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
                                    <h5 class="card-title">Scripts Actifs</h5>
                                    <h3 class="mb-0">{{ \App\Models\Script::where('status', 'active')->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-play-circle fa-2x"></i>
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
                                    <h5 class="card-title">Total Utilisateurs</h5>
                                    <h3 class="mb-0">{{ \App\Models\User::count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Total Vues</h5>
                                    <h3 class="mb-0">{{ \App\Models\ScriptView::count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-eye fa-2x"></i>
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
                                    <a href="{{ route('utilisateurs.index') }}" class="btn btn-danger w-100">
                                        <i class="fas fa-users me-2"></i>Gérer Utilisateurs
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('scripts.index') }}" class="btn btn-secondary w-100">
                                        <i class="fas fa-code me-2"></i>Gérer Scripts
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('reports.index') }}" class="btn btn-info w-100">
                                        <i class="fas fa-chart-bar me-2"></i>Rapports
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('users.create') }}" class="btn btn-outline-danger w-100">
                                        <i class="fas fa-user-plus me-2"></i>Nouvel Utilisateur
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scripts récents -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Scripts Récents</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nom du Script</th>
                                            <th>Créateur</th>
                                            <th>Statut</th>
                                            <th>Catégorie</th>
                                            <th>Vues</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(\App\Models\Script::with('creator')->latest()->limit(5)->get() as $script)
                                        <tr>
                                            <td>{{ $script->name }}</td>
                                            <td>{{ $script->creator->name ?? 'N/A' }}</td>
                                            <td>
                                                @switch($script->status)
                                                    @case('active')
                                                        <span class="badge bg-success">Actif</span>
                                                        @break
                                                    @case('draft')
                                                        <span class="badge bg-secondary">Brouillon</span>
                                                        @break
                                                    @case('in_review')
                                                        <span class="badge bg-warning">En Révision</span>
                                                        @break
                                                    @case('archived')
                                                        <span class="badge bg-dark">Archivé</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{ $script->category ?? 'N/A' }}</td>
                                            <td>{{ $script->views_count }}</td>
                                            <td>
                                                <a href="{{ route('scripts.show', $script->id) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                                                <a href="{{ route('scripts.edit', $script->id) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
