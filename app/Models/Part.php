<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $table = 'part';

    public $timestamps = false;

    protected $dates = [];

    protected $fillable = [
        'name', 'left_number',
    ];
}
