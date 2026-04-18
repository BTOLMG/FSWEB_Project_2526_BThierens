<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contactgegeven extends Model
{
    protected $table = 'contactgegeven';

    public $timestamps = false;

    protected $fillable = ['actor_id', 'type', 'waarde'];

    public function actor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Actor::class, 'actor_id');
    }
}
