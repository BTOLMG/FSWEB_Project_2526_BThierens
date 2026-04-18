<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gebruiker', function (Blueprint $table) {
            $table->foreign('actor_id')->references('id')->on('actor')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('gebruiker', function (Blueprint $table) {
            $table->dropForeign(['actor_id']);
        });
    }
};
