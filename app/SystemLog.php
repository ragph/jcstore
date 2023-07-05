<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $table = 'system_logs';
    
    protected $fillable = [
        'users_id','activity_id','activity','action','date','time','details'
    ];
}
