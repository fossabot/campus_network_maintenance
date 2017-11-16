<?php

namespace App\Http\Controllers\Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\TypeLocationRelation;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    /**
     * 删除维修地区
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $location = Location::findOrFail($request->input('id'));

        // 如果删除的是主要地区则要求手动删除所有次要地区
        if (!$location->second && Location::whereFirst($location->first)->count() > 1) {
            return response()->json('请先删除' . $location->first . '下的所有次要地区。', 422);
        }

        // 删除地区并删除所有分类分配的地区
        if ($location->delete()) {
            TypeLocationRelation::whereLocationId($request->input('id'))->delete();

            return response()->json();
        }

        return response()->json('服务器错误。', 500);
    }
}
