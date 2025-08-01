@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Mon Profil</h4>
                </div>
                <div class="card-body">
                    <p><strong>Nom:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Rôle:</strong> {{ ucfirst($user->role) }}</p>
                    <p><strong>Membre depuis:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
