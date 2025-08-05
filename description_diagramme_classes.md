# Diagramme de Classes - Référentiel Centralisé Multi-SGBD

## Vue d'ensemble

Ce diagramme de classes représente l'architecture d'un système de référentiel centralisé pour la gestion des scripts SQL multi-SGBD, basé sur les exigences du projet de la Direction de la Cellule de la Transformation Digitale (DTD).

## Classes Principales

### 1. ScriptSQL
**Classe centrale du système**
- **Attributs :**
  - `id` : Identifiant unique du script
  - `nom` : Nom du script
  - `contenu` : Contenu SQL du script
  - `auteur` : Créateur du script
  - `dateCreation` : Date de création
  - `derniereModification` : Date de dernière modification
  - `version` : Version actuelle du script
  - `description` : Description du script
  - `taille` : Taille du fichier

- **Méthodes :**
  - `creer()` : Création d'un nouveau script
  - `modifier()` : Modification du contenu
  - `supprimer()` : Suppression du script
  - `obtenirContenu()` : Récupération du contenu
  - `obtenirMetadonnees()` : Récupération des métadonnées

### 2. SGBD
**Gestion des différents systèmes de gestion de base de données**
- **Types supportés :** PostgreSQL, MySQL, SQL Server, DB2, Oracle
- **Fonctionnalités :**
  - Validation de la syntaxe selon le SGBD
  - Exécution des scripts
  - Gestion des métadonnées spécifiques

### 3. Serveur
**Infrastructure d'exécution**
- **Attributs :** Adresse IP, port, environnement, statut
- **Méthodes :** Connexion, test de connexion, gestion du statut

### 4. BaseDeDonnees
**Bases de données cibles**
- **Attributs :** Nom, schéma, taille, date de création
- **Méthodes :** Création, suppression, sauvegarde

### 5. Utilisateur
**Gestion des utilisateurs du système**
- **Attributs :** Nom, email, rôle, dates de connexion
- **Méthodes :** Authentification, gestion des droits

### 6. HistoriqueVersion
**Traçabilité des modifications**
- **Fonctionnalités :**
  - Suivi complet des versions
  - Restauration de versions antérieures
  - Comparaison entre versions
  - Conservation des commentaires de modification

### 7. Metadonnees
**Documentation et informations complémentaires**
- **Métadonnées critiques à enregistrer :**
  - SGBD cible (PostgreSQL, MySQL, SQL Server, DB2, etc.)
  - Serveur et base de données d'exécution
  - Auteur du script
  - Dates de création et dernière modification
  - Objets SQL impactés (tables, vues)
  - Application ou job lié

### 8. Dependance
**Gestion des dépendances entre scripts**
- **Types de dépendances :**
  - Scripts prérequis
  - Objets requis
  - Données nécessaires
- **Ordre d'exécution géré**

### 9. ObjetSQL
**Objets manipulés par les scripts**
- **Types :** Tables, vues, procédures, fonctions, triggers, index
- **Gestion :** Création, modification, suppression

### 10. ApplicationJob
**Applications et jobs utilisant les scripts**
- **Fonctionnalités :**
  - Exécution planifiée
  - Gestion des planifications
  - Arrêt d'urgence

### 11. ProfilUtilisateur
**Gestion fine des droits d'accès**
- **Fonctionnalités :**
  - Permissions par environnement
  - Restrictions d'accès
  - Attribution/retrait de droits

### 12. Referentiel
**Système central de gestion**
- **Fonctionnalités principales :**
  - Centralisation des scripts
  - Sauvegarde/restauration
  - Synchronisation multi-environnements
  - Génération de rapports

## Énumérations

### TypeSGBD
- `POSTGRESQL`
- `MYSQL`
- `SQL_SERVER`
- `DB2`
- `ORACLE`

### TypeObjet
- `TABLE`
- `VUE`
- `PROCEDURE`
- `FONCTION`
- `TRIGGER`
- `INDEX`

### TypeDependance
- `SCRIPT_PREREQUIS`
- `OBJET_REQUIS`
- `DONNEES_NECESSAIRES`

### Role
- `ADMINISTRATEUR`
- `EDITEUR`
- `LECTEUR`
- `AUDITEUR`

## Relations Principales

1. **ScriptSQL ↔ SGBD** : Compatibilité avec différents SGBD
2. **ScriptSQL ↔ Serveur** : Exécution sur des serveurs spécifiques
3. **Serveur ↔ BaseDeDonnees** : Hébergement des bases de données
4. **Utilisateur ↔ ScriptSQL** : Création et modification des scripts
5. **ScriptSQL ↔ HistoriqueVersion** : Versioning complet
6. **ScriptSQL ↔ Metadonnees** : Documentation détaillée
7. **ScriptSQL ↔ Dependance** : Gestion des dépendances
8. **ScriptSQL ↔ ObjetSQL** : Manipulation d'objets de base de données
9. **ApplicationJob ↔ ScriptSQL** : Utilisation par des applications
10. **Utilisateur ↔ ProfilUtilisateur** : Gestion des droits d'accès
11. **Referentiel** : Gestion centralisée de tous les éléments

## Packages/Modules

### Gestion des Scripts
- ScriptSQL
- HistoriqueVersion
- Metadonnees
- Dependance

### Infrastructure
- SGBD
- Serveur
- BaseDeDonnees

### Sécurité et Utilisateurs
- Utilisateur
- ProfilUtilisateur

### Objets et Applications
- ObjetSQL
- ApplicationJob

### Système Central
- Referentiel

## Fonctionnalités Répondant aux Exigences

### Centralisation
✅ Le référentiel centralise tous les scripts SQL pour différents SGBD

### Documentation
✅ Métadonnées complètes avec auteur, dates, objets impactés

### Traçabilité
✅ Historique complet des versions avec restauration possible

### Gestion des Dépendances
✅ Identification et gestion des dépendances entre scripts

### Sécurité
✅ Gestion des droits d'accès selon les profils et environnements

### Réutilisabilité
✅ Recherche et consultation facilitées dans un environnement multi-SGBD

### Import/Export
✅ Fonctionnalités de sauvegarde et restauration du référentiel

### Visualisation
✅ Interface de consultation avec gestion des modifications

### Journalisation
✅ Historique complet des actions utilisateurs

## Technologies Recommandées

### Backend
- **Langage :** PHP (Laravel 8.0+)
- **Base de données centrale :** PostgreSQL

### Interface Web
- **Framework :** Laravel avec interface moderne
- **UX/UI :** Design responsive et intuitif

### Sécurité
- **Authentification :** Gestion des rôles et permissions
- **Audit :** Journalisation de toutes les actions

Ce diagramme de classes fournit une base solide pour l'implémentation du référentiel centralisé multi-SGBD, répondant à tous les objectifs et exigences fonctionnelles du projet.