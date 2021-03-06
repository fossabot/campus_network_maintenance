<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairDescription extends Model
{
    protected $table = 'repair_description';

    public $timestamps = true;

    protected $dates = [];

    protected $fillable = [
        'repair_id', 'admin_id', 'description',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
