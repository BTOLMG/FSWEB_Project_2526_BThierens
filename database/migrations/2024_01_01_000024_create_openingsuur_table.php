<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('openingsuur', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id');

            $table->enum('dag_van_de_week', [
                'maandag', 'dinsdag', 'woensdag', 'donderdag',
                'vrijdag', 'zaterdag', 'zondag',
            ]);

            $table->time('startuur');
            $table->time('einduur');

            $table->enum('type', ['online', 'open', 'op afspraak', 'telefonisch']);

            $table->foreign('actor_id')->references('id')->on('actor')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('openingsuur');
    }
};
