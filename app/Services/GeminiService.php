<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    /**
     * Envoie une requête à l'API Gemini pour générer ou modifier du contenu.
     *
     * @param string $systemPrompt Instructions ou rôle pour l'IA
     * @param string $userContent Le contenu source à traiter
     * @return string|null La réponse générée ou null en cas d'erreur
     */
    public static function generateContent(string $systemPrompt, string $userContent): ?string
    {
        $apiKey = env('GEMINI_API_KEY');
        $model = env('GEMINI_MODEL', 'gemini-3-flash-preview');

        if (empty($apiKey)) {
            Log::error('Erreur API Gemini : Clé API non configurée (.env)');
            return null;
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $systemPrompt . "\n\nVoici le contenu source :\n" . $userContent]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 8192,
            ]
        ];

        try {
            $response = Http::timeout(60)->post($url, $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                // Extraire le texte de la réponse (Structure de base de Gemini)
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return trim($data['candidates'][0]['content']['parts'][0]['text']);
                }

                Log::warning('Format inattendu reçu de l\'API Gemini.', ['response' => $data]);
            } else {
                Log::error('Échec de la requête Gemini API', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Exception lors de l\'appel à Gemini API : ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Suggère ou améliore un titre de quiz en fonction de la catégorie.
     */
    public static function improveQuizTitle(string $category, ?string $draftTitle = null): ?string
    {
        $prompt = "Tu es un expert en conception de titres accrocheurs et professionnels pour la plateforme PEP (Esprit PEP, Leadership, Flow, etc.).\n";
        $prompt .= "Ta tâche est de générer un titre de quiz pertinent. Le titre doit être : court, percutant, et directement lié au thème.\n\n";
        $prompt .= "Thème / Catégorie : " . $category . "\n";
        
        if ($draftTitle) {
            $prompt .= "L'utilisateur a donné ce brouillon de titre : \"{$draftTitle}\". Améliore-le.\n";
            $prompt .= "Retourne UNIQUEMENT le titre final, sans aucune ponctuation, guillemets ou commentaire. Juste le titre pur.";
        } else {
            $prompt .= "Invente un titre de quiz très accrocheur pour cette catégorie.\n";
            $prompt .= "Retourne UNIQUEMENT le titre final, sans aucune ponctuation inutile ni commentaire.";
        }

        return self::generateContent($prompt, "Génère le titre maintenant.");
    }

    /**
     * Génère un lot de 10 questions de quiz en utilisant la méthode Deep Research stricte.
     */
    public static function generateQuizQuestions(string $category, string $title): ?array
    {
        $prompt = "Tu es un expert pédagogique travaillant pour PEP (Esprit PEP). Ton objectif est de concevoir un quiz d'exactement 10 questions.\n";
        $prompt .= "IL EST STRICTEMENT INTERDIT d'inventer des faits (pas d'hallucinations). Base tes questions sur des faits établis concernant le thème demandé.\n";
        $prompt .= "Catégorie : {$category}\n";
        $prompt .= "Titre du Quiz : {$title}\n\n";
        
        $prompt .= "Tu dois retourner UNIQUEMENT un objet JSON valide, et RIEN D'AUTRE (pas de markdown, pas d'explication avant ou après).\n";
        $prompt .= "Le JSON doit respecter scrupuleusement cette structure :\n";
        $prompt .= "[\n";
        $prompt .= "  {\n";
        $prompt .= "    \"question_text\": \"Texte de la question ?\",\n";
        $prompt .= "    \"options\": [\n";
        $prompt .= "      {\"text\": \"Première option\", \"is_correct\": false},\n";
        $prompt .= "      {\"text\": \"Deuxième option vrai\", \"is_correct\": true},\n";
        $prompt .= "      {\"text\": \"Troisième option\", \"is_correct\": false},\n";
        $prompt .= "      {\"text\": \"Quatrième option\", \"is_correct\": false}\n";
        $prompt .= "    ],\n";
        $prompt .= "    \"explanation\": \"Explication détaillée de la bonne réponse.\"\n";
        $prompt .= "  }\n";
        $prompt .= "]\n";
        
        $prompt .= "Assure-toi qu'il y a toujours exactement une option 'is_correct' à true, et 3 à false. Il doit y avoir exactement 10 questions.";

        $response = self::generateContent($prompt, "Génère le JSON strict maintenant.");

        if ($response) {
            // Nettoyage au cas où Gemini renvoie du texte/markdown autour du JSON
            $response = preg_replace('/```(?:json)?|```/i', '', $response);
            $response = trim($response);

            $decoded = json_decode($response, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            } else {
                Log::error('Erreur de décodage JSON depuis Gemini', ['error' => json_last_error_msg(), 'raw' => $response]);
            }
        }
        return null;
    }
}
