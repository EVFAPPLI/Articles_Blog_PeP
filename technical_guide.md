# 🛠 Guide Technique & Dépannage : Articles_Blog_PeP

Ce document sert de référence technique pour comprendre le fonctionnement interne et résoudre rapidement les problèmes courants.

## 🏗 Architecture du Système

### 1. Composants Clés

- **Modèle `Post.php`** : Entité centrale gérant les articles, le SEO et les métadonnées.
- **Service `ImageService.php`** : Gère le décodage Base64, le redimensionnement (via Visibloo logic) et le stockage physique des images.
- **Contrôleur `PostSyncController.php`** : Point d'entrée de l'API de synchronisation.
- **Ressource Filament `PostResource.php`** : Interface d'administration pour la gestion manuelle.

### 2. Emplacement des Fichiers

- **Modèle** : `app/Models/Post.php`
- **Service** : `app/Services/ImageService.php`
- **API** : `app/Http/Controllers/Api/PostSyncController.php`
- **Routes** : `routes/api.php` & `routes/web.php`
- **Vues** : `resources/views/blog/`

---

## 🔌 API de Synchronisation (`/api/posts/sync`)

### Flux de données

1. Réception du JSON depuis Banana Article via `POST`.
2. Vérification du `Authorization: Bearer [TOKEN]`.
3. Validation des univers PEP (5 catégories imposées).
4. Traitement des images (Couverture + contenu HTML).
5. `updateOrCreate` basé sur le `slug`.

### Sécurité & CORS

- **Token** : Défini dans le contrôleur (ou via `.env` avec `API_SERVICE_TOKEN`).
- **CORS** : Configuré dans `config/cors.php` pour autoriser `outils.visibloo.fr`.

---

## 🖼 Gestion des Images

Les images sont stockées dans `storage/app/public/` :

- `blog-covers/` : Images de une.
- `blog-content/` : Images insérées dans le texte.
- `blog-vignettes/` : Images des extraits.

**Commande importante** : Assurez-vous que le lien symbolique est créé :

```bash
php artisan storage:link
```

---

## 🔍 Guide de Dépannage (Troubleshooting)

| Problème                             | Cause Probable                                            | Solution                                                |
| :----------------------------------- | :-------------------------------------------------------- | :------------------------------------------------------ |
| **Erreur 401 Unauthorized**          | Token manquant ou incorrect dans le header Authorization. | Vérifier le Bearer Token envoyé par Banana Article.     |
| **Erreur 403 Forbidden (CORS)**      | Domaine `outils.visibloo.fr` non autorisé.                | Vérifier `config/cors.php` -> `allowed_origins`.        |
| **Erreur 422 Unprocessable Entity**  | Catégorie non conforme aux univers PEP.                   | Vérifier que la catégorie fait partie des 5 autorisées. |
| **Images ne s'affichent pas**        | Lien symbolique `public/storage` manquant.                | Lancer `php artisan storage:link`.                      |
| **Code PHP visible en haut de page** | Balise `<?php` manquante dans `web.php`.                  | Vérifier le début des fichiers de routes.               |

---

## 🎨 Stratégies de Design (V4 & Premium)

Face aux limitations de compilation CSS en direct ou aux contenus HTML importés via Filament (sans support Tailwind natif complet pour les enfants), deux stratégies robustes sont utilisées :

### 1. Typographie Forcée (Blog V4)

Le rendu des articles (`blog.show`) s'appuie sur des règles écrites directement dans `resources/css/app.css` pour écraser les utilitaires Tailwind standards via des sélecteurs très puissants :

- **Line-height massif** : `line-height: 2.2;` pour imposer un côté éditorial très fluide.
- **Marges importantes** : `margin-bottom: 3.5rem !important;` entre les paragraphes, garantissant aération.
- **`<em>` stylisés** : Transformés en style "Blockquote PEP" (barre latérale bleue, texte plus gros).

### 2. Design "Incassable" (Homepage)

La section "Promo Livre" (homepage) s'appuie délibérément sur du **CSS Inline complet** plutôt que des classes utilitaires Tailwind, garantissant un rendu 100% fidèle sur des environnements cibles où le process Vite (`npm run dev`/`build`) ne tourne pas constamment à jour. Si des ajustements Flex/Grid sont nécessaires, un script JS dédié écoute le resize de fenêtre.

---

## 📝 Commandes de Maintenance

- **Vider le cache des routes** : `php artisan route:clear`
- **Voir les logs en temps réel** : `tail -f storage/logs/laravel.log`
- **Forcer une migration** : `php artisan migrate --force`
