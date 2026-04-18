<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rubriek', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('naam', 255);
            $table->integer('level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rubriek');
    }
};
