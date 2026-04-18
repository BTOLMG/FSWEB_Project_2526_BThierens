<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contactgegeven', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id');
            $table->enum('type', ['mail', 'telefoonnr', 'online']);
            $table->string('waarde', 500);

            $table->foreign('actor_id')->references('id')->on('actor')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contactgegeven');
    }
};
