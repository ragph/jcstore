<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
    protected $fillable = [
        'id','fullname', 'address', 'contact_number','email' , 'date_registered'
    ];


}
