<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku', 'product_name', 'cost_price','sell_price','wholesale_price','wholesale_quantity', 'branch_id'  , 'qty' , 'stock_level' , 'renter_id', 'brand', 'tags' ,'description'
    ];
}