<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnProduct extends Model
{
    protected $fillable = [
        'location_id', 'product_id', 'quantity','date' , 'note'
    ];
}
