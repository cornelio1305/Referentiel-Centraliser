<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'password_changed' => false, // Doit changer son mot de passe
            ]
        );

        // Créer un utilisateur éditeur
        User::updateOrCreate(
            ['email' => 'editeur@example.com'],
            [
                'name' => 'Éditeur User',
                'password' => Hash::make('password123'),
                'role' => 'editeur',
                'password_changed' => false, // Doit changer son mot de passe
            ]
        );

        // Créer un utilisateur lecteur
        User::updateOrCreate(
            ['email' => 'lecteur@example.com'],
            [
                'name' => 'Lecteur User',
                'password' => Hash::make('password123'),
                'role' => 'lecteur',
                'password_changed' => false, // Doit changer son mot de passe
            ]
        );

        // Créer un utilisateur admin qui a déjà changé son mot de passe
        User::updateOrCreate(
            ['email' => 'admin2@example.com'],
            [
                'name' => 'Admin Testé',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'password_changed' => true, // A déjà changé son mot de passe
            ]
        );

        // Créer un utilisateur éditeur qui a déjà changé son mot de passe
        User::updateOrCreate(
            ['email' => 'editeur2@example.com'],
            [
                'name' => 'Éditeur Testé',
                'password' => Hash::make('password123'),
                'role' => 'editeur',
                'password_changed' => true, // A déjà changé son mot de passe
            ]
        );

        // Créer un utilisateur lecteur qui a déjà changé son mot de passe
        User::updateOrCreate(
            ['email' => 'lecteur2@example.com'],
            [
                'name' => 'Lecteur Testé',
                'password' => Hash::make('password123'),
                'role' => 'lecteur',
                'password_changed' => true, // A déjà changé son mot de passe
            ]
        );
    }
}
