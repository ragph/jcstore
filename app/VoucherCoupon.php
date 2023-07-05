<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherCoupon extends Model
{
    protected $fillable = [
        'voucher_name','type','status', 'percentage' , 'price_type' , 'fix_price'
    ];
}
