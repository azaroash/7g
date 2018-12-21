<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    //
    public $timestamps = false;

    protected $table = 'transactions';

    protected $fillable = ['amount', 'member_id', 'commission', 'paid', 'memberCount', 'deferredExpense', 'totalDeferredExpense', 'grossProfit', 'contingency', 'date'];
}