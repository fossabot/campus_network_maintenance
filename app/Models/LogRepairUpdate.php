<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogRepairUpdate extends Model
{
    protected $table = 'log_repair_update';

    public $timestamps = true;

    protected $dates = [];

    protected $fillable = [
        'repair_id', 'user_id', 'admin_id',
        'update_location_id', 'update_user_id', 'update_user_name', 'update_user_mobile',
        'update_user_description',
    ];

    protected $hidden = [];
}
