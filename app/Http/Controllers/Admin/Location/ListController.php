<?php

namespace App\Http\Controllers\Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Location;

class ListController extends Controller
{
    /**
     * 获取主要地区列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function first()
    {
        return response()->json(Location::whereNull('second')->orderBy('first')->get(), 200);
    }

    /**
     * 获取次要地区列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function second()
    {
        return response()->json(Location::whereNotNull('second')->orderBy('first')->get(), 200);
    }
}
