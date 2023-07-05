<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    protected $fillable = [
        'location_id','sale_id','product_id','quantity','saleprice','price','subtotal'
    ];
}