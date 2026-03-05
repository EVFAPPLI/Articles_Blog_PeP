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
                    'version' => '1.2.0',
                    'date' => Carbon::now()->translatedFormat('d F Y'),
                    'title' => 'L\'IA s\'invite dans votre Blog ! 🪄',
                    'changes' => [
                        ['type' => 'NOUVEAU', 'color' => 'success', 'text' => 'Baguette Magique IA : Génération automatique d\'un court extrait (vignette) attractif depuis le contenu de l\'article.'],
                        ['type' => 'NOUVEAU', 'color' => 'success', 'text' => 'Baguette Magique IA : Rédaction SEO-friendly et ultra-ciblée de votre Méta Description.'],
                        ['type' => 'NOUVEAU', 'color' => 'success', 'text' => 'Baguette Magique IA : Extraction automatique de 5 à 8 mots-clés hyper-pertinents.'],
                        ['type' => 'AMÉLIORATION', 'color' => 'info', 'text' => 'Baguette Magique IA (Améliorer) : Correction, copywriting, et optimisation syntaxique de vos articles en 1 clic.'],
                        ['type' => 'UX', 'color' => 'primary', 'text' => 'Système de fenêtres (Modules) "Avant / Après" introduites pour valider et modifier le texte de l\'IA avant tout remplacement.'],
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
