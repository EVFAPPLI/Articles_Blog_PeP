<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Carbon\Carbon;

class ChangelogWidget extends Widget
{
    protected static string $view = 'filament.widgets.changelog-widget';

    // Prend toute la largeur si le panneau le permet, ou la moitié selon la config locale.
    protected int | string | array $columnSpan = 'full';

    // Place le widget en haut du Dashboard
    protected static ?int $sort = 1;

    protected function getViewData(): array
    {
        return [
            'releases' => [
                [
                    'version' => '1.3.0',
                    'date' => Carbon::now()->translatedFormat('d F Y'),
                    'title' => 'Amélioration de l\'Intelligence Artificielle 🎨',
                    'changes' => [
                        ['type' => 'UX', 'color' => 'primary', 'text' => 'Baguette Magique IA (Modale) : L\'aperçu visuel final avant acceptation des modifications est sécurisé contre les débordements CSS.'],
                        ['type' => 'EXPLICATION', 'color' => 'warning', 'text' => 'Assistant IA (Demande Modif) : Destiné à donner des instructions PRÉCISES à l\'IA sur son texte ("Met ce paragraphe en exergue", "Change tous les H2 en H3"). Il PEUT modifier, effacer ou ajouter des mots.'],
                        ['type' => 'EXPLICATION', 'color' => 'success', 'text' => 'Mise en page Intelligente : Destiné à "Habiller" un texte brut. L\'IA ajoute des couleurs, des puces (<ul>) et des titres (<h2>, <h3>) avec un design Ultra Moderne sans JAMAIS changer ou effacer un seul de vos mots.'],
                    ],
                ],
                [
                    'version' => '1.2.0',
                    'date' => Carbon::now()->translatedFormat('d F Y'),
                    'title' => 'L\'IA s\'invite dans votre Blog ! 🪄',
                    'changes' => [
                        ['type' => 'NOUVEAU', 'color' => 'success', 'text' => 'Baguette Magique IA : Génération automatique d\'un court extrait (vignette) attractif depuis le contenu de l\'article.'],
                        ['type' => 'NOUVEAU', 'color' => 'success', 'text' => 'Baguette Magique IA : Rédaction SEO-friendly et ultra-ciblée de votre Méta Description.'],
                        ['type' => 'NOUVEAU', 'color' => 'success', 'text' => 'Baguette Magique IA : Extraction automatique de 5 à 8 mots-clés hyper-pertinents.'],
                        ['type' => 'AMÉLIORATION', 'color' => 'info', 'text' => 'Baguette Magique IA (Améliorer) : Correction, copywriting, et optimisation syntaxique de vos articles en 1 clic.'],
                        ['type' => 'UX', 'color' => 'primary', 'text' => 'Système de fenêtres (Modules) "Avant / Après" introduites pour valider et modifier le texte de l\'IA avant tout remplacement.'],
                        ['type' => 'CORRECTION', 'color' => 'danger', 'text' => 'Résolution du problème de débordement du texte (overflow) sur la vue publique des articles.'],
                    ],
                ],
                [
                    'version' => '1.1.0',
                    'date' => Carbon::now()->subDay()->translatedFormat('d F Y'),
                    'title' => 'Édition Avancée : Plus de limites \ud83d\udcdd',
                    'changes' => [
                        ['type' => 'NOUVEAU', 'color' => 'success', 'text' => 'Remplacement de l\'éditeur basique par TinyMCE. Une expérience calquée sur Microsoft Word.'],
                        ['type' => 'FONCTIONNALITÉ', 'color' => 'warning', 'text' => 'Contrôle déverrouillé sur les tailles de police (en pt ou px) au cœur des articles.'],
                        ['type' => 'FONCTIONNALITÉ', 'color' => 'warning', 'text' => 'Module de Colorimétrie : changez la couleur de votre texte ou surlignez-le précisément !'],
                        ['type' => 'UX', 'color' => 'primary', 'text' => 'Optimisation verticale de l\'éditeur de la vignette pour un meilleur confort visuel.'],
                    ],
                ],
            ]
        ];
    }
}
