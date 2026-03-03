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

## 📝 Commandes de Maintenance

- **Vider le cache des routes** : `php artisan route:clear`
- **Voir les logs en temps réel** : `tail -f storage/logs/laravel.log`
- **Forcer une migration** : `php artisan migrate --force`
