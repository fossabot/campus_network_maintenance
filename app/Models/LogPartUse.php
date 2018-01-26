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

    public function repair()
    {
        return $this->belongsTo(Repair::class, 'repair_id', 'id');
    }

    public function part()
    {
        return $this->belongsTo(Part::class, 'part_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
