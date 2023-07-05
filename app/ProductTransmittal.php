<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTransmittal extends Model
{
    protected $table = 'product_transmittals';

    protected $fillable = [
        'product_id','previous_supplier','current_supplier','date_transferred','note'
    ];
}