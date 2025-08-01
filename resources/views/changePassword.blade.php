@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card p-4 shadow" id="passwordChangeCard">
        <h4 class="text-center text-danger mb-4">Modifier le mot de passe</h4>

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Affichage des messages de succès -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.change.submit') }}" id="passwordChangeForm">
            @csrf

            <div class="mb-3">
                <label for="email">Adresse email</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ auth()->user()->email }}" readonly required>
                <small class="form-text text-muted">Votre adresse email (non modifiable)</small>
            </div>

            <div class="mb-3">
                <label for="current_password">Mot de passe actuel</label>
                <input type="password" class="form-control" name="current_password" id="current_password" required>
            </div>

            <div id="newPasswordSection" style="display: none;">
                <div class="mb-3">
                    <label for="new_password">Nouveau mot de passe</label>
                    <input type="password" class="form-control" name="new_password" id="new_password" minlength="8">
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation">Confirmer le nouveau mot de passe</label>
                    <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" minlength="8">
                </div>
            </div>

            <button type="button" id="verifyBtn" class="btn btn-primary w-100 mb-2">Vérifier les identifiants</button>
            <button type="submit" id="changePasswordBtn" class="btn btn-danger w-100" style="display: none;">Changer le mot de passe</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const currentPasswordInput = document.getElementById('current_password');
    const verifyBtn = document.getElementById('verifyBtn');
    const changePasswordBtn = document.getElementById('changePasswordBtn');
    const newPasswordSection = document.getElementById('newPasswordSection');
    const form = document.getElementById('passwordChangeForm');

    // Vérification des identifiants
    verifyBtn.addEventListener('click', function() {
        const email = emailInput.value.trim();
        const currentPassword = currentPasswordInput.value.trim();

        if (!email || !currentPassword) {
            alert('Veuillez remplir tous les champs obligatoires.');
            return;
        }

        // Désactiver le bouton pendant la vérification
        verifyBtn.disabled = true;
        verifyBtn.textContent = 'Vérification...';

        fetch('{{ route("password.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                current_password: currentPassword
            }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Identifiants corrects - afficher la section nouveau mot de passe
                newPasswordSection.style.display = 'block';
                verifyBtn.style.display = 'none';
                changePasswordBtn.style.display = 'block';

                // Désactiver le champ mot de passe actuel
                currentPasswordInput.readOnly = true;

                // Focus sur le nouveau mot de passe
                document.getElementById('new_password').focus();
            } else {
                alert(data.message || 'Email ou mot de passe incorrect.');
                newPasswordSection.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
        })
        .finally(() => {
            // Réactiver le bouton
            verifyBtn.disabled = false;
            verifyBtn.textContent = 'Vérifier les identifiants';
        });
    });

    // Validation du formulaire avant soumission
    form.addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;

        if (!newPassword || !confirmPassword) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs du nouveau mot de passe.');
            return;
        }

        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('Les mots de passe ne correspondent pas.');
            return;
        }

        if (newPassword.length < 8) {
            e.preventDefault();
            alert('Le mot de passe doit contenir au moins 8 caractères.');
            return;
        }
    });

    // Réinitialisation si l'utilisateur modifie le mot de passe actuel
    currentPasswordInput.addEventListener('input', function() {
        if (newPasswordSection.style.display === 'block') {
            newPasswordSection.style.display = 'none';
            verifyBtn.style.display = 'block';
            changePasswordBtn.style.display = 'none';
            currentPasswordInput.readOnly = false;
        }
    });
});
</script>

<style>
#passwordChangeCard {
    max-width: 500px;
    margin: 0 auto;
    transition: all 0.3s ease;
}

#newPasswordSection {
    animation: slideDown 0.3s ease-in-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        max-height: 0;
        overflow: hidden;
    }
    to {
        opacity: 1;
        max-height: 200px;
        overflow: visible;
    }
}

.form-control:read-only {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}
</style>
@endsection
