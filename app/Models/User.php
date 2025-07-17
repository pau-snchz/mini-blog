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
        'profile_picture',
        'user_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}