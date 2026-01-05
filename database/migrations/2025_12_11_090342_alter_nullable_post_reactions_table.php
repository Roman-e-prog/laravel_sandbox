<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('post_reactions', function (Blueprint $table) {
            // Make existing columns nullable
            $table->unsignedBigInteger('post_id')->nullable()->change();
            $table->unsignedBigInteger('answer_id')->nullable()->change();

            // Drop old combined unique
            $table->dropUnique(['post_id', 'user_id', 'answer_id']);

            // Add two separate uniques
            $table->unique(['post_id', 'user_id']);
            $table->unique(['answer_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::table('post_reactions', function (Blueprint $table) {
            // Revert back to NOT NULL
            $table->unsignedBigInteger('post_id')->nullable(false)->change();
            $table->unsignedBigInteger('answer_id')->nullable(false)->change();

            // Restore old unique
            $table->dropUnique(['post_id', 'user_id']);
            $table->dropUnique(['answer_id', 'user_id']);
            $table->unique(['post_id', 'user_id', 'answer_id']);
        });
    }
};
