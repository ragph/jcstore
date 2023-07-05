<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [
        'box_id','month_covered','amount','cheque_number','bank','renter_id','cash','is_cheque'
    ];

    protected $casts = [
        'is_cheque' => 'boolean',
      ];
}