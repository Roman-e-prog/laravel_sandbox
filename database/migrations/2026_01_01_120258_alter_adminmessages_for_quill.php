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
        DB::table('adminmessage')->orderBy('id')->chunk(100, function ($rows) {
            foreach ($rows as $row) {
                $decoded = json_decode($row->adminmessage, true);

                // If decoding fails, replace with empty Delta
                if ($decoded === null) {
                    $decoded = ['ops' => [['insert' => "\n"]]];
                }

                DB::table('adminmessage')
                    ->where('id', $row->id)
                    ->update([
                        'adminmessage' => json_encode($decoded)
                    ]);
            }
        });

        // 2. Convert TEXT → JSON using explicit PostgreSQL casting
        DB::statement('
            ALTER TABLE adminmessage
            ALTER COLUMN adminmessage
            TYPE json
            USING adminmessage::json
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            // Rollback: convert JSON → TEXT
        DB::statement('
            ALTER TABLE adminmessage
            ALTER COLUMN adminmessage
            TYPE text
            USING adminmessage::text
        ');
    }
};
