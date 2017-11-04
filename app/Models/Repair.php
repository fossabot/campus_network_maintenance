<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $table = 'repair';

    public $timestamps = true;

    protected $dates = [
        'accepted_at', 'repaired_at', 'completed_at',
    ];

    protected $fillable = [
        'status_id', 'type_id', 'location_id', 'admin_id',
        'user_id', 'user_name', 'user_mobile', 'user_description', 'user_star', 'user_evaluation',
    ];
}
