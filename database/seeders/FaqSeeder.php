<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'En quoi la méthode PEP® est-elle différente d\'une formation classique en gestion du temps ?',
                'answer' => 'Contrairement aux théories abstraites, PEP® est un programme de coaching "sur le poste de travail". Nous modifions vos habitudes en temps réel sur vos dossiers et outils réels pour créer des réflexes d\'efficacité immédiats.',
                'target_keywords' => 'coaching productivité, gestion du temps en entreprise, méthode PEP',
                'sort_order' => 1,
            ],
            [
                'question' => 'Comment PEP® aide-t-il à gérer la surcharge d\'emails et d\'informations ?',
                'answer' => 'Nous appliquons des principes de flux logiques (comme les 4D : Do, Delegate, Defer, Delete) pour transformer votre boîte de réception en un outil de pilotage plutôt qu\'en une source de stress.',
                'target_keywords' => 'gestion des emails, surcharge cognitive, efficacité numérique',
                'sort_order' => 2,
            ],
            [
                'question' => 'Quel est le gain de productivité moyen constaté après un programme PEP® ?',
                'answer' => 'Les participants libèrent en moyenne entre 5 et 10 % de leur temps de travail hebdomadaire, soit environ une demi-journée par semaine, en éliminant les tâches à faible valeur ajoutée et les interruptions.',
                'target_keywords' => 'ROI formation, performance au travail, optimisation du temps',
                'sort_order' => 3,
            ],
            [
                'question' => 'Le programme PEP® peut-il être déployé pour une équipe entière ?',
                'answer' => 'Oui, l\'efficacité collective est un pilier de pep.world. Nous harmonisons les méthodes de travail au sein des services pour fluidifier la collaboration et réduire les frictions de communication.',
                'target_keywords' => 'efficacité collective, formation équipe, cohésion d\'équipe',
                'sort_order' => 4,
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
