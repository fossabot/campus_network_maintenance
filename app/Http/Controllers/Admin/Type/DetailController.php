<?php

namespace App\Http\Controllers\Admin\Type;

use App\Http\Controllers\Controller;
use App\Models\Type;

class DetailController extends Controller
{
    /**
     * 获取维修分类详情
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data($id)
    {
        return response()->json(Type::findOrFail($id), 200);
    }
}
