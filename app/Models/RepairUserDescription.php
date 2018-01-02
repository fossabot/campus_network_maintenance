<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairUserDescription extends Model
{
    protected $table = 'repair_user_description';

    public $timestamps = false;

    protected $dates = [];

    protected $fillable = [
        'type_id', 'description',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }
}
