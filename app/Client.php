<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AppNotification;
use App\Notifications\SmsNotification;
use willvincent\Rateable\Rateable;

class Client extends Authenticatable
{
    use Notifiable;
    use Rateable;

    protected $guard = 'client';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'companyName', 'businessName', 'tradeName', 'location', 'categories', 'logo', 'phone', 'email', 'password', 'is_activated',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
