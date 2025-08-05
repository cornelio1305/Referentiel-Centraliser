@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">Historique des versions : {{ $script->name }}</h4>
                        <small class="text-muted">Version actuelle : {{ $script->version }}</small>
                    </div>
                    <div>
                        <a href="{{ route('scripts.show', $script) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour au script
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Version</th>
                                    <th>Description</th>
                                    <th>Raison du changement</th>
                                    <th>Créé par</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($versions as $version)
                                <tr>
                                    <td>
                                        <span class="badge bg-info fs-6">{{ $version->version }}</span>
                                        @if($version->version === $script->version)
                                            <span class="badge bg-success ms-1">Actuelle</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($version->description)
                                            {{ Str::limit($version->description, 100) }}
                                        @else
                                            <span class="text-muted">Aucune description</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($version->change_reason)
                                            <span class="text-primary">{{ $version->change_reason }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $version->creator->name }}</td>
                                    <td>{{ $version->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                    onclick="showVersionContent('{{ $version->id }}', '{{ $version->version }}')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editeur')
                                            @if($version->version !== $script->version)
                                            <form method="POST" action="{{ route('scripts.restore', [$script, $version]) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning"
                                                        onclick="return confirm('Restaurer cette version ? Cela créera une nouvelle version avec le contenu de cette version.')">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                            @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Aucune version trouvée</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour afficher le contenu d'une version -->
<div class="modal fade" id="versionModal" tabindex="-1" aria-labelledby="versionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="versionModalLabel">Contenu de la version</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="versionContent">
                    <!-- Le contenu sera chargé ici -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
function showVersionContent(versionId, versionNumber) {
    // Ici vous pourriez faire un appel AJAX pour récupérer le contenu
    // Pour l'instant, on affiche juste un message
    document.getElementById('versionModalLabel').textContent = `Contenu de la version ${versionNumber}`;
    document.getElementById('versionContent').innerHTML = `
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Le contenu de la version ${versionNumber} sera affiché ici.
            <br><small>Cette fonctionnalité sera implémentée pour afficher le contenu SQL de la version sélectionnée.</small>
        </div>
    `;

    const modal = new bootstrap.Modal(document.getElementById('versionModal'));
    modal.show();
}
</script>
@endsection
