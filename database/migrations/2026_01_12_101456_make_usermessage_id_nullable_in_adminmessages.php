<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('adminmessages', function (Blueprint $table) {
        // 1. Make the column nullable
        $table->unsignedBigInteger('usermessage_id')->nullable()->change();
    });

    Schema::table('adminmessages', function (Blueprint $table) {
        // 2. Add the foreign key constraint (it does not exist yet)
        $table->foreign('usermessage_id')
              ->references('id')->on('usermessages')
              ->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('adminmessages', function (Blueprint $table) {
        // Remove FK only if it exists
        $table->dropForeign(['usermessage_id']);

        // Make column NOT NULL again
        $table->unsignedBigInteger('usermessage_id')->nullable(false)->change();
    });
}

};
