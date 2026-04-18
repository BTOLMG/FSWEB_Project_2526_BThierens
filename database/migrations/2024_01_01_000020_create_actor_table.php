<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actor', function (Blueprint $table) {
            $table->id();
            $table->string('publieke_naam', 255);

            $table->unsignedBigInteger('categorie_id');
            $table->foreign('categorie_id')->references('id')->on('categorie');

            $table->enum('betaalwijze', ['gratis', 'sociaal tarief', 'online betaling'])->nullable();

            $table->enum('leeftijdscategorie', [
                'kinderen', 'jongeren', 'jongvolwassenen', 'volwassenen', 'ouderen',
            ])->nullable();

            $table->integer('leeftijd_min')->nullable();
            $table->integer('leeftijd_max')->nullable();

            $table->string('straatnaam', 255)->nullable();
            $table->string('huisnummer', 20)->nullable();
            $table->string('busnummer', 20)->nullable();
            $table->string('gemeente', 255)->nullable();
            $table->string('postcode', 20)->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lon', 11, 8)->nullable();

            $table->unsignedBigInteger('contactpersoon_gebruiker_id')->nullable();
            $table->foreign('contactpersoon_gebruiker_id')->references('id')->on('gebruiker')->nullOnDelete();

            $table->text('aangeboden_diensten')->nullable();
            $table->text('opmerkingen')->nullable();
            $table->date('last_updated')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actor');
    }
};
