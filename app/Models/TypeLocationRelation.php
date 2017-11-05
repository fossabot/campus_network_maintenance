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

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
