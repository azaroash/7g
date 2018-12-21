<?php

namespace willvincent\Rateable;

use Config;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'ratings';

    public $fillable = ['client_id','totalRating', 'averageRating', 'memberCount'];
    /**
     * @return mixed
     */
    public function rateable()
    {
        return $this->morphTo();
    }
    /**
     * Rating belongs to a user.
     *
     * @return User
     */
    public function user()
    {
        $userClassName = Config::get('auth.model');
        if (is_null($userClassName)) {
            $userClassName = Config::get('auth.providers.users.model');
        }
        return $this->belongsTo($userClassName);
    }
    public function client()
    {
        $clientClassName = Config::get('auth.model');
        if (is_null($clientClassName)) {
            $clientClassName = Config::get('auth.providers.clients.model');
        }

        return $this->belongsTo($clientClassName);
    }
}
