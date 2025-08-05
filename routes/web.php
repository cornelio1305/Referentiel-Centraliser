<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditeurDashboardController;
use App\Http\Controllers\LecteurDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ScriptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ImportExportController;
use Illuminate\Support\Facades\Route;

// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Login/Logout routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role:admin');

    // Dashboard Editeur
    Route::get('/editeur/dashboard', [EditeurDashboardController::class, 'index'])->name('editeur.dashboard')->middleware('role:editeur');

    // Dashboard Lecteur
    Route::get('/lecteur/dashboard', [LecteurDashboardController::class, 'index'])->name('lecteur.dashboard')->middleware('role:lecteur');

    // ===== GESTION DES UTILISATEURS (Admin seulement) =====
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', function() { return 'Users list'; })->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');

        // Utilisateurs routes (French)
        Route::get('/utilisateurs', [UserController::class, 'index'])->name('utilisateurs.index');
        Route::get('/utilisateurs/{user}/modifier', [UserController::class, 'edit'])->name('utilisateurs.edit');
        Route::put('/utilisateurs/{user}', [UserController::class, 'update'])->name('utilisateurs.update');
        Route::delete('/utilisateurs/{user}', [UserController::class, 'destroy'])->name('utilisateurs.destroy');
    });

    // ===== GESTION DES SCRIPTS (Admin et Editeur) =====
    Route::prefix('scripts')->name('scripts.')->middleware('role:admin,editeur')->group(function () {
        // CRUD de base
        Route::get('/', [ScriptController::class, 'index'])->name('index');
        Route::get('/create', [ScriptController::class, 'create'])->name('create');
        Route::post('/', [ScriptController::class, 'store'])->name('store');
        Route::get('/{script}', [ScriptController::class, 'show'])->name('show');
        Route::get('/{script}/edit', [ScriptController::class, 'edit'])->name('edit');
        Route::put('/{script}', [ScriptController::class, 'update'])->name('update');
        Route::delete('/{script}', [ScriptController::class, 'destroy'])->name('destroy');

        // Recherche avancée
        Route::get('/search', [ScriptController::class, 'search'])->name('search');

        // Gestion des versions
        Route::get('/{script}/history', [ScriptController::class, 'history'])->name('history');
        Route::post('/{script}/versions/{version}/restore', [ScriptController::class, 'restore'])->name('restore');
        Route::get('/{script}/compare/{version1}/{version2?}', [ScriptController::class, 'compare'])->name('compare');

        // Route versions ajoutée dans le groupe scripts (accessible aux admin et editeur)
        Route::get('/versions', [ScriptController::class, 'versions'])->name('versions');
    });

    // ===== VERSIONS GLOBALES (Admin et Editeur) =====
    Route::middleware('role:admin,editeur')->group(function () {
        // Route versions accessible directement (sans préfixe scripts)
        Route::get('/versions', [ScriptController::class, 'versions'])->name('versions');
    });

    // ===== IMPORT/EXPORT (Admin et Editeur) =====
    Route::prefix('import-export')->name('import-export.')->middleware('role:admin,editeur')->group(function () {
        Route::get('/', [ImportExportController::class, 'index'])->name('index');
        Route::post('/import', [ImportExportController::class, 'import'])->name('import');
        Route::post('/export', [ImportExportController::class, 'export'])->name('export');
    });

    // ===== RAPPORTS (Admin et Editeur) =====
    Route::prefix('reports')->name('reports.')->middleware('role:admin,editeur')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/scripts-by-database', [ReportController::class, 'scriptsByDatabase'])->name('scripts-by-database');
        Route::get('/script-usage', [ReportController::class, 'scriptUsage'])->name('script-usage');
        Route::get('/user-activity', [ReportController::class, 'userActivity'])->name('user-activity');
        Route::get('/scripts-by-status', [ReportController::class, 'scriptsByStatus'])->name('scripts-by-status');
        Route::post('/export', [ReportController::class, 'export'])->name('export');
    });

    // ===== CONSULTATION DES SCRIPTS (Lecteur) =====
    Route::prefix('scripts')->name('scripts.')->middleware('role:lecteur')->group(function () {
        Route::get('/', [ScriptController::class, 'index'])->name('index');
        Route::get('/{script}', [ScriptController::class, 'show'])->name('show');
        Route::get('/search', [ScriptController::class, 'search'])->name('search');
    });

    // Profile (accessible à tous les utilisateurs connectés)
    Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
});

// ===== CHANGEMENT DE MOT DE PASSE =====
Route::middleware('auth')->group(function () {
    Route::get('/change-password', [ChangePasswordController::class, 'showForm'])
        ->name('password.change.form');
    Route::post('/verify-credentials', [ChangePasswordController::class, 'verifyCredentials'])
        ->name('password.verify');
    Route::post('/change-password', [ChangePasswordController::class, 'updatePassword'])
        ->name('password.change.submit');
});
