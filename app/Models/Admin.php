<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';

    public $timestamps = true;

    protected $dates = [];

    protected $fillable = [
        'role_id', 'type_id', 'username', 'name', 'mobile', 'company',
    ];

    protected $hidden = [
        'password',
    ];
}
