@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Créer un nouveau script</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('scripts.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <!-- Informations de base -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom du script *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Contenu SQL *</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror"
                                              id="content" name="content" rows="15" required
                                              placeholder="Entrez votre code SQL ici...">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Métadonnées -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Métadonnées</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="version" class="form-label">Version *</label>
                                            <input type="text" class="form-control @error('version') is-invalid @enderror"
                                                   id="version" name="version" value="{{ old('version', '1.0') }}" required>
                                            @error('version')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Statut *</label>
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                    id="status" name="status" required>
                                                @foreach($statuses as $value => $label)
                                                    <option value="{{ $value }}" {{ old('status', 'draft') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="db_target" class="form-label">Base de données cible</label>
                                            <select class="form-control @error('db_target') is-invalid @enderror"
                                                    id="db_target" name="db_target">
                                                <option value="">Sélectionner...</option>
                                                @foreach($dbTargets as $value => $label)
                                                    <option value="{{ $value }}" {{ old('db_target') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('db_target')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="author" class="form-label">Auteur</label>
                                            <input type="text" class="form-control @error('author') is-invalid @enderror"
                                                   id="author" name="author" value="{{ old('author', auth()->user()->name) }}">
                                            @error('author')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="server_name" class="form-label">Nom du serveur</label>
                                            <input type="text" class="form-control @error('server_name') is-invalid @enderror"
                                                   id="server_name" name="server_name" value="{{ old('server_name') }}">
                                            @error('server_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="database_name" class="form-label">Nom de la base de données</label>
                                            <input type="text" class="form-control @error('database_name') is-invalid @enderror"
                                                   id="database_name" name="database_name" value="{{ old('database_name') }}">
                                            @error('database_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="related_application" class="form-label">Application liée</label>
                                            <input type="text" class="form-control @error('related_application') is-invalid @enderror"
                                                   id="related_application" name="related_application" value="{{ old('related_application') }}">
                                            @error('related_application')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="related_job" class="form-label">Job lié</label>
                                            <input type="text" class="form-control @error('related_job') is-invalid @enderror"
                                                   id="related_job" name="related_job" value="{{ old('related_job') }}">
                                            @error('related_job')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="documentation" class="form-label">Documentation</label>
                                            <textarea class="form-control @error('documentation') is-invalid @enderror"
                                                      id="documentation" name="documentation" rows="3">{{ old('documentation') }}</textarea>
                                            @error('documentation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('scripts.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Créer le script
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
