<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'item_name', 'quantity', 'price', 'payment_mode',
    ];
}
