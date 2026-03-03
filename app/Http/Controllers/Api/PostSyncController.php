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
        // Authentification simplifiée (Token Secret)
        $secretToken = config('services.api.token', 'f06f3d4fc4e63c50e206de748ee96eaa3dce98b3dca57a05dc65e395b6312076');
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
                'category' => 'nullable|string',
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

            // 5. Synchro
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
                    'author' => 'Visibloo',
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
