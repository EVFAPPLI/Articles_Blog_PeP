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

## 📅 Phase 4 : Design & UX (À venir)

- **[ ] Refonte Graphique Blog** : Application d'un design premium (Liquid Glass / Modern Blog layout).
- **[ ] Système de Recherche** : Ajout d'une barre de recherche sur le blog.
- **[ ] Newsletters / E-letters** : Intégration du système de diffusion basé sur les articles.

---

_Dernière mise à jour : 3 mars 2026_
