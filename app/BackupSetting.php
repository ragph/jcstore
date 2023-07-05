<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackupSetting extends Model
{
    protected $fillable = ['backup_name','date','time'];
}
