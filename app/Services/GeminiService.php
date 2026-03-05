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
}
