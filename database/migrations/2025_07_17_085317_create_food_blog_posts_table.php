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
        Schema::create('food_blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('cafe_name');
            $table->string('location')->nullable();
            $table->string('opening_hours')->nullable();
            $table->text('description')->nullable();

            $table->string('blogger_top_drink')->nullable();
            $table->string('blogger_top_food')->nullable();

            $table->tinyInteger('score_affordability')->nullable();
            $table->tinyInteger('score_ambiance')->nullable();
            $table->tinyInteger('score_taste')->nullable();
            $table->tinyInteger('score_overall')->nullable();

            $table->integer('like_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_blog_posts');
    }
};