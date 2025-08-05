@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Import/Export de Scripts</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Import -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-download me-2"></i>Importer des Scripts</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('import-export.import') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="sql_file" class="form-label">Fichier SQL *</label>
                                            <input type="file" class="form-control @error('sql_file') is-invalid @enderror"
                                                   id="sql_file" name="sql_file" accept=".sql,.txt" required>
                                            <div class="form-text">Sélectionnez un fichier SQL à importer (max 10MB)</div>
                                            @error('sql_file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="db_target" class="form-label">Base de données cible *</label>
                                            <select class="form-control @error('db_target') is-invalid @enderror"
                                                    id="db_target" name="db_target" required>
                                                <option value="">Sélectionner...</option>
                                                <option value="postgresql">PostgreSQL</option>
                                                <option value="mysql">MySQL</option>
                                                <option value="sqlserver">SQL Server</option>
                                                <option value="db2">DB2</option>
                                                <option value="oracle">Oracle</option>
                                                <option value="other">Autre</option>
                                            </select>
                                            @error('db_target')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-upload me-2"></i>Importer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Export -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Exporter des Scripts</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('import-export.export') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Sélectionner les scripts à exporter</label>
                                            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                                @foreach(\App\Models\Script::orderBy('name')->get() as $script)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="script_ids[]" value="{{ $script->id }}"
                                                           id="script_{{ $script->id }}">
                                                    <label class="form-check-label" for="script_{{ $script->id }}">
                                                        <strong>{{ $script->name }}</strong>
                                                        <small class="text-muted">({{ $script->version }})</small>
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <button type="button" class="btn btn-sm btn-outline-secondary me-2" onclick="selectAll()">
                                                <i class="fas fa-check-double me-1"></i>Tout sélectionner
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">
                                                <i class="fas fa-times me-1"></i>Tout désélectionner
                                            </button>
                                        </div>

                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-download me-2"></i>Exporter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Instructions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Import</h6>
                                            <ul>
                                                <li>Le fichier SQL sera automatiquement découpé en scripts individuels</li>
                                                <li>Chaque instruction SQL sera traitée comme un script séparé</li>
                                                <li>Les scripts importés auront le statut "Brouillon" par défaut</li>
                                                <li>Vous pourrez ensuite modifier les métadonnées de chaque script</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Export</h6>
                                            <ul>
                                                <li>Sélectionnez les scripts que vous souhaitez exporter</li>
                                                <li>Le fichier exporté contiendra tous les scripts sélectionnés</li>
                                                <li>Chaque script sera précédé de ses métadonnées en commentaires</li>
                                                <li>Le fichier sera téléchargé au format .sql</li>
                                            </ul>
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

<script>
function selectAll() {
    document.querySelectorAll('input[name="script_ids[]"]').forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAll() {
    document.querySelectorAll('input[name="script_ids[]"]').forEach(checkbox => {
        checkbox.checked = false;
    });
}
</script>
@endsection
