@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- En-tête du script -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $script->name }}</h4>
                        <small class="text-muted">Version {{ $script->version }}</small>
                    </div>
                    <div class="btn-group" role="group">
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editeur')
                        <a href="{{ route('scripts.edit', $script) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                        <a href="{{ route('scripts.history', $script) }}" class="btn btn-info">
                            <i class="fas fa-history me-2"></i>Historique
                        </a>
                        @endif
                        <a href="{{ route('scripts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            @if($script->description)
                                <p class="text-muted">{{ $script->description }}</p>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2 mb-2">
                                <span class="badge bg-{{ $script->status === 'active' ? 'success' : ($script->status === 'draft' ? 'warning' : 'secondary') }}">
                                    {{ $script->status_label }}
                                </span>
                                @if($script->db_target)
                                    <span class="badge bg-secondary">{{ $script->db_target_label }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Contenu du script -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Contenu SQL</h6>
                        </div>
                        <div class="card-body">
                            <pre class="bg-light p-3 rounded"><code>{{ $script->content }}</code></pre>
                        </div>
                    </div>
                </div>

                <!-- Métadonnées -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Informations</h6>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">Auteur</dt>
                                <dd class="col-sm-8">{{ $script->author ?? $script->creator->name }}</dd>

                                @if($script->server_name)
                                <dt class="col-sm-4">Serveur</dt>
                                <dd class="col-sm-8">{{ $script->server_name }}</dd>
                                @endif

                                @if($script->database_name)
                                <dt class="col-sm-4">Base de données</dt>
                                <dd class="col-sm-8">{{ $script->database_name }}</dd>
                                @endif

                                @if($script->related_application)
                                <dt class="col-sm-4">Application</dt>
                                <dd class="col-sm-8">{{ $script->related_application }}</dd>
                                @endif

                                @if($script->related_job)
                                <dt class="col-sm-4">Job</dt>
                                <dd class="col-sm-8">{{ $script->related_job }}</dd>
                                @endif

                                <dt class="col-sm-4">Créé le</dt>
                                <dd class="col-sm-8">{{ $script->created_at->format('d/m/Y H:i') }}</dd>

                                @if($script->updated_at != $script->created_at)
                                <dt class="col-sm-4">Modifié le</dt>
                                <dd class="col-sm-8">{{ $script->updated_at->format('d/m/Y H:i') }}</dd>
                                @endif

                                @if($script->documentation)
                                <dt class="col-sm-12">Documentation</dt>
                                <dd class="col-sm-12">{{ $script->documentation }}</dd>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Versions récentes -->
                    @if($versions->count() > 1)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">Versions récentes</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @foreach($versions->take(5) as $version)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>v{{ $version->version }}</strong>
                                        <br><small class="text-muted">{{ $version->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editeur')
                                    <form method="POST" action="{{ route('scripts.restore', [$script, $version]) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary"
                                                onclick="return confirm('Restaurer cette version ?')">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @if($versions->count() > 5)
                            <div class="text-center mt-2">
                                <a href="{{ route('scripts.history', $script) }}" class="btn btn-sm btn-outline-secondary">
                                    Voir tout l'historique
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
