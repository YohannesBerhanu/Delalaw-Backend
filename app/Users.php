<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Users as Authenticatable;

class Users extends Model
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'firstName', 'lastName', 'email', 'phone', 'gender', 'password', 'is_activated'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
