<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subject')->nullable();
            $table->longText('html_content')->nullable();
            $table->json('image_prompts')->nullable();
            $table->string('status')->default('draft');
            $table->string('category')->nullable();
            $table->string('author')->default('Visibloo');
            $table->timestamp('published_at')->nullable();
            $table->string('cover_image')->nullable();
            $table->longText('vignette_content')->nullable();
            $table->string('meta_description')->nullable();
            $table->json('keywords')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('last_google_indexing_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
