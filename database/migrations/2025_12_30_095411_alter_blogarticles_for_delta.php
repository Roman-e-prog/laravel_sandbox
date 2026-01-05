<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Fix existing values so PostgreSQL can cast them to JSON
        //    If your content is double‑encoded JSON, decode & re‑encode it.
        DB::table('blogarticles')->orderBy('id')->chunk(100, function ($rows) {
            foreach ($rows as $row) {
                $decoded = json_decode($row->article_content, true);

                // If decoding fails, replace with empty Delta
                if ($decoded === null) {
                    $decoded = ['ops' => [['insert' => "\n"]]];
                }

                DB::table('blogarticles')
                    ->where('id', $row->id)
                    ->update([
                        'article_content' => json_encode($decoded)
                    ]);
            }
        });

        // 2. Convert TEXT → JSON using explicit PostgreSQL casting
        DB::statement('
            ALTER TABLE blogarticles
            ALTER COLUMN article_content
            TYPE json
            USING article_content::json
        ');
    }

    public function down(): void
    {
        // Rollback: convert JSON → TEXT
        DB::statement('
            ALTER TABLE blogarticles
            ALTER COLUMN article_content
            TYPE text
            USING article_content::text
        ');
    }
};
