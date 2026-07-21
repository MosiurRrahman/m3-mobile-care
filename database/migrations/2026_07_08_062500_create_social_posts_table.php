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
        Schema::create('social_posts', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // Facebook, Instagram, Twitter, LinkedIn
            $table->text('content');
            $table->string('media_path')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->string('status')->default('draft'); // draft, scheduled, published
            $table->integer('reach')->default(0);
            $table->integer('engagement')->default(0);
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_posts');
    }
};
