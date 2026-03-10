# Brainstorming : Remplacer TinyMCE par un Assistant Éditorial IA (NLA)

## 1. Contexte du Projet

- **Problème :** L'éditeur par défaut de Filament (TinyMCE) supprime les classes CSS avancées (ex: `.ai-sources`, `.ai-content`) générées par l'IA lors de la sauvegarde, ce qui casse le rendu Premium sur le site public.
- **Idée de l'utilisateur :** Supprimer l'éditeur manuel complexe et le remplacer par un assistant conversationnel IA (Natural Language Action - NLA) intégré directement à l'article pour modifier le contenu de manière chirurgicale ("Mets cette phrase en rouge", "Corrige la faute").
- **Objectif :** Garantir un rendu 100% fidèle ("ce que l'IA génère, le blog l'affiche") et simplifier drastiquement l'expérience de l'associé.

## 2. Décisions Utilisateur (Clarification)

- **Q1 : Modalité de validation** : Option B (Validation via Aperçu). L'associé doit voir le bon résultat avant de l'appliquer.
- **Q2 : Mode de saisie manuel (Fallback)** : Un éditeur de code HTML "coloré" (syntax highlighter) doit être disponible pour que l'associé puisse corriger de petites fautes d'orthographe sans repasser par l'IA. Pas d'éditeur WYSIWYG destructif comme TinyMCE.

## 3. Approches Techniques Proposées (UI/UX)

Nous savons **ce** que nous voulons (un chat IA + un éditeur HTML). La question est de savoir **où** le positionner dans `PostResource`.

- **Option 1 : La Modale "Super Assistant" (Le plus simple)**
    - On remplace TinyMCE par un champ CodeEditor (coloré) Filament.
    - On ajoute un gros bouton "✨ Demander une modification" au-dessus.
    - Au clic, une modale s'ouvre. On a :
        1.  Un champ pour taper l'instruction ("Mets le titre en rouge").
        2.  Un espace où l'IA affiche le nouveau code (en prévisualisation ou en code).
        3.  Le bouton "Accepter le changement".
    - _Avantage :_ Rapide à développer, très propre, n'encombre pas la page principale.

- **Option 2 : Le "Block Builder" Hybride (Très Premium)**
    - La page d'édition de l'article est divisée en deux.
    - À gauche : Le champ de code HTML.
    - À droite : Un "Chatbot" permanent ("Que puis-je faire pour cet article ?"). On discute, l'IA répond, et actualise le texte à gauche si on le lui demande.
    - _Avantage :_ Extrêmement moderne, ressemble à un vrai outil d'IA. _Inconvénient :_ Complexe à intégrer dans l'architecture standard de Filament.

## 4. Design Présenté

[EN ATTENTE DU CHOIX UI]
