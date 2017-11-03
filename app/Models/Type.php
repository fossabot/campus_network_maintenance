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

    public function getAutoCompleteHoursAttribute($value)
    {
        return $value ? $value . '小时' : '禁用';
    }

    public function getAutoCompleteStarsAttribute($value)
    {
        return $value . '星';
    }

    public function getRealUserAuthAttribute($value)
    {
        return $value ? '是' : '否';
    }

    public function getAllowUserCreateAttribute($value)
    {
        return $value ? '是' : '否';
    }
}
