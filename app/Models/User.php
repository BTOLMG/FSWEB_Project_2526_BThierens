<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'gebruiker';

    public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'rol',
        'email',
        'wachtwoord',
        'actor_id',
    ];

    protected $hidden = [
        'wachtwoord',
    ];

    protected function casts(): array
    {
        return [
            'wachtwoord' => 'hashed',
        ];
    }

    public function getAuthPasswordName(): string
    {
        return 'wachtwoord';
    }

    public function getRememberToken(): ?string
    {
        return null;
    }

    public function setRememberToken($value): void {}

    public function getRememberTokenName(): string
    {
        return '';
    }

    public function actor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Actor::class, 'actor_id');
    }
}
