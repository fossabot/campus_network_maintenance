<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPartUse extends Model
{
    protected $table = 'log_part_use';

    public $timestamps = true;

    protected $dates = [];

    protected $fillable = [
        'repair_id', 'part_id', 'admin_id', 'number',
    ];

    protected $hidden = [];
}
