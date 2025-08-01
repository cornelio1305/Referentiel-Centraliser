<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditeurDashboardController;
use App\Http\Controllers\LecteurDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Login/Logout routes (public)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // Main Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Lecteur Dashboard and routes
    Route::prefix('lecteur')->name('lecteur.')->group(function () {
        Route::get('/dashboard', [LecteurDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    });
    
    // Editeur Dashboard and routes
    Route::prefix('editeur')->name('editeur.')->group(function () {
        Route::get('/dashboard', [EditeurDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    });

    // Users management routes
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
    });
    
    // French users routes (utilisateurs)
    Route::prefix('utilisateurs')->name('utilisateurs.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{user}/modifier', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
    });

    // Password change routes
    Route::prefix('change-password')->name('password.change.')->group(function () {
        Route::get('/', [ChangePasswordController::class, 'showForm'])->name('form');
        Route::post('/verify', [ChangePasswordController::class, 'verifyCredentials'])->name('verify');
        Route::post('/', [ChangePasswordController::class, 'updatePassword'])->name('submit');
    });

     // Reports
     Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});
