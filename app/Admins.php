<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
    //
    public $timestamps = false;

    protected $table = 'admins';

    protected $fillable = ['id', 'firstName', 'lastName','email', 'phone','position','userName', 'password'];

}
