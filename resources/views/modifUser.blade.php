@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Modifier l'utilisateur : {{ $user->name }}</h3>

    <form action="{{ route('utilisateurs.update', $user->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rôle</label>
            <select name="role" class="form-select" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="éditeur" {{ $user->role == 'éditeur' ? 'selected' : '' }}>Éditeur</option>
                <option value="lecteur" {{ $user->role == 'lecteur' ? 'selected' : '' }}>Lecteur</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('utilisateurs.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection

