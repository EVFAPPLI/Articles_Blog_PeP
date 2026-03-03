<?php

use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/blog', function () {
    $posts = Post::published()->orderBy('published_at', 'desc')->paginate(12);
    return view('blog.index', compact('posts'));
})->name('blog.index');

Route::get('/blog/{slug}', function (string $slug) {
    $post = Post::where('slug', $slug)->firstOrFail();
    return view('blog.show', compact('post'));
})->name('blog.show');
