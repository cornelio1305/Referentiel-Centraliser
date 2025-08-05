<?php

namespace Database\Seeders;

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
        $admin = User::where('email', 'admin@example.com')->first();
        $editeur = User::where('email', 'editeur@example.com')->first();

        // Script 1 - PostgreSQL
        Script::create([
            'name' => 'Création de table utilisateurs',
            'description' => 'Script pour créer la table utilisateurs avec les contraintes appropriées',
            'content' => "CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'lecteur',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);",
            'version' => '1.0',
            'status' => 'active',
            'db_target' => 'postgresql',
            'server_name' => 'prod-server-01',
            'database_name' => 'referentiel_db',
            'author' => 'Admin User',
            'affected_objects' => ['users'],
            'related_application' => 'Referentiel Centraliser',
            'documentation' => 'Ce script crée la table principale des utilisateurs avec les index nécessaires pour optimiser les performances.',
            'dependencies' => [],
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        // Script 2 - MySQL
        Script::create([
            'name' => 'Procédure de sauvegarde automatique',
            'description' => 'Procédure stockée pour automatiser les sauvegardes',
            'content' => "DELIMITER //

CREATE PROCEDURE BackupDatabase(IN db_name VARCHAR(100))
BEGIN
    DECLARE backup_path VARCHAR(255);
    DECLARE backup_file VARCHAR(255);
    
    SET backup_path = '/backups/';
    SET backup_file = CONCAT(backup_path, db_name, '_', DATE_FORMAT(NOW(), '%Y%m%d_%H%i%s'), '.sql');
    
    SET @sql = CONCAT('mysqldump -u root -p --single-transaction --routines --triggers ', db_name, ' > ', backup_file);
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    
    INSERT INTO backup_log (database_name, backup_file, created_at) 
    VALUES (db_name, backup_file, NOW());
END //

DELIMITER ;",
            'version' => '2.1',
            'status' => 'active',
            'db_target' => 'mysql',
            'server_name' => 'mysql-prod-01',
            'database_name' => 'system_db',
            'author' => 'Editeur User',
            'affected_objects' => ['backup_log'],
            'related_application' => 'Système de sauvegarde',
            'documentation' => 'Procédure stockée pour automatiser les sauvegardes de base de données avec logging.',
            'dependencies' => ['backup_log'],
            'created_by' => $editeur->id,
            'updated_by' => $editeur->id,
        ]);

        // Script 3 - SQL Server
        Script::create([
            'name' => 'Fonction de calcul de statistiques',
            'description' => 'Fonction pour calculer les statistiques d\'utilisation',
            'content' => "CREATE FUNCTION CalculateUsageStats(@startDate DATE, @endDate DATE)
RETURNS TABLE
AS
RETURN
(
    SELECT 
        u.name,
        COUNT(s.id) as scripts_created,
        AVG(CAST(sv.viewed_at AS FLOAT)) as avg_views,
        MAX(s.created_at) as last_activity
    FROM users u
    LEFT JOIN scripts s ON u.id = s.created_by
    LEFT JOIN script_views sv ON s.id = sv.script_id
    WHERE s.created_at BETWEEN @startDate AND @endDate
    GROUP BY u.id, u.name
);

-- Exemple d'utilisation
-- SELECT * FROM CalculateUsageStats('2024-01-01', '2024-12-31');",
            'version' => '1.5',
            'status' => 'draft',
            'db_target' => 'sqlserver',
            'server_name' => 'sqlserver-analytics',
            'database_name' => 'analytics_db',
            'author' => 'Admin User',
            'affected_objects' => ['users', 'scripts', 'script_views'],
            'related_application' => 'Système d\'analytics',
            'documentation' => 'Fonction table pour calculer les statistiques d\'utilisation des utilisateurs.',
            'dependencies' => ['users', 'scripts', 'script_views'],
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        // Script 4 - Oracle
        Script::create([
            'name' => 'Package de gestion des versions',
            'description' => 'Package PL/SQL pour gérer les versions de scripts',
            'content' => "CREATE OR REPLACE PACKAGE script_version_manager AS
    -- Procédure pour créer une nouvelle version
    PROCEDURE create_version(
        p_script_id IN NUMBER,
        p_version IN VARCHAR2,
        p_content IN CLOB,
        p_change_reason IN VARCHAR2 DEFAULT NULL
    );
    
    -- Fonction pour obtenir l'historique des versions
    FUNCTION get_version_history(p_script_id IN NUMBER)
    RETURN SYS_REFCURSOR;
    
    -- Procédure pour restaurer une version
    PROCEDURE restore_version(
        p_script_id IN NUMBER,
        p_version IN VARCHAR2
    );
END script_version_manager;
/

CREATE OR REPLACE PACKAGE BODY script_version_manager AS
    PROCEDURE create_version(
        p_script_id IN NUMBER,
        p_version IN VARCHAR2,
        p_content IN CLOB,
        p_change_reason IN VARCHAR2 DEFAULT NULL
    ) IS
    BEGIN
        INSERT INTO script_versions (
            script_id, version, content, change_reason, created_at
        ) VALUES (
            p_script_id, p_version, p_content, p_change_reason, SYSDATE
        );
        COMMIT;
    END create_version;
    
    FUNCTION get_version_history(p_script_id IN NUMBER)
    RETURN SYS_REFCURSOR IS
        v_cursor SYS_REFCURSOR;
    BEGIN
        OPEN v_cursor FOR
            SELECT version, content, change_reason, created_at
            FROM script_versions
            WHERE script_id = p_script_id
            ORDER BY created_at DESC;
        RETURN v_cursor;
    END get_version_history;
    
    PROCEDURE restore_version(
        p_script_id IN NUMBER,
        p_version IN VARCHAR2
    ) IS
        v_content CLOB;
    BEGIN
        SELECT content INTO v_content
        FROM script_versions
        WHERE script_id = p_script_id AND version = p_version;
        
        UPDATE scripts
        SET content = v_content, updated_at = SYSDATE
        WHERE id = p_script_id;
        
        COMMIT;
    END restore_version;
END script_version_manager;",
            'version' => '3.0',
            'status' => 'active',
            'db_target' => 'oracle',
            'server_name' => 'oracle-enterprise',
            'database_name' => 'script_repository',
            'author' => 'Editeur User',
            'affected_objects' => ['script_versions', 'scripts'],
            'related_application' => 'Gestionnaire de versions',
            'documentation' => 'Package PL/SQL complet pour la gestion des versions de scripts avec création, historique et restauration.',
            'dependencies' => ['script_versions', 'scripts'],
            'created_by' => $editeur->id,
            'updated_by' => $editeur->id,
        ]);

        // Script 5 - DB2
        Script::create([
            'name' => 'Trigger de validation des données',
            'description' => 'Trigger pour valider les données avant insertion',
            'content' => "CREATE TRIGGER validate_script_data
    NO CASCADE BEFORE INSERT ON scripts
    REFERENCING NEW AS n
    FOR EACH ROW MODE DB2SQL
BEGIN ATOMIC
    DECLARE v_error_msg VARCHAR(500);
    
    -- Validation du nom
    IF n.name IS NULL OR LENGTH(TRIM(n.name)) = 0 THEN
        SET v_error_msg = 'Le nom du script ne peut pas être vide';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = v_error_msg;
    END IF;
    
    -- Validation de la version
    IF n.version IS NULL OR LENGTH(TRIM(n.version)) = 0 THEN
        SET v_error_msg = 'La version ne peut pas être vide';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = v_error_msg;
    END IF;
    
    -- Validation du contenu
    IF n.content IS NULL OR LENGTH(TRIM(n.content)) = 0 THEN
        SET v_error_msg = 'Le contenu du script ne peut pas être vide';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = v_error_msg;
    END IF;
    
    -- Validation du statut
    IF n.status NOT IN ('draft', 'active', 'inactive', 'archived') THEN
        SET v_error_msg = 'Statut invalide. Valeurs autorisées: draft, active, inactive, archived';
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = v_error_msg;
    END IF;
END@",
            'version' => '1.2',
            'status' => 'active',
            'db_target' => 'db2',
            'server_name' => 'db2-mainframe',
            'database_name' => 'script_repository',
            'author' => 'Admin User',
            'affected_objects' => ['scripts'],
            'related_application' => 'Système de validation',
            'documentation' => 'Trigger DB2 pour valider les données avant insertion dans la table scripts.',
            'dependencies' => [],
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);

        $this->command->info('Scripts de test créés avec succès!');
    }
}
