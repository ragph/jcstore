<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherProduct extends Model
{
    protected $fillable = [
        'voucher_id','location_id'
    ];
}
