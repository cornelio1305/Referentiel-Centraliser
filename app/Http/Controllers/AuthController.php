<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login post
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Vérifier si l'utilisateur doit changer son mot de passe
            if (!$user->password_changed) {
                return redirect()->route('password.change.form')->with('warning', 'Vous devez changer votre mot de passe avant de continuer.');
            }

            // Rediriger selon le rôle
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboard');
                case 'editeur':
                    return redirect()->route('editeur.dashboard');
                case 'lecteur':
                    return redirect()->route('lecteur.dashboard');
                default:
                    return redirect()->route('lecteur.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Logout user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
