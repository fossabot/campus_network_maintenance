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

    protected $appends = [
        'role',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function getRoleAttribute()
    {
        switch ($this->attributes['role_id']) {
            case 1:
                return '维修人员';
                break;
            case 5:
                return '管理员';
                break;
            case 9:
                return '超级管理员';
                break;
            default:
                return '未知';
        }
    }
}
