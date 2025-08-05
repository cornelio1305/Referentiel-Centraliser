@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Scripts par Base de Données</h4>
                    <div>
                        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                        <form method="POST" action="{{ route('reports.export') }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="type" value="scripts-by-database">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-download me-2"></i>Exporter CSV
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Base de Données</th>
                                            <th>Nombre de Scripts</th>
                                            <th>Pourcentage</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($stats as $stat)
                                        <tr>
                                            <td>
                                                <strong>{{ $stat->db_target ? ucfirst($stat->db_target) : 'Non spécifié' }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary fs-6">{{ $stat->total }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $percentage = $stats->sum('total') > 0 ? round(($stat->total / $stats->sum('total')) * 100, 1) : 0;
                                                @endphp
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar"
                                                         style="width: {{ $percentage }}%"
                                                         aria-valuenow="{{ $percentage }}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100">
                                                        {{ $percentage }}%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('scripts.index', ['db_target' => $stat->db_target]) }}"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>Voir les scripts
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <i class="fas fa-database fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Aucune donnée disponible</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Résumé</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <h3 class="text-primary">{{ $stats->sum('total') }}</h3>
                                        <p class="text-muted">Total des scripts</p>
                                    </div>
                                    <hr>
                                    <div class="small">
                                        <p><strong>Base la plus utilisée:</strong></p>
                                        @if($stats->count() > 0)
                                            @php
                                                $mostUsed = $stats->sortByDesc('total')->first();
                                            @endphp
                                            <p class="text-primary">
                                                {{ $mostUsed->db_target ? ucfirst($mostUsed->db_target) : 'Non spécifié' }}
                                                ({{ $mostUsed->total }} scripts)
                                            </p>
                                        @else
                                            <p class="text-muted">Aucune donnée</p>
                                        @endif
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
