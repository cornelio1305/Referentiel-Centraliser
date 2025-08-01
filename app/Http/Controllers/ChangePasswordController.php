<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ChangePasswordController extends Controller
{
    /**
     * Afficher le formulaire de changement de mot de passe
     */
    public function showForm()
    {
        return view('changePassword');
    }

    /**
     * Vérifier les identifiants actuels de l'utilisateur connecté
     */
    public function verifyCredentials(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'current_password' => 'required'
        ]);

        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous devez être connecté pour effectuer cette action.'
            ], 401);
        }

        $currentUser = Auth::user();

        // Vérifier que l'email saisi correspond à l'utilisateur connecté
        if ($request->email !== $currentUser->email) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez modifier que votre propre mot de passe.'
            ], 403);
        }

        // Vérifier le mot de passe actuel
        if (Hash::check($request->current_password, $currentUser->password)) {
            return response()->json([
                'success' => true,
                'message' => 'Identifiants vérifiés avec succès.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Mot de passe actuel incorrect.'
        ], 400);
    }

    /**
     * Traiter le changement de mot de passe pour l'utilisateur connecté
     */
    public function updatePassword(Request $request)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour effectuer cette action.');
        }

        $currentUser = Auth::user();

        // Validation des données
        $request->validate([
            'email' => 'required|email',
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ], [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'current_password.required' => 'Le mot de passe actuel est obligatoire.',
            'new_password.required' => 'Le nouveau mot de passe est obligatoire.',
            'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
            'new_password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        // Vérifier que l'email saisi correspond à l'utilisateur connecté
        if ($request->email !== $currentUser->email) {
            return back()
                ->withErrors(['email' => 'Vous ne pouvez modifier que votre propre mot de passe.'])
                ->withInput($request->except(['current_password', 'new_password', 'new_password_confirmation']));
        }

        // Vérifier le mot de passe actuel
        if (!Hash::check($request->current_password, $currentUser->password)) {
            return back()
                ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])
                ->withInput($request->except(['current_password', 'new_password', 'new_password_confirmation']));
        }

        // Vérifier que le nouveau mot de passe est différent de l'ancien
        if (Hash::check($request->new_password, $currentUser->password)) {
            return back()
                ->withErrors(['new_password' => 'Le nouveau mot de passe doit être différent de l\'ancien.'])
                ->withInput($request->except(['current_password', 'new_password', 'new_password_confirmation']));
        }

        // Mettre à jour le mot de passe
        $currentUser->password = Hash::make($request->new_password);
        $currentUser->save();

        // Déconnecter l'utilisateur
        Auth::logout();

        // Rediriger vers la page de connexion avec un message de succès
        return redirect()->route('login')->with('status', 'Mot de passe mis à jour avec succès. Veuillez vous reconnecter.');
    }
}
