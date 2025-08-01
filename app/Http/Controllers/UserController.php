<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\UserPasswordMail;
use App\Mail\UserUpdated;
use App\Mail\UserCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * Afficher le formulaire de création d'utilisateur
     */
    public function create()
    {
        $menuItems = [
            [
                'route' => 'dashboard',
                'icon' => 'fas fa-home',
                'label' => 'Dashboard',
                'children' => []
            ],
            [
                'route' => 'users.create',
                'icon' => 'fas fa-users',
                'label' => 'Utilisateurs',
                'children' => [
                    ['label' => 'Tous les Utilisateurs', 'route' => 'users.index'],
                    ['label' => 'Ajout Utilisateur', 'route' => 'users.create'],
                ],
            ],

            // Ajoutez d'autres éléments de menu selon vos besoins
        ];

        return view('userEdit', compact('menuItems'));
    }

    /**
     * Enregistrer un nouvel utilisateur
     */
    public function store(Request $request)
{
    // Valider les données
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'role' => 'required|string',
    ]);

    // Générer un mot de passe aléatoire
    $plainPassword = Str::random(10); // ex: "Mdp2025xyz!"

    // Créer l’utilisateur avec le mot de passe crypté
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => $validated['role'],
        'password' => Hash::make($plainPassword), // Hasher avant stockage
    ]);

    // Envoyer le mot de passe en clair par mail
    Mail::to($user->email)->send(new UserPasswordMail(
        $user->name,
        $user->email,
        $plainPassword // C’est CE mot de passe qu’on a enregistré en hashé
    ));

    return redirect()->back()->with('success', 'Utilisateur créé et email envoyé.');
}

    /**
     * Afficher la liste des utilisateurs
     */
    public function index()
    {
        $users = User::all();
        return view('listeUser', compact('users'));
    }

    /**
     * Afficher le formulaire d'édition d'un utilisateur
     */
    public function edit(User $user)
    {
        return view('modifUser', compact('user')); // Correction: $user au lieu de $users
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,editeur,lecteur', // Correction: editeur au lieu de éditeur
        ]);

        $oldData = $user->only(['name', 'email', 'role']);

        $user->update($validated);

        // Envoyer l'email de notification (assurez-vous que la classe UserUpdated existe)
        Mail::to($user->email)->send(new UserUpdated($user, $oldData));

        return redirect()->route('users.index')->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }
}
