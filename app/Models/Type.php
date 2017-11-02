<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'type';

    public $timestamps = true;

    protected $dates = [];

    protected $fillable = [
        'name', 'introduction', 'auto_complete_hours', 'auto_complete_stars',
        'real_user_auth', 'allow_user_create',
    ];

    protected $hidden = [];
}
