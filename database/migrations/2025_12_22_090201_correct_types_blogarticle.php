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
      Schema::table('blogarticles', function (Blueprint $table) 
      { 
        $table->text('title')->change(); 
        $table->text('article_content')->change(); 
        $table->text('description')->change(); 
        $table->text('unit')->change(); 
        $table->text('author')->change(); 
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogarticles', function (Blueprint $table) 
      { 
        $table->string('title')->change(); 
        $table->string('article_content')->change(); 
        $table->string('description')->change(); 
        $table->string('unit')->change(); 
        $table->string('author')->change(); 
    });
    }
};
