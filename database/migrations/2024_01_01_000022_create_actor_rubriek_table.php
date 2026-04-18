<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actor_rubriek', function (Blueprint $table) {
            $table->unsignedBigInteger('actor_id');
            $table->string('rubriek_id', 20);

            $table->primary(['actor_id', 'rubriek_id']);

            $table->foreign('actor_id')->references('id')->on('actor')->cascadeOnDelete();
            $table->foreign('rubriek_id')->references('id')->on('rubriek')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actor_rubriek');
    }
};
