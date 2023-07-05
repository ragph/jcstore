<?php

namespace App;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = [
        'user_id','branch','renters_profile','cube_management','product_management','inventory','pos','users','rent_management','report','settings','sale_collections'
    ];
    public function users(){
        return $this->belongsTo(User::class);
    }
}

