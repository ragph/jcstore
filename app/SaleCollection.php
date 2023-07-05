<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleCollection extends Model
{
    protected $fillable = [
        'renter_id','amount','note','sales_from' , 'sales_to' , 'date_released'
    ];
}
