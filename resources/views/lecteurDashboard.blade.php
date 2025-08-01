@extends('layouts.app')

@section('title', 'Dashboard Lecteur')

@section('content')
@include('partials.lecteur.lnavbar')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('partials.lecteur.lsidebar')

        <!-- Main content -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard Lecteur</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <span class="badge bg-info">Connecté en tant que Lecteur</span>
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
                                    <h5 class="card-title">Scripts Consultés</h5>
                                    <h3 class="mb-0">45</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-search fa-2x"></i>
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
                                    <h5 class="card-title">Favoris</h5>
                                    <h3 class="mb-0">12</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-heart fa-2x"></i>
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
                                    <h5 class="card-title">Cette Semaine</h5>
                                    <h3 class="mb-0">8</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar-week fa-2x"></i>
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
                                    <h5 class="card-title">Nouveaux Scripts</h5>
                                    <h3 class="mb-0">5</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-star fa-2x"></i>
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
                                    <a href="{{ route('lecteur.scripts') }}" class="btn btn-primary w-100">
                                        <i class="fas fa-search me-2"></i>Rechercher Scripts
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('lecteur.favorites') }}" class="btn btn-danger w-100">
                                        <i class="fas fa-heart me-2"></i>Mes Favoris
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('lecteur.history') }}" class="btn btn-info w-100">
                                        <i class="fas fa-history me-2"></i>Historique
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('lecteur.profile') }}" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-user me-2"></i>Mon Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scripts populaires -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Scripts Populaires</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">Script de Configuration Réseau</h6>
                                            <p class="card-text text-muted">Configuration automatique des paramètres réseau</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Par: Admin</small>
                                                <div>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <small class="text-muted">4.8</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                                            <button class="btn btn-sm btn-outline-danger float-end">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">Script de Sauvegarde</h6>
                                            <p class="card-text text-muted">Sauvegarde automatique des données importantes</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Par: Éditeur1</small>
                                                <div>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <small class="text-muted">4.6</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                                            <button class="btn btn-sm btn-outline-danger float-end">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">Script de Monitoring</h6>
                                            <p class="card-text text-muted">Surveillance des performances système</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Par: Éditeur2</small>
                                                <div>
                                                    <i class="fas fa-star text-warning"></i>
                                                    <small class="text-muted">4.9</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                                            <button class="btn btn-sm btn-outline-danger float-end">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scripts récemment consultés -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Récemment Consultés</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nom du Script</th>
                                            <th>Auteur</th>
                                            <th>Dernière Consultation</th>
                                            <th>Note</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Script de Configuration Réseau</td>
                                            <td>Admin</td>
                                            <td>Il y a 2 heures</td>
                                            <td><i class="fas fa-star text-warning"></i> 4.8</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-heart"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Script de Sauvegarde Automatique</td>
                                            <td>Éditeur1</td>
                                            <td>Hier</td>
                                            <td><i class="fas fa-star text-warning"></i> 4.6</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-heart"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Script de Monitoring Système</td>
                                            <td>Éditeur2</td>
                                            <td>Il y a 3 jours</td>
                                            <td><i class="fas fa-star text-warning"></i> 4.9</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">Voir</a>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-heart"></i>
                                                </button>
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
