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



    /**
     * Formate un texte brut en HTML premium.
     */
    public static function formatToHtml(string $textContent, ?string $youtubeUrl = null): ?string
    {
        $prompt = "Tu es un designer et intégrateur web de classe mondiale spécialisé dans le design ultra-moderne, premium et 'branché'.
        
        RÈGLE ABSOLUE ET INVIOLABLE NUMÉRO 1 :
        TU NE DOIS SOUS AUCUN PRÉTEXTE MODIFIER, RÉÉCRIRE, RÉSUMER OU INVENTER DU TEXTE. 
        Ton travail consiste EXACTEMENT à prendre le texte fourni par l'utilisateur MOT POUR MOT (jusqu'à la moindre virgule ou faute), et à l'encapsuler dans de belles balises HTML stylisées. Ton rôle est PUREMENT VISUEL ET ESTHÉTIQUE. Si tu changes un seul mot, tu vas détruire le travail de l'auteur.
        
        RÈGLES DE DESIGN (OBLIGATOIRES) : 
        1. Utilise EXCLUSIVEMENT du CSS inline (attribut style=\"...\"). Ne génère pas de balises <style> ni de classes externes.
        2. DESIGN ULTRA-MODERNE : Utilise des espacements généreux (margins/paddings massifs), des ombres douces (box-shadow...), des bordures arrondies (border-radius: 1.5rem).
        3. TYPOGRAPHIE : Paragraphes aérés (line-height: 1.9, color: #334155, font-size: 1.15rem). Titres spectaculaires avec de magnifiques couleurs.
        4. ÉLÉMENTS RICHES : Sublimer les citations, listes à puces, et liens.
        5. INTERDICTION ABSOLUE DE COUPER LES MOTS (hyphens: none).
        6. NE GÉNÈRE AUCUN PIED DE PAGE (footer), NI EN-TÊTE (header), NI MENTIONS DE DROITS D'AUTEUR.
        7. RETOURNE DIRECTEMENT LE CONTENU DE L'ARTICLE (pas de balises <html>, <head> ou <body>).";
        
        if (!empty($youtubeUrl)) {
            $prompt .= "\n\nINTEGRATION YOUTUBE (TRÈS IMPORTANT) :
        L'utilisateur a fourni ce lien YouTube : {$youtubeUrl}.
        Tu DOIS intégrer cette vidéo dans l'article en créant un lecteur vidéo (iframe). 
        Place ce lecteur vidéo dans l'article, de manière intelligente et esthétique (par exemple, juste après le premier paragraphe ou un titre principal, ou au centre).
        Le lecteur vidéo doit être 100% responsive, avec un style premium (bords arrondis, ombre douce). Utilise un wrapper du type <div style=\"position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; border-radius: 1.5rem; box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); margin: 2rem 0;\"><iframe src=\"(Ici l'url convertie en version embed, ex: https://www.youtube.com/embed/XXXX)\" style=\"position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe></div>. Assure-toi de bien convertir le lien standard watch?v= en lien d'intégration /embed/ !";
        }
        
        $prompt .= "\n\nRetourne UNIQUEMENT le code HTML final correspondant très exactement au texte source.";

        $response = self::generateContent($prompt, $textContent);

        if ($response) {
            return preg_replace('/```(?:html)?|```/i', '', $response);
        }
        return null;
    }

    /**
     * Génère une vignette avec 'Lire la suite' depuis un contenu HTML complet.
     */
    public static function generateVignette(string $htmlContent): ?string
    {
        $prompt = "Rédige un court extrait très attractif et percutant (2 à 3 phrases max) résumant parfaitement cet article de blog. Ne retourne que l'extrait sous format HTML (ex: dans un <p>), et termine OBLIGATOIREMENT le texte par \"... <a href=\"#\" class=\"read-more\" style=\"font-weight: bold; color: #3b82f6;\">Lire la suite</a>\"";
        
        $response = self::generateContent($prompt, strip_tags($htmlContent));

        if ($response) {
            return preg_replace('/```(?:html)?|```/i', '', $response);
        }
        return null;
    }
}
