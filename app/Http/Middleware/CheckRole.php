<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Si aucun rôle spécifique n'est requis, permettre l'accès
        if (empty($roles)) {
            return $next($request);
        }

        // Vérifier si l'utilisateur a l'un des rôles requis
        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        // Si l'utilisateur n'a pas les permissions, rediriger selon son rôle
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
}
