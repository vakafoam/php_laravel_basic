<?php

namespace App;

use App\Notifications\CustomPasswordReset;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;  // enables sending notifications

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts() 
    {
        return $this->hasMany('App\Post');
    }

    // overriding the default function and providing our own notification service
    public function sendPasswordResetNotification($token) 
    {
        $this->notify(new CustomPasswordReset($token));
    }
}
