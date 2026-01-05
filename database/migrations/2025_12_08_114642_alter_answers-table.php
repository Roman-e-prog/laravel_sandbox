<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Anwers;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //to alter a table I must use table not create
    public function up(): void
        {
            Schema::table('answers', function (Blueprint $table) {
                $table->foreignId('parent_id')
                    ->nullable()
                    ->constrained('answers')
                    ->onDelete('cascade');
            });
        }

        public function down(): void
        {
            Schema::table('answers', function (Blueprint $table) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            });
        }

};
