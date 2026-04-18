<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Openingsuur extends Model
{
    protected $table = 'openingsuur';

    public $timestamps = false;

    protected $fillable = [
        'actor_id',
        'dag_van_de_week',
        'startuur',
        'einduur',
        'type',
    ];

    public function actor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Actor::class, 'actor_id');
    }
}
