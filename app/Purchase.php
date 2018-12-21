<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property array|null|string member_id
 */
class Purchase extends Model
{
    //
    

    public $timestamps = false;

    protected $table = 'purchase';

    protected $fillable = ['client_id', 'member_id', 'amount','commission', 'purchaseDate'];
}