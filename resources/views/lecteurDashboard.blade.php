@extends('layouts.app')

@section('title', 'Dashboard Lecteur')

@section('content')
@include('partials.navbar')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('partials.sidebar')

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

            <!-- Message de bienvenue -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h4>Bienvenue sur votre tableau de bord Lecteur</h4>
                            <p class="text-muted">Vous êtes connecté en tant que lecteur. Les fonctionnalités de consultation des scripts seront bientôt disponibles.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Actions Disponibles</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <a href="{{ route('profile.show') }}" class="btn btn-warning w-100">
                                        <i class="fas fa-user me-2"></i>Mon Profil
                                    </a>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="fas fa-search me-2"></i>Consulter Scripts (Bientôt)
                                    </button>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
