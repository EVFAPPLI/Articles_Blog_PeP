<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiPost extends Model
{
    protected $fillable = [
        'title',
        'source_content',
        'html_content',
        'vignette_content',
        'cover_image',
        'image_prompt',
        'category',
        'status',
        'youtube_url',
        'post_id',
    ];
}
