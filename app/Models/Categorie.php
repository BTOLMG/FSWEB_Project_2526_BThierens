<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = 'categorie';

    public $timestamps = false;

    protected $fillable = ['naam'];

    public function actoren(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Actor::class, 'categorie_id');
    }
}
