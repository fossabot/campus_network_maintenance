<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeLocationRelation extends Model
{
    protected $table = 'type_location_relation';

    public $timestamps = false;

    protected $dates = [];

    protected $fillable = [
        'type_id', 'location_id',
    ];

    protected $hidden = [];
}
