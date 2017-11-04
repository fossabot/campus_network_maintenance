<?php

namespace App\Http\Controllers\Admin\Type;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Database\Eloquent\Model;

class ListController extends Controller
{
    /**
     * 获取维修分类列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        return response()->json(Type::all()->map([$this, 'transformer'])->toArray(), 200);
    }

    /**
     * @param Model $type
     *
     * @return array
     */
    public function transformer(Model $type)
    {
        /**
         * @var Type $type
         */
        return [
            'id'                  => $type->id,
            'name'                => $type->name,
            'introduction'        => $type->introduction ?: '暂无描述',
            'auto_complete_hours' => $type->auto_complete_hours ? $type->auto_complete_hours . '小时' : '禁用',
            'auto_complete_stars' => $type->auto_complete_stars . '星',
            'real_user_auth'      => $type->real_user_auth ? '是' : '否',
            'allow_user_create'   => $type->allow_user_create ? '是' : '否',
        ];
    }
}
