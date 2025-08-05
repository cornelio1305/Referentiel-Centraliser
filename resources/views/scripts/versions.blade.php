@extends('layouts.app')

@section('title', 'Gestion des Versions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- En-tête de la page -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-history text-primary"></i>
                        Gestion des Versions
                    </h1>
                    <p class="text-muted">Gérez les versions et l'historique de vos scripts</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('scripts.index') }}">Scripts</a>
                        </li>
                        <li class="breadcrumb-item active">Versions</li>
                    </ol>
                </nav>
            </div>

            <!-- Statistiques rapides -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Scripts Total
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalScripts ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-code fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Versions Total
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalVersions ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-code-branch fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Scripts Modifiés (7j)
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $recentlyModified ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Versions Moyennes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $averageVersions ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtres et recherche -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-filter"></i>
                        Filtres et Recherche
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Rechercher un script</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   placeholder="Nom, description..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="database" class="form-label">Base de données</label>
                            <select class="form-select" id="database" name="database">
                                <option value="">Toutes les bases</option>
                                <option value="production" {{ request('database') === 'production' ? 'selected' : '' }}>Production</option>
                                <option value="test" {{ request('database') === 'test' ? 'selected' : '' }}>Test</option>
                                <option value="development" {{ request('database') === 'development' ? 'selected' : '' }}>Développement</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="author" class="form-label">Auteur</label>
                            <select class="form-select" id="author" name="author">
                                <option value="">Tous les auteurs</option>
                                @if(isset($authors))
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                            {{ $author->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Rechercher
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tableau des scripts avec versions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table"></i>
                        Scripts et leurs Versions
                    </h6>
                    <div>
                        <button class="btn btn-success btn-sm me-2" onclick="exportVersions()">
                            <i class="fas fa-file-excel"></i> Exporter
                        </button>
                        <button class="btn btn-info btn-sm" onclick="refreshData()">
                            <i class="fas fa-sync-alt"></i> Actualiser
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="versionsTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Script</th>
                                    <th>Description</th>
                                    <th>Base de données</th>
                                    <th>Auteur</th>
                                    <th>Nb Versions</th>
                                    <th>Dernière Modif.</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($scripts ?? [] as $script)
                                    <tr>
                                        <td>
                                            <strong>{{ $script->name ?? 'Script sans nom' }}</strong>
                                            <br>
                                            <small class="text-muted">ID: {{ $script->id ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            <span title="{{ $script->description ?? 'Pas de description' }}">
                                                {{ Str::limit($script->description ?? 'Pas de description', 50) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $script->database ?? 'Non définie' }}
                                            </span>
                                        </td>
                                        <td>{{ $script->author->name ?? 'Inconnu' }}</td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{ $script->versions_count ?? 1 }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $script->updated_at ? $script->updated_at->diffForHumans() : 'Jamais' }}
                                            <br>
                                            <small class="text-muted">
                                                {{ $script->updated_at ? $script->updated_at->format('d/m/Y H:i') : '' }}
                                            </small>
                                        </td>
                                        <td>
                                            @if(isset($script->status))
                                                @if($script->status === 'active')
                                                    <span class="badge badge-success">Actif</span>
                                                @elseif($script->status === 'deprecated')
                                                    <span class="badge badge-warning">Déprécié</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $script->status }}</span>
                                                @endif
                                            @else
                                                <span class="badge badge-secondary">Non défini</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('scripts.history', $script->id ?? 1) }}"
                                                   class="btn btn-sm btn-outline-primary" title="Voir l'historique">
                                                    <i class="fas fa-history"></i>
                                                </a>
                                                <a href="{{ route('scripts.show', $script->id ?? 1) }}"
                                                   class="btn btn-sm btn-outline-info" title="Voir le script">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @can('update', $script ?? null)
                                                    <a href="{{ route('scripts.edit', $script->id ?? 1) }}"
                                                       class="btn btn-sm btn-outline-warning" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <br>
                                                Aucun script trouvé
                                                <br>
                                                <small>Essayez de modifier vos critères de recherche</small>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if(isset($scripts) && method_exists($scripts, 'links'))
                        <div class="d-flex justify-content-center">
                            {{ $scripts->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Actions Rapides</h6>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('scripts.create') }}" class="btn btn-success btn-block mb-2">
                                <i class="fas fa-plus"></i> Nouveau Script
                            </a>
                            <a href="{{ route('scripts.search') }}" class="btn btn-info btn-block mb-2">
                                <i class="fas fa-search"></i> Recherche Avancée
                            </a>
                            <a href="{{ route('import-export.index') }}" class="btn btn-warning btn-block">
                                <i class="fas fa-exchange-alt"></i> Import/Export
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Aide</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">
                                <strong>Gestion des versions :</strong>
                            </p>
                            <ul class="text-muted small">
                                <li>Consultez l'historique de chaque script</li>
                                <li>Comparez les différentes versions</li>
                                <li>Restaurez une version antérieure si nécessaire</li>
                                <li>Exportez les données de versioning</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportVersions() {
    window.location.href = '{{ route("reports.export") }}?type=versions';
}

function refreshData() {
    window.location.reload();
}

// Initialisation DataTables si disponible
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#versionsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
            },
            "pageLength": 25,
            "order": [[5, "desc"]], // Trier par dernière modification
            "columnDefs": [
                { "orderable": false, "targets": [7] } // Désactiver le tri sur les actions
            ]
        });
    }
});
</script>
@endpush

@push('styles')
<style>
.card {
    border-radius: 0.35rem;
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.badge {
    font-size: 0.8em;
}

.btn-group .btn {
    margin: 0 1px;
}

.table th {
    border-top: none;
    font-weight: 600;
    background-color: #f8f9fc;
}
</style>
@endpush
@endsection
