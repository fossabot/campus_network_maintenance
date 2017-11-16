<?php

namespace App\Http\Controllers\Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Location;

class DetailController extends Controller
{
    /**
     * 获取维修地区详情
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data($id)
    {
        return response()->json(Location::findOrFail($id));
    }
}
