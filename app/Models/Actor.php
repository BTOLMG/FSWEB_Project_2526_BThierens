<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $table = 'actor';

    protected $fillable = [
        'publieke_naam',
        'categorie_id',
        'betaalwijze',
        'leeftijdscategorie',
        'leeftijd_min',
        'leeftijd_max',
        'straatnaam',
        'huisnummer',
        'busnummer',
        'gemeente',
        'postcode',
        'lat',
        'lon',
        'contactpersoon_gebruiker_id',
        'aangeboden_diensten',
        'opmerkingen',
        'last_updated',
    ];

    protected function casts(): array
    {
        return [
            'lat'          => 'float',
            'lon'          => 'float',
            'last_updated' => 'date',
        ];
    }

    // Relationships

    public function categorie(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function rubrieken(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Rubriek::class, 'actor_rubriek', 'actor_id', 'rubriek_id');
    }

    public function contactgegevens(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Contactgegeven::class, 'actor_id');
    }

    public function openingsuren(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Openingsuur::class, 'actor_id');
    }

    public function contactpersoon(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'contactpersoon_gebruiker_id');
    }
}
