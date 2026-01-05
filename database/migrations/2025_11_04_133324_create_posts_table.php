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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ressort');
            $table->string('username');
            $table->string('title');
            $table->text('blog_post_body');
            $table->string('images_path')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_answered')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('slug')->unique();
            $table->string('status')->default('draft');
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
