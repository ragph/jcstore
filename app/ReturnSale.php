<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnSale extends Model
{
    protected $fillable = [
        'sale_id','saleprod_id','quantity','date_return','notes','created_by'
    ];
}
