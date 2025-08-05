@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Rapports et Statistiques</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Scripts par Base de Données -->
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card text-white bg-primary">
                                <div class="card-body text-center">
                                    <i class="fas fa-database fa-3x mb-3"></i>
                                    <h5 class="card-title">Scripts par Base</h5>
                                    <p class="card-text">Répartition des scripts par type de base de données</p>
                                    <a href="{{ route('reports.scripts-by-database') }}" class="btn btn-light">
                                        <i class="fas fa-chart-pie me-2"></i>Voir le rapport
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Utilisation des Scripts -->
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card text-white bg-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-chart-line fa-3x mb-3"></i>
                                    <h5 class="card-title">Utilisation Scripts</h5>
                                    <p class="card-text">Scripts les plus consultés et leur popularité</p>
                                    <a href="{{ route('reports.script-usage') }}" class="btn btn-light">
                                        <i class="fas fa-chart-bar me-2"></i>Voir le rapport
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Activité Utilisateurs -->
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card text-white bg-warning">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-clock fa-3x mb-3"></i>
                                    <h5 class="card-title">Activité Utilisateurs</h5>
                                    <p class="card-text">Activité et contribution des utilisateurs</p>
                                    <a href="{{ route('reports.user-activity') }}" class="btn btn-light">
                                        <i class="fas fa-users me-2"></i>Voir le rapport
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Scripts par Statut -->
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card text-white bg-info">
                                <div class="card-body text-center">
                                    <i class="fas fa-tags fa-3x mb-3"></i>
                                    <h5 class="card-title">Scripts par Statut</h5>
                                    <p class="card-text">Répartition des scripts selon leur statut</p>
                                    <a href="{{ route('reports.scripts-by-status') }}" class="btn btn-light">
                                        <i class="fas fa-chart-pie me-2"></i>Voir le rapport
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Export de rapports -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-download me-2"></i>Export de Rapports</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('reports.export') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="report_type" class="form-label">Type de rapport</label>
                                                    <select class="form-control" id="report_type" name="type" required>
                                                        <option value="scripts-by-database">Scripts par Base de Données</option>
                                                        <option value="script-usage">Utilisation des Scripts</option>
                                                        <option value="user-activity">Activité des Utilisateurs</option>
                                                        <option value="scripts-by-status">Scripts par Statut</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">&nbsp;</label>
                                                    <button type="submit" class="btn btn-primary d-block">
                                                        <i class="fas fa-download me-2"></i>Exporter en CSV
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques rapides -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistiques Rapides</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 text-center">
                                            <div class="border rounded p-3">
                                                <i class="fas fa-code fa-2x text-primary mb-2"></i>
                                                <h4 class="text-primary">{{ \App\Models\Script::count() }}</h4>
                                                <p class="mb-0">Total Scripts</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <div class="border rounded p-3">
                                                <i class="fas fa-users fa-2x text-success mb-2"></i>
                                                <h4 class="text-success">{{ \App\Models\User::count() }}</h4>
                                                <p class="mb-0">Total Utilisateurs</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <div class="border rounded p-3">
                                                <i class="fas fa-eye fa-2x text-warning mb-2"></i>
                                                <h4 class="text-warning">{{ \App\Models\ScriptView::count() }}</h4>
                                                <p class="mb-0">Total Consultations</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <div class="border rounded p-3">
                                                <i class="fas fa-history fa-2x text-info mb-2"></i>
                                                <h4 class="text-info">{{ \App\Models\ScriptVersion::count() }}</h4>
                                                <p class="mb-0">Total Versions</p>
                                            </div>
                                        </div>
                                    </div>
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
