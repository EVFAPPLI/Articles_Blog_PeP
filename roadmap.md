# 🚀 Roadmap du Projet : Articles_Blog_PeP

Ce document récapitule l'état d'avancement du projet et définit les prochaines étapes de développement.

## ✅ Phase 1 : Initialisation du Socle Technique

- **[x] Configuration Laravel 12 & Docker Sail** : Environnement de développement prêt.
- **[x] Installation de Filament 3.2** : Interface d'administration fonctionnelle.
- **[x] Sécurité (Shield)** : Mise en place du RBAC (Rôles & Permissions).
- **[x] Gestion Utilisateurs** : Ressource `UserResource` opérationnelle pour le `super_admin`.

## ✅ Phase 2 : Réplication du Système de Blog (Visibloo Standard)

- **[x] Modélisation (Post Model)** : Création de la table `posts` avec tous les champs métier et SEO.
- **[x] ImageService** : Service de traitement automatique des images Base64 vers stockage local.
- **[x] API de Synchronisation** : Endpoint `/api/posts/sync` pour recevoir les articles de l'IA.
- **[x] Administration Filament** : Interface `PostResource` avec sections SEO et gestion HTML.
- **[x] Vues Publiques (MVP)** : Routes `/blog` et `/blog/{slug}` avec rendu HTML brut.

## 🔄 Phase 3 : Optimisation & Services Avancés (En cours)

- **[x] Univers PEP (PEP.uno)** : Intégration des 5 catégories spécifiques (Esprit PEP, Flow, Leadership, etc.).
- **[x] Documentation Technique** : Création du `technical_guide.md` pour la maintenance.
- **[ ] Intégration Google Indexing API** : Automatiser l'indexation dès la publication.
- **[ ] Configuration Gemini (GenAI)** : Ajout des clés services pour l'aide à la rédaction.

## ✅ Phase 4 : Design Homepage & Bento Grid (Terminé)

- **[x] Dynamisation** : Modification de la route `/` pour afficher les compteurs d'articles par catégorie dans le Bento Grid.
- **[x] Section Promo Livre "Si Simple"** : Refonte en "Premium Light" avec bouton et backlink redirigeant vers la boutique `pep.world`.
- **[x] Intégration Marque** : Logo officiel PEP.uno ajouté à la barre de navigation. Backlinks (SEO) vers pep.world dans le footer.

## ✅ Phase 5 : Système de Blog (Design & API) (Terminé)

- **[x] Typographie & Espacement (V4 Forced Style)** : Injection de règles CSS directes (`app.css`) pour garantir une lecture "Premium" (Interligne profond, marges de 3.5rem entre les paragraphes).
- **[x] Citations PEP** : Les balises `<em>` issues de l'éditeur sont automatiquement stylisées comme des blocs de citation avec un marqueur latéral.
- **[x] Filtrage par Univers** : Modification de la route et intégration des paramètres pour filtrer via `?category=`.
- **[x] UI/UX Badges** : Badges de catégories à haut contraste (blanc sur fond saturé).

## 🔄 Phase 6 : Recherche & SEO avancé (À venir)

- **[ ] Système de Recherche** : Ajout d'une barre de recherche sur le blog.
- **[ ] Newsletters / E-letters** : Intégration du système de diffusion basé sur les articles.

## 🔄 Phase 7 : Module FAQ Administrable (En cours)

- **[ ] Architecture Data** : Modèle `Faq` et Migration.
- **[ ] Back-Office** : Création de `FaqResource` pour Filament.
- **[ ] Seeding** : Injection des 4 questions/réponses initiales.
- **[ ] Frontend** : Route, lien dans la Navbar et page publique (Design Premium Accordéon).

---

_Dernière mise à jour : 3 mars 2026_
