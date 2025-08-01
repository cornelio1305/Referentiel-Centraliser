<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Script;
use App\Models\User;

class ScriptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->error('Aucun utilisateur trouvé. Veuillez d\'abord exécuter TestUsersSeeder.');
            return;
        }

        $categories = ['Configuration', 'Sauvegarde', 'Monitoring', 'Sécurité', 'Maintenance', 'Déploiement'];
        $statuses = ['draft', 'active', 'archived', 'in_review'];

        // Scripts de test
        $scripts = [
            [
                'name' => 'Script de Configuration Réseau',
                'description' => 'Configuration automatique des paramètres réseau pour les serveurs',
                'content' => '#!/bin/bash\n# Configuration réseau\necho "Configuration du réseau..."\n# Code de configuration ici',
                'category' => 'Configuration',
                'status' => 'active',
                'views_count' => 156,
                'rating' => 4.8,
                'rating_count' => 12,
            ],
            [
                'name' => 'Script de Sauvegarde Automatique',
                'description' => 'Sauvegarde automatique des données importantes avec rotation',
                'content' => '#!/bin/bash\n# Sauvegarde automatique\necho "Début de la sauvegarde..."\n# Code de sauvegarde ici',
                'category' => 'Sauvegarde',
                'status' => 'active',
                'views_count' => 89,
                'rating' => 4.6,
                'rating_count' => 8,
            ],
            [
                'name' => 'Script de Monitoring Système',
                'description' => 'Surveillance des performances système et alertes',
                'content' => '#!/bin/bash\n# Monitoring système\necho "Vérification des performances..."\n# Code de monitoring ici',
                'category' => 'Monitoring',
                'status' => 'active',
                'views_count' => 234,
                'rating' => 4.9,
                'rating_count' => 15,
            ],
            [
                'name' => 'Script de Sécurité Firewall',
                'description' => 'Configuration et maintenance du firewall',
                'content' => '#!/bin/bash\n# Configuration firewall\necho "Configuration du firewall..."\n# Code de sécurité ici',
                'category' => 'Sécurité',
                'status' => 'active',
                'views_count' => 67,
                'rating' => 4.7,
                'rating_count' => 6,
            ],
            [
                'name' => 'Script de Maintenance Base de Données',
                'description' => 'Maintenance automatique des bases de données',
                'content' => '#!/bin/bash\n# Maintenance BDD\necho "Maintenance de la base de données..."\n# Code de maintenance ici',
                'category' => 'Maintenance',
                'status' => 'in_review',
                'views_count' => 45,
                'rating' => 4.5,
                'rating_count' => 4,
            ],
            [
                'name' => 'Script de Déploiement Application',
                'description' => 'Déploiement automatique d\'applications',
                'content' => '#!/bin/bash\n# Déploiement\necho "Déploiement de l\'application..."\n# Code de déploiement ici',
                'category' => 'Déploiement',
                'status' => 'active',
                'views_count' => 123,
                'rating' => 4.4,
                'rating_count' => 9,
            ],
            [
                'name' => 'Script de Nettoyage Logs',
                'description' => 'Nettoyage automatique des fichiers de logs',
                'content' => '#!/bin/bash\n# Nettoyage logs\necho "Nettoyage des logs..."\n# Code de nettoyage ici',
                'category' => 'Maintenance',
                'status' => 'active',
                'views_count' => 78,
                'rating' => 4.3,
                'rating_count' => 7,
            ],
            [
                'name' => 'Script de Vérification Intégrité',
                'description' => 'Vérification de l\'intégrité des fichiers système',
                'content' => '#!/bin/bash\n# Vérification intégrité\necho "Vérification de l\'intégrité..."\n# Code de vérification ici',
                'category' => 'Sécurité',
                'status' => 'draft',
                'views_count' => 34,
                'rating' => 4.2,
                'rating_count' => 3,
            ],
        ];

        foreach ($scripts as $scriptData) {
            // Assigner aléatoirement un créateur
            $creator = $users->random();
            
            Script::updateOrCreate(
                ['name' => $scriptData['name']],
                array_merge($scriptData, [
                    'created_by' => $creator->id,
                    'updated_by' => $creator->id,
                    'dependencies' => ['bash', 'curl'],
                    'metadata' => [
                        'author' => $creator->name,
                        'version' => '1.0',
                        'tags' => ['automation', 'system'],
                    ],
                ])
            );
        }

        $this->command->info('Scripts de test créés avec succès !');
    }
}
