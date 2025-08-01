{{-- resources/views/scripts/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('partials.sidebar')

        <div class="col" style="margin-left: 250px;">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-list-ul me-2"></i>{{ $title }}</h2>
                    <a href="{{ route('scripts.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus me-2"></i>Nouveau Script
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <p class="card-text">{{ $message }}</p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Cette fonctionnalité est en cours de développement.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- resources/views/scripts/create.blade.php --}}
{{-- Même structure que index.blade.php mais avec le titre et message appropriés --}}

{{-- resources/views/scripts/active.blade.php --}}
{{-- Même structure que index.blade.php mais avec le titre et message appropriés --}}

{{-- resources/views/scripts/history.blade.php --}}
{{-- Même structure que index.blade.php mais avec le titre et message appropriés --}}
