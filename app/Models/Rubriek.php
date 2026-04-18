<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubriek extends Model
{
    protected $table = 'rubriek';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = ['id', 'naam', 'level'];

    public function actoren(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'actor_rubriek', 'rubriek_id', 'actor_id');
    }
}
