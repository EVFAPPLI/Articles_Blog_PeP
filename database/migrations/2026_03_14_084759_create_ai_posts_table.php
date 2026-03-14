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
        Schema::create('ai_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('source_content')->nullable();
            $table->longText('html_content')->nullable();
            $table->longText('vignette_content')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('image_prompt')->nullable();
            $table->string('category')->nullable();
            $table->string('status')->default('draft'); // draft, transferred
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_posts');
    }
};
