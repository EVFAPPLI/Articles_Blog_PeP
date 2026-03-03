<?php

use App\Models\Post;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    $latestPosts = \App\Models\Post::published()
        ->latest()
        ->take(3)
        ->get();
        
    // Récupérer le nombre de posts publiés par catégorie
    $categoryCounts = \App\Models\Post::published()
        ->select('category', DB::raw('count(*) as total'))
        ->groupBy('category')
        ->pluck('total', 'category')
        ->toArray();

    return view('home', compact('latestPosts', 'categoryCounts'));
})->name('home');

Route::get('/blog', function () {
    $category = request('category');
    
    $posts = Post::published()
        ->when($category && $category !== 'Tous', function ($query) use ($category) {
            return $query->where('category', $category);
        })
        ->orderBy('published_at', 'desc')
        ->paginate(12);

    return view('blog.index', compact('posts'));
})->name('blog.index');

Route::get('/blog/{slug}', function (string $slug) {
    $post = Post::where('slug', $slug)->firstOrFail();
    return view('blog.show', compact('post'));
})->name('blog.show');
