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
        Schema::create('food_blog_post_pictures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_blog_post_id')->constrained('food_blog_posts')->onDelete('cascade');
            $table->string('picture_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_blog_post_pictures');
    }
};
