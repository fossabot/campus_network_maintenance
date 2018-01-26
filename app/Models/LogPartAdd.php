<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPartAdd extends Model
{
    protected $table = 'log_part_add';

    public $timestamps = true;

    protected $dates = [];

    protected $fillable = [
        'part_id', 'admin_id', 'number',
    ];

    public function part()
    {
        return $this->belongsTo(Part::class, 'part_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
