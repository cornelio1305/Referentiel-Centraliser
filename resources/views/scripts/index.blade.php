@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Gestion des Scripts</h4>
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editeur')
                    <a href="{{ route('scripts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nouveau Script
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    <!-- Filtres -->
                    <form method="GET" action="{{ route('scripts.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-control">
                                    <option value="">Tous les statuts</option>
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="db_target" class="form-control">
                                    <option value="">Toutes les bases</option>
                                    @foreach($dbTargets as $value => $label)
                                        <option value="{{ $value }}" {{ request('db_target') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="author" class="form-control" placeholder="Auteur" value="{{ request('author') }}">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-secondary me-2">
                                    <i class="fas fa-search me-1"></i>Filtrer
                                </button>
                                <a href="{{ route('scripts.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Réinitialiser
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Liste des scripts -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Version</th>
                                    <th>Base de données</th>
                                    <th>Auteur</th>
                                    <th>Statut</th>
                                    <th>Créé le</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($scripts as $script)
                                <tr>
                                    <td>
                                        <strong>{{ $script->name }}</strong>
                                        @if($script->description)
                                            <br><small class="text-muted">{{ Str::limit($script->description, 50) }}</small>
                                        @endif
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
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('scripts.show', $script) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editeur')
                                            <a href="{{ route('scripts.edit', $script) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('scripts.destroy', $script) }}" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce script ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Aucun script trouvé</p>
                                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editeur')
                                        <a href="{{ route('scripts.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Créer le premier script
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $scripts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
