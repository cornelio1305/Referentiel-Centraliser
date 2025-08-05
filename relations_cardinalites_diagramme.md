# Relations, Flèches et Cardinalités - Diagramme de Classes Référentiel SQL

## Guide des Symboles UML

### Types de Flèches
- `-->` : Association simple
- `--o` : Agrégation (losange vide)
- `--*` : Composition (losange plein)
- `--|>` : Héritage/Généralisation
- `..>` : Dépendance
- `...|>` : Réalisation d'interface

### Cardinalités
- `1` : Exactement un
- `0..1` : Zéro ou un
- `1..*` : Un ou plusieurs
- `0..*` : Zéro ou plusieurs
- `*` : Plusieurs (équivalent à 0..*)
- `n` : Nombre fixe n

## Relations Détaillées du Système

### 1. ScriptSQL ↔ SGBD
```
ScriptSQL "1..*" --o "1..*" SGBD : "compatible avec"
```
- **Type** : Agrégation
- **Cardinalité** : Plusieurs scripts peuvent être compatibles avec plusieurs SGBD
- **Justification** : Un script peut être adapté à plusieurs SGBD, un SGBD supporte plusieurs scripts

### 2. ScriptSQL ↔ Serveur
```
ScriptSQL "0..*" --> "1" Serveur : "exécuté sur"
```
- **Type** : Association
- **Cardinalité** : Plusieurs scripts peuvent s'exécuter sur un serveur
- **Justification** : Un script s'exécute sur un serveur spécifique, un serveur peut exécuter plusieurs scripts

### 3. Serveur ↔ BaseDeDonnees
```
Serveur "1" --* "1..*" BaseDeDonnees : "héberge"
```
- **Type** : Composition
- **Cardinalité** : Un serveur héberge une ou plusieurs bases de données
- **Justification** : Les bases de données dépendent du serveur pour leur existence

### 4. Utilisateur ↔ ScriptSQL
```
Utilisateur "1" --> "0..*" ScriptSQL : "crée/modifie"
```
- **Type** : Association
- **Cardinalité** : Un utilisateur peut créer/modifier plusieurs scripts
- **Justification** : Un script a un auteur unique, un utilisateur peut créer plusieurs scripts

### 5. ScriptSQL ↔ HistoriqueVersion
```
ScriptSQL "1" --* "0..*" HistoriqueVersion : "versionné par"
```
- **Type** : Composition
- **Cardinalité** : Un script peut avoir plusieurs versions
- **Justification** : Les versions dépendent du script parent et sont supprimées avec lui

### 6. ScriptSQL ↔ Metadonnees
```
ScriptSQL "1" --* "1..*" Metadonnees : "décrit par"
```
- **Type** : Composition
- **Cardinalité** : Un script a au moins une métadonnée
- **Justification** : Les métadonnées sont intrinsèques au script

### 7. ScriptSQL ↔ Dependance (Auto-relation)
```
ScriptSQL "0..*" --> "0..*" ScriptSQL : "dépend de"
```
- **Type** : Association réflexive via Dependance
- **Cardinalité** : Un script peut dépendre de plusieurs autres scripts
- **Justification** : Gestion des prérequis d'exécution

### 8. ScriptSQL ↔ ObjetSQL
```
ScriptSQL "0..*" --> "1..*" ObjetSQL : "manipule"
```
- **Type** : Association
- **Cardinalité** : Un script manipule au moins un objet SQL
- **Justification** : Un script agit sur des objets de base de données

### 9. ApplicationJob ↔ ScriptSQL
```
ApplicationJob "0..*" --o "1..*" ScriptSQL : "utilise"
```
- **Type** : Agrégation
- **Cardinalité** : Une application peut utiliser plusieurs scripts
- **Justification** : Les scripts peuvent être réutilisés par plusieurs applications

### 10. Utilisateur ↔ ProfilUtilisateur
```
Utilisateur "1" --> "1" ProfilUtilisateur : "possède"
```
- **Type** : Association
- **Cardinalité** : Relation un-à-un
- **Justification** : Chaque utilisateur a un profil unique

### 11. Referentiel ↔ ScriptSQL
```
Referentiel "1" --* "0..*" ScriptSQL : "gère"
```
- **Type** : Composition
- **Cardinalité** : Le référentiel contient tous les scripts
- **Justification** : Les scripts appartiennent au référentiel

### 12. Referentiel ↔ Utilisateur
```
Referentiel "1" --* "1..*" Utilisateur : "contient"
```
- **Type** : Composition
- **Cardinalité** : Le référentiel gère les utilisateurs
- **Justification** : Les utilisateurs sont définis dans le contexte du référentiel

### 13. Referentiel ↔ SGBD
```
Referentiel "1" --o "1..*" SGBD : "supporte"
```
- **Type** : Agrégation
- **Cardinalité** : Le référentiel supporte plusieurs SGBD
- **Justification** : Les SGBD peuvent exister indépendamment du référentiel

### 14. Referentiel ↔ Serveur
```
Referentiel "1" --o "0..*" Serveur : "administre"
```
- **Type** : Agrégation
- **Cardinalité** : Le référentiel peut administrer plusieurs serveurs
- **Justification** : Les serveurs peuvent exister indépendamment

### 15. SGBD ↔ BaseDeDonnees
```
SGBD "1" --> "0..*" BaseDeDonnees : "gère"
```
- **Type** : Association
- **Cardinalité** : Un SGBD peut gérer plusieurs bases de données
- **Justification** : Les bases de données sont créées dans un type de SGBD spécifique

### 16. BaseDeDonnees ↔ ObjetSQL
```
BaseDeDonnees "1" --* "0..*" ObjetSQL : "contient"
```
- **Type** : Composition
- **Cardinalité** : Une base contient plusieurs objets SQL
- **Justification** : Les objets SQL appartiennent à une base de données

### 17. ProfilUtilisateur ↔ Serveur
```
ProfilUtilisateur "1..*" --> "0..*" Serveur : "accède à"
```
- **Type** : Association
- **Cardinalité** : Un profil peut accéder à plusieurs serveurs
- **Justification** : Gestion des droits d'accès par environnement

## Relations avec les Classes d'Énumération

### 18. SGBD ↔ TypeSGBD
```
SGBD "1" --> "1" TypeSGBD : "est de type"
```
- **Type** : Association
- **Cardinalité** : Un SGBD a un type spécifique

### 19. ObjetSQL ↔ TypeObjet
```
ObjetSQL "1" --> "1" TypeObjet : "est de type"
```
- **Type** : Association
- **Cardinalité** : Un objet SQL a un type spécifique

### 20. Dependance ↔ TypeDependance
```
Dependance "1" --> "1" TypeDependance : "est de type"
```
- **Type** : Association
- **Cardinalité** : Une dépendance a un type spécifique

### 21. Utilisateur ↔ Role
```
Utilisateur "1" --> "1" Role : "a pour rôle"
```
- **Type** : Association
- **Cardinalité** : Un utilisateur a un rôle spécifique

## Résumé des Cardinalités par Classe

### ScriptSQL (Classe centrale)
- Vers SGBD : `1..*` ↔ `1..*`
- Vers Serveur : `0..*` ↔ `1`
- Vers Utilisateur : `0..*` ↔ `1`
- Vers HistoriqueVersion : `1` ↔ `0..*`
- Vers Metadonnees : `1` ↔ `1..*`
- Vers ObjetSQL : `0..*` ↔ `1..*`
- Vers ApplicationJob : `1..*` ↔ `0..*`
- Vers Referentiel : `0..*` ↔ `1`

### Referentiel (Classe gestionnaire)
- Vers ScriptSQL : `1` ↔ `0..*`
- Vers Utilisateur : `1` ↔ `1..*`
- Vers SGBD : `1` ↔ `1..*`
- Vers Serveur : `1` ↔ `0..*`

## Code PlantUML Complet avec Cardinalités

```plantuml
@startuml
' Relations avec cardinalités précises

ScriptSQL ||--o{ SGBD : "1..* compatible avec 1..*"
ScriptSQL }o--|| Serveur : "0..* exécuté sur 1"
Serveur ||--*{ BaseDeDonnees : "1 héberge 1..*"
Utilisateur ||--o{ ScriptSQL : "1 crée/modifie 0..*"
ScriptSQL ||--*{ HistoriqueVersion : "1 versionné par 0..*"
ScriptSQL ||--*{ Metadonnees : "1 décrit par 1..*"
ScriptSQL }o--o{ ScriptSQL : "0..* dépend de 0..*"
ScriptSQL }o--o{ ObjetSQL : "0..* manipule 1..*"
ApplicationJob }o--o{ ScriptSQL : "0..* utilise 1..*"
Utilisateur ||--|| ProfilUtilisateur : "1 possède 1"
Referentiel ||--*{ ScriptSQL : "1 gère 0..*"
Referentiel ||--*{ Utilisateur : "1 contient 1..*"
Referentiel ||--o{ SGBD : "1 supporte 1..*"
Referentiel ||--o{ Serveur : "1 administre 0..*"
SGBD ||--o{ BaseDeDonnees : "1 gère 0..*"
BaseDeDonnees ||--*{ ObjetSQL : "1 contient 0..*"
ProfilUtilisateur }o--o{ Serveur : "1..* accède à 0..*"

' Relations vers énumérations
SGBD ||--|| TypeSGBD : "1 est de type 1"
ObjetSQL ||--|| TypeObjet : "1 est de type 1"
Dependance ||--|| TypeDependance : "1 est de type 1"
Utilisateur ||--|| Role : "1 a pour rôle 1"

@enduml
```

## Notes Importantes

1. **Composition vs Agrégation** :
   - Composition (`--*`) : Dépendance forte, suppression en cascade
   - Agrégation (`--o`) : Dépendance faible, existence indépendante

2. **Cardinalités critiques** :
   - ScriptSQL vers Metadonnees : `1..*` (au moins une métadonnée obligatoire)
   - Referentiel vers Utilisateur : `1..*` (au moins un administrateur)
   - ScriptSQL vers ObjetSQL : `1..*` (un script manipule au moins un objet)

3. **Relations réflexives** :
   - ScriptSQL peut dépendre d'autres ScriptSQL via la classe Dependance

Cette spécification détaillée vous permettra d'implémenter correctement toutes les relations dans votre diagramme UML.