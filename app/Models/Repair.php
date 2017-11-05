<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $table = 'repair';

    public $timestamps = true;

    protected $dates = [
        'accepted_at', 'repaired_at', 'completed_at',
    ];

    protected $fillable = [
        'status_id', 'type_id', 'location_id', 'admin_id',
        'user_id', 'user_name', 'user_mobile', 'user_description', 'user_star', 'user_evaluation',
    ];

    protected $appends = [
        'status',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function description()
    {
        return $this->hasMany(RepairDescription::class, 'repair_id', 'id');
    }

    public function getStatusAttribute()
    {
        switch ($this->attributes['status_id']) {
            case 0:
                return '已删除';
                break;
            case 1:
                return '等待维修';
                break;
            case 2:
                return '正在维修';
                break;
            case 3:
                return '维修完成';
                break;
            case 4:
                return '评价完成';
                break;
            default:
                return '错误状态';
                break;
        }
    }
}
