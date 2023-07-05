<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RenterBranch extends Model
{
    protected $fillable = [
        'renter_id', 'branch_id',
    ];
}
