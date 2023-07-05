<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'reference_no','customer_name','payment','total_items','tax','total_payment', 'created_by','sale_type','status'
    ];
}