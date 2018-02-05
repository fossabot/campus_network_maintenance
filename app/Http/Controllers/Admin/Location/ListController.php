<?php

namespace App\Http\Controllers\Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Location;

class ListController extends Controller
{
    /**
     * 获取一级区域列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function first()
    {
        return response()->json(Location::whereNull('second')->orderBy('first')->get());
    }

    /**
     * 获取二级区域列表
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function second()
    {
        return response()->json(Location::whereNotNull('second')->orderBy('first')->get());
    }

    public function full()
    {
        $data = [];

        foreach (Location::whereNotNull('second')->orderBy('first')->get() as $location) {
            if (!isset($data[$location->first])) {
                $data = array_merge($data, [$location->first => []]);
            }
            $data[$location->first] = array_merge($data[$location->first], [
                [
                    'id'    => $location->id,
                    'value' => $location->second,
                ]
            ]);
        }

        return response()->json($data);
    }
}
