<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ScriptController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LecteurDashboardController;


// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Login/Logout routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Lecteur Dashboard
    Route::get('/lecteur/dashboard', [LecteurDashboardController::class, 'index'])->name('lecteur.dashboard');

    // Users routes
    Route::get('/users', function() { return 'Users list'; })->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    // Utilisateurs routes (French)
    Route::get('/utilisateurs', [UserController::class, 'index'])->name('utilisateurs.index');
    Route::get('/utilisateurs/{user}/modifier', [UserController::class, 'edit'])->name('utilisateurs.edit');
    Route::put('/utilisateurs/{user}', [UserController::class, 'update'])->name('utilisateurs.update');
    Route::delete('/utilisateurs/{user}', [UserController::class, 'destroy'])->name('utilisateurs.destroy');

    // Reports
    Route::get('/reports', function() { return 'Reports page'; })->name('reports.index');
});





// Routes pour le changement de mot de passe (nécessite d'être connecté)
Route::middleware('auth')->group(function () {
    // Route pour afficher le formulaire
    Route::get('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'showForm'])
        ->name('password.change.form');

    // Route pour vérifier les identifiants
    Route::post('/verify-credentials', [App\Http\Controllers\ChangePasswordController::class, 'verifyCredentials'])
        ->name('password.verify');

    // Route pour soumettre le changement de mot de passe
    Route::post('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'updatePassword'])
        ->name('password.change.submit');
        });




// Routes existantes...

// Routes pour la gestion des scripts
Route::prefix('scripts')->name('scripts.')->middleware('auth')->group(function () {
    Route::get('/', [ScriptController::class, 'index'])->name('index');
    Route::get('/create', [ScriptController::class, 'create'])->name('create');
    Route::get('/active', [ScriptController::class, 'active'])->name('active');
    Route::get('/history', [ScriptController::class, 'history'])->name('history');

    // Routes additionnelles si nécessaire
    Route::post('/', [ScriptController::class, 'store'])->name('store');
    Route::get('/{id}', [ScriptController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ScriptController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ScriptController::class, 'update'])->name('update');
    Route::delete('/{id}', [ScriptController::class, 'destroy'])->name('destroy');
});


Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
