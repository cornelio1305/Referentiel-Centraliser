@extends('layouts.app')

@section('title', 'Mes Favoris')

@section('content')
@include('partials.lecteur.lnavbar')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('partials.lecteur.lsidebar')

        <!-- Main content -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Mes Favoris</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($favorites->count() > 0)
                <div class="row">
                    @foreach($favorites as $favorite)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $favorite->script->name }}</h5>
                                    <p class="card-text">{{ Str::limit($favorite->script->description, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            Par {{ $favorite->script->creator->name ?? 'Inconnu' }}
                                        </small>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('scripts.show', $favorite->script->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Voir
                                            </a>
                                            <form method="POST" action="{{ route('favorites.destroy', $favorite->id) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Retirer ce script des favoris ?')">
                                                    <i class="fas fa-heart-broken"></i> Retirer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-muted">
                                    <small>
                                        <i class="fas fa-eye"></i> {{ $favorite->script->views_count }} vues
                                        @if($favorite->script->rating)
                                            | <i class="fas fa-star text-warning"></i> {{ number_format($favorite->script->rating, 1) }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $favorites->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                    <h3 class="text-muted">Aucun favori</h3>
                    <p class="text-muted">Vous n'avez pas encore ajouté de scripts à vos favoris.</p>
                    <a href="{{ route('lecteur.scripts') }}" class="btn btn-primary">
                        <i class="fas fa-search"></i> Parcourir les scripts
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection