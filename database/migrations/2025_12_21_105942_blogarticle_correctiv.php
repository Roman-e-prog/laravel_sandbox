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
          Schema::table('blogarticles', function (Blueprint $table) {
                $table->dropColumn('images_path');
                $table->renameColumn('external_inks', 'external_links');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogarticles', function (Blueprint $table) { $table->renameColumn('external_links', 'external_inks'); $table->json('images_path')->nullable(); });
    }
};
