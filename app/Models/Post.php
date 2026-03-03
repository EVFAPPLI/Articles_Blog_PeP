<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'title',
        'slug',
        'subject',
        'html_content',
        'image_prompts',
        'status',
        'category',
        'author',
        'published_at',
        'cover_image',
        'vignette_content',
        'meta_description',
        'keywords',
        'is_published',
        'last_google_indexing_at',
    ];

    protected $casts = [
        'image_prompts' => 'array',
        'keywords' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'last_google_indexing_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
