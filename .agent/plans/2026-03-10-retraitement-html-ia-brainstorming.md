# Brainstorming : Retraitement HTML par IA (Gemini)

## Problématique

Le contenu HTML reçu via l'API de synchronisation présente des défauts de rendu qui nuisent à l'esthétique "Premium" du blog. L'objectif est d'utiliser Gemini pour restructurer le HTML sans modifier le contenu textuel.

## Objectifs du Brainstorming

- **Restructuration Visuelle & SEO** : Utiliser Gemini pour transformer un flux HTML brut en une structure optimisée (SEO/GEO) : balisage sémantique, hiérarchie de titres, maillage interne potentiel.
- **Intégrité Textuelle Absolue** : Interdiction formelle de modifier, supprimer ou ajouter des mots au texte original. L'IA agit uniquement comme un "architecte HTML".
- **Éditabilité Manuelle** : Le code produit doit rester propre et compréhensible pour permettre à l'associé d'effectuer des retouches manuelles si nécessaire.
- **Optimisation GEO (Generative Engine Optimization)** : Structurer les données pour être facilement interprétées par les moteurs de recherche génératifs (listes à puces claires, résumés sémantiques intégrés, FAQ structurée).

## Approche de Conception Retenue : "Optimisation Assistée"

### 1. Synchronisation API non-invasive

- Modifier `PostSyncController` pour que les nouveaux articles arrivent avec `is_published = false`.
- L'article est stocké tel quel, permettant à l'associé de le voir en premier.

### 2. Bouton "Mise en page intelligente" dans Filament

- Ajouter une `Action` dans `PostResource` nommée "Optimiser la mise en page (SEO/GEO)".
- Cette action utilisera Gemini avec un prompt strict garantissant l'intégrité du texte original.

### 3. Prompt IA "Architecte Sémantique"

Le prompt imposera :

- Balisage H2/H3 logique.
- Listes à puces pour les énumérations.
- Mise en gras des concepts clés (SEO).
- **Interdiction formelle** de changer, ajouter ou supprimer les mots de l'auteur.

### 4. Workflow de l'Associé

1. Reçoit l'article via l'API (invisible sur le site car non publié).
2. Ouvre l'article dans Filament.
3. Clique sur "Optimiser la mise en page".
4. Vérifie/Modifie manuellement les points de détail.
5. Passe l'article en "En Ligne".

## Questions pour l'utilisateur

1. Quelle est la priorité principale concernant le rendu visuel que vous souhaitez que l'IA "standardise" ?
    - A) Structure hiérarchique (H2, H3, listes).
    - B) Style éditorial PEP (citations, mises en avant).
    - C) Nettoyage technique (styles inline, scories).
2. Souhaitez-vous que ce retraitement soit systématique ou optionnel (via un flag dans le JSON) ?
