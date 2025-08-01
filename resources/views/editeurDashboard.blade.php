@extends('layouts.app')

@section('title', 'Dashboard Éditeur')

@section('content')
@include('partials.editeur.enavbar')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('partials.editeur.esidebar')

        <!-- Main content -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard Éditeur</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <span class="badge bg-success">Connecté en tant qu'Éditeur</span>
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
                                    <h5 class="card-title">Scripts Créés</h5>
                                    <h3 class="mb-0">12</h3>
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
                                    <h3 class="mb-0">8</h3>
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
                                    <h5 class="card-title">En Révision</h5>
                                    <h3 class="mb-0">3</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x"></i>
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
                                    <h5 class="card-title">Vues Totales</h5>
                                    <h3 class="mb-0">1,247</h3>
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
                                    <a href="{{ route('scripts.create') }}" class="btn btn-primary w-100">
                                        <i class="fas fa-plus-circle me-2"></i>Nouveau Script
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('scripts.index') }}" class="btn btn-secondary w-100">
                                        <i class="fas fa-list me-2"></i>Voir Mes Scripts
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('editeur.reports') }}" class="btn btn-info w-100">
                                        <i class="fas fa-chart-bar me-2"></i>Mes Rapports
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('editeur.profile') }}" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-user-edit me-2"></i>Mon Profil
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
                                            <th>Statut</th>
                                            <th>Date de Création</th>
                                            <th>Vues</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Script de Configuration Réseau</td>
                                            <td><span class="badge bg-success">Actif</span></td>
                                            <td>2024-01-15</td>
                                            <td>156</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary">Modifier</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Script de Sauvegarde Automatique</td>
                                            <td><span class="badge bg-warning">En Révision</span></td>
                                            <td>2024-01-14</td>
                                            <td>89</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary">Modifier</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Script de Monitoring Système</td>
                                            <td><span class="badge bg-success">Actif</span></td>
                                            <td>2024-01-13</td>
                                            <td>234</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary">Modifier</a>
                                            </td>
                                        </tr>
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
