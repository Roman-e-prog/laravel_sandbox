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
         // 1. Fix existing values so PostgreSQL can cast them to JSON
        //    If your content is double‑encoded JSON, decode & re‑encode it.
        DB::table('posts')->orderBy('id')->chunk(100, function ($rows) {
            foreach ($rows as $row) {
                $decoded = json_decode($row->blog_post_body, true);

                // If decoding fails, replace with empty Delta
                if ($decoded === null) {
                    $decoded = ['ops' => [['insert' => "\n"]]];
                }

                DB::table('posts')
                    ->where('id', $row->id)
                    ->update([
                        'blog_post_body' => json_encode($decoded)
                    ]);
            }
        });

        // 2. Convert TEXT → JSON using explicit PostgreSQL casting
        DB::statement('
            ALTER TABLE posts
            ALTER COLUMN blog_post_body
            TYPE json
            USING blog_post_body::json
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         DB::statement('
            ALTER TABLE posts
            ALTER COLUMN blog_post_body
            TYPE text
            USING blog_post_body::text
        ');
    }
};
