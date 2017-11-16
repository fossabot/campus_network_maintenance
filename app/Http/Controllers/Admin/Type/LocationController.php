<?php

namespace App\Http\Controllers\Admin\Type;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\TypeLocationRelation;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * 获取当前分类已分配的地区
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data($id)
    {
        return response()->json(TypeLocationRelation::whereTypeId($id)->pluck('location_id'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fullData($id)
    {
        $data = [];

        foreach (TypeLocationRelation::whereTypeId($id)->get() as $item) {
            $location = $item->location;
            if (!isset($data[$location->first])) {
                $data = array_merge($data, [$location->first => []]);
            }

            $data[$location->first] = array_merge($data[$location->first], [[
                'id'    => $location->id,
                'value' => $location->second,
            ]]);
        }

        return response()->json($data);
    }

    /**
     * 分配地区
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allot(Request $request)
    {
        // 分类是否存在
        Type::findOrFail($request->input('id'));

        // 清空原来分配的地区
        $this->clearAllot($request);

        // 尝试分配
        if ($this->attemptAllot($request)) {
            return response()->json();
        }

        return response()->json('服务器错误。', 500);
    }

    /**
     * @param Request $request
     *
     * @return bool|mixed|null
     */
    protected function clearAllot(Request $request)
    {
        return TypeLocationRelation::whereTypeId($request->input('id'))->delete();
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function attemptAllot(Request $request)
    {
        $data = [];

        foreach ($request->input('locations') as $id) {
            $data = array_merge($data, [[
                'type_id'     => $request->input('id'),
                'location_id' => $id,
            ]]);
        }

        return TypeLocationRelation::insert($data);
    }
}
