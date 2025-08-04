# Tableau Récapitulatif - Relations, Flèches et Cardinalités

## Tableau Principal des Relations

| N° | Classe Source | Classe Cible | Cardinalité | Type de Flèche | Relation | Justification |
|----|---------------|--------------|-------------|----------------|----------|---------------|
| 1  | ScriptSQL | SGBD | `1..*` ↔ `1..*` | `--o` | Agrégation | Scripts compatibles avec plusieurs SGBD |
| 2  | ScriptSQL | Serveur | `0..*` ↔ `1` | `-->` | Association | Scripts exécutés sur un serveur |
| 3  | Serveur | BaseDeDonnees | `1` ↔ `1..*` | `*--` | Composition | Serveur héberge bases (dépendance forte) |
| 4  | Utilisateur | ScriptSQL | `1` ↔ `0..*` | `-->` | Association | Utilisateur crée/modifie scripts |
| 5  | ScriptSQL | HistoriqueVersion | `1` ↔ `0..*` | `*--` | Composition | Versions liées au script (cascade) |
| 6  | ScriptSQL | Metadonnees | `1` ↔ `1..*` | `*--` | Composition | Métadonnées obligatoires par script |
| 7  | ScriptSQL | Dependance | `1` ↔ `0..*` | `-->` | Association | Script source de dépendances |
| 8  | ScriptSQL | Dependance | `1` ↔ `0..*` | `-->` | Association | Script cible de dépendances |
| 9  | ScriptSQL | ObjetSQL | `0..*` ↔ `1..*` | `-->` | Association | Scripts manipulent objets SQL |
| 10 | ApplicationJob | ScriptSQL | `0..*` ↔ `1..*` | `o--` | Agrégation | Applications utilisent scripts |
| 11 | Utilisateur | ProfilUtilisateur | `1` ↔ `1` | `--` | Association | Relation un-à-un bidirectionnelle |
| 12 | Referentiel | ScriptSQL | `1` ↔ `0..*` | `*--` | Composition | Référentiel contient scripts |
| 13 | Referentiel | Utilisateur | `1` ↔ `1..*` | `*--` | Composition | Référentiel gère utilisateurs |
| 14 | Referentiel | SGBD | `1` ↔ `1..*` | `o--` | Agrégation | Référentiel supporte SGBD |
| 15 | Referentiel | Serveur | `1` ↔ `0..*` | `o--` | Agrégation | Référentiel administre serveurs |
| 16 | SGBD | BaseDeDonnees | `1` ↔ `0..*` | `-->` | Association | SGBD gère bases de données |
| 17 | BaseDeDonnees | ObjetSQL | `1` ↔ `0..*` | `*--` | Composition | Base contient objets SQL |
| 18 | ProfilUtilisateur | Serveur | `1..*` ↔ `0..*` | `-->` | Association | Profils accèdent aux serveurs |

## Relations vers Énumérations

| N° | Classe | Énumération | Cardinalité | Type de Flèche | Relation |
|----|--------|-------------|-------------|----------------|----------|
| 19 | SGBD | TypeSGBD | `1` ↔ `1` | `-->` | est de type |
| 20 | ObjetSQL | TypeObjet | `1` ↔ `1` | `-->` | est de type |
| 21 | Dependance | TypeDependance | `1` ↔ `1` | `-->` | est de type |
| 22 | Utilisateur | Role | `1` ↔ `1` | `-->` | a pour rôle |

## Légende des Symboles

### Types de Flèches
- `-->` : **Association simple** - Relation de base entre classes
- `--o` : **Agrégation** (◊) - Relation "fait partie de" sans dépendance forte
- `*--` : **Composition** (♦) - Relation "fait partie de" avec dépendance forte
- `--` : **Association bidirectionnelle** - Navigation dans les deux sens

### Cardinalités Utilisées
- `1` : **Exactement un** - Relation obligatoire et unique
- `0..1` : **Zéro ou un** - Relation optionnelle et unique
- `1..*` : **Un ou plusieurs** - Relation obligatoire, plusieurs instances possibles
- `0..*` : **Zéro ou plusieurs** - Relation optionnelle, plusieurs instances possibles

## Relations Critiques (Composition)

Ces relations impliquent une **suppression en cascade** :

1. **Serveur → BaseDeDonnees** : Si le serveur est supprimé, toutes ses bases sont supprimées
2. **ScriptSQL → HistoriqueVersion** : Si le script est supprimé, tout l'historique est supprimé
3. **ScriptSQL → Metadonnees** : Si le script est supprimé, ses métadonnées sont supprimées
4. **Referentiel → ScriptSQL** : Si le référentiel est supprimé, tous les scripts sont supprimés
5. **Referentiel → Utilisateur** : Si le référentiel est supprimé, tous les utilisateurs sont supprimés
6. **BaseDeDonnees → ObjetSQL** : Si la base est supprimée, tous ses objets sont supprimés

## Relations Many-to-Many

Ces relations nécessitent des **tables d'association** :

1. **ScriptSQL ↔ SGBD** : Table `script_sgbd_compatibility`
2. **ScriptSQL ↔ ObjetSQL** : Table `script_objet_manipulation`
3. **ApplicationJob ↔ ScriptSQL** : Table `application_script_usage`
4. **ProfilUtilisateur ↔ Serveur** : Table `profil_serveur_access`
5. **ScriptSQL ↔ ScriptSQL** (via Dependance) : Table `script_dependencies`

## Code PlantUML Simplifié

```plantuml
' Relations principales avec cardinalités
ScriptSQL "1..*" --o "1..*" SGBD
ScriptSQL "0..*" --> "1" Serveur
Serveur "1" *-- "1..*" BaseDeDonnees
Utilisateur "1" --> "0..*" ScriptSQL
ScriptSQL "1" *-- "0..*" HistoriqueVersion
ScriptSQL "1" *-- "1..*" Metadonnees
ScriptSQL "1" --> "0..*" Dependance
ScriptSQL "0..*" --> "1..*" ObjetSQL
ApplicationJob "0..*" o-- "1..*" ScriptSQL
Utilisateur "1" -- "1" ProfilUtilisateur
Referentiel "1" *-- "0..*" ScriptSQL
Referentiel "1" *-- "1..*" Utilisateur
Referentiel "1" o-- "1..*" SGBD
Referentiel "1" o-- "0..*" Serveur
SGBD "1" --> "0..*" BaseDeDonnees
BaseDeDonnees "1" *-- "0..*" ObjetSQL
ProfilUtilisateur "1..*" --> "0..*" Serveur
```

Cette spécification complète vous donne tous les éléments nécessaires pour implémenter correctement le diagramme de classes avec les bonnes relations, flèches et cardinalités.