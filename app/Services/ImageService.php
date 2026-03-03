<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Save a Base64 string as an image file.
     */
    public function saveBase64Image(string $base64String, string $folder = 'blog-covers', ?string $filename = null): ?string
    {
        if (empty($base64String)) {
            return null;
        }

        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            $base64String = substr($base64String, strpos($base64String, ',') + 1);
            $type = strtolower($type[1]);

            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png', 'webp'])) {
                $type = 'png';
            }
        } else {
            $type = 'png';
        }

        $base64String = base64_decode($base64String);

        if ($base64String === false) {
            return null;
        }

        $filename = $filename ?? Str::random(40);
        $filePath = $folder . '/' . $filename . '.' . $type;

        Storage::disk('public')->put($filePath, $base64String);

        return $filePath;
    }

    /**
     * Parse HTML content, extract Base64 images, save them, and replace sources with URLs.
     */
    public function processHtmlImages(string $htmlContent, string $folder = 'blog-content'): string
    {
        if (empty($htmlContent)) {
            return '';
        }

        return preg_replace_callback('/src="(data:image\/[^;]+;base64,[^"]+)"/', function ($matches) use ($folder) {
            $base64Src = $matches[1];
            $savedPath = $this->saveBase64Image($base64Src, $folder);

            if ($savedPath) {
                return 'src="/storage/' . $savedPath . '"';
            }

            return $matches[0];
        }, $htmlContent);
    }
}
