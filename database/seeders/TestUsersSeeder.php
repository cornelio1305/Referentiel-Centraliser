<?php

namespace Database\Seeders;

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
                'password' => Hash::make('password'),
                'role' => 'admin',
                'password_changed' => true,
            ]
        );

        // Créer un utilisateur éditeur
        User::updateOrCreate(
            ['email' => 'editeur@example.com'],
            [
                'name' => 'Editeur User',
                'password' => Hash::make('password'),
                'role' => 'editeur',
                'password_changed' => true,
            ]
        );

        // Créer un utilisateur lecteur
        User::updateOrCreate(
            ['email' => 'lecteur@example.com'],
            [
                'name' => 'Lecteur User',
                'password' => Hash::make('password'),
                'role' => 'lecteur',
                'password_changed' => true,
            ]
        );

        $this->command->info('Utilisateurs de test créés avec succès!');
        $this->command->info('Admin: admin@example.com / password');
        $this->command->info('Editeur: editeur@example.com / password');
        $this->command->info('Lecteur: lecteur@example.com / password');
    }
}
