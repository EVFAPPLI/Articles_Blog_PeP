<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostSyncController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Handle the incoming blog post sync request.
     */
    public function sync(Request $request)
    {
        // Authentification via Token (configuré dans .env)
        $secretToken = config('services.api.token');
        $authHeader = $request->header('Authorization');
        
        if (!$authHeader || $authHeader !== 'Bearer ' . $secretToken) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'content' => 'required|string',
                'excerpt' => 'required|string',
                'image' => 'nullable|string',
                'meta_description' => 'nullable|string|max:255',
                'keywords' => 'nullable',
                'category' => 'required|string|in:Esprit PEP,Boîte à outils,Pilotage,Leadership,Flow',
            ]);

            $slug = Str::slug($validated['slug']);

            // 1. Image de couverture
            $coverImagePath = null;
            if (!empty($validated['image'])) {
                $coverImagePath = $this->imageService->saveBase64Image(
                    $validated['image'], 
                    'blog-covers', 
                    $slug . '-' . time()
                );
            }

            // 2. Images dans le contenu HTML
            $processedContent = $this->imageService->processHtmlImages($validated['content'], 'blog-content');
            
            // 3. Images dans l'extrait (vignette)
            $cleanExcerpt = preg_replace('/<img[^>]+\>/i', '', $validated['excerpt']);
            $processedExcerpt = $this->imageService->processHtmlImages($cleanExcerpt, 'blog-vignettes');

            // 4. Mots-clés
            $keywords = $request->input('keywords');
            if (is_string($keywords) && !empty($keywords)) {
                $keywords = array_map('trim', explode(',', $keywords));
            }

            // 5. Nettoyage final du contenu (Suppression des scories de l'IA)
            $unwantedPatterns = [
                '/<p>.*?Et plus.*?<\/p>/is',
                '/<p>.*?Lire la suite.*?<\/p>/is',
                '/<p>.*?Vignette.*?<\/p>/is',
                '/Et plus\.\.\./i',
                '/Lire la suite/i',
            ];
            $processedContent = preg_replace($unwantedPatterns, '', $processedContent);
            $processedExcerpt = preg_replace($unwantedPatterns, '', $processedExcerpt);

            // 6. Synchro
            $post = Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $validated['title'],
                    'html_content' => $processedContent,
                    'vignette_content' => $processedExcerpt,
                    'cover_image' => $coverImagePath,
                    'meta_description' => $validated['meta_description'] ?? null,
                    'keywords' => $keywords,
                    'category' => $validated['category'] ?? null,
                    'author' => 'PEP worldwide',
                    'is_published' => true,
                    'published_at' => Post::where('slug', $slug)->first()?->published_at ?? now(),
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Article synced successfully',
                'data' => [
                    'id' => $post->id,
                    'slug' => $post->slug,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
