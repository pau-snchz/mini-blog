<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'full_name',
        'email',
        'password',
        'is_banned',
        'profile_picture',
        'user_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted()
    {
        static::addGlobalScope('notBanned', function ($query) {
            $query->where('is_banned', false);
        });
    }
}