<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoxManagement extends Model
{
    protected $fillable = [
        'renter_id','branch','box_id','rental_cost','due_date','description','date_of_contract','end_of_contract'
    ];
}
