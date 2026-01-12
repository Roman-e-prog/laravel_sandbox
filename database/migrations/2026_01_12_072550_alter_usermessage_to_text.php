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
         DB::statement('
            ALTER TABLE usermessages
            ALTER COLUMN usermessage
            TYPE text
            USING usermessage::text
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      
         // 1. Fix existing values so PostgreSQL can cast them to JSON
        //    If your content is double‑encoded JSON, decode & re‑encode it.
        DB::table('usermessages')->orderBy('id')->chunk(100, function ($rows) {
            foreach ($rows as $row) {
                $decoded = json_decode($row->usermessage, true);

                // If decoding fails, replace with empty Delta
                if ($decoded === null) {
                    $decoded = ['ops' => [['insert' => "\n"]]];
                }

                DB::table('usermessages')
                    ->where('id', $row->id)
                    ->update([
                        'usermessage' => json_encode($decoded)
                    ]);
            }
        });

        // 2. Convert TEXT → JSON using explicit PostgreSQL casting
        DB::statement('
            ALTER TABLE usermessages
            ALTER COLUMN usermessage
            TYPE json
            USING usermessage::json
        ');
    }
};
