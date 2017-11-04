<?php

namespace App\Http\Controllers\Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\TypeLocationRelation;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $location = Location::findOrFail($request->input('id'));

        if (!$location->second && Location::whereFirst($location->first)->count() > 1) {
            return response()->json('请先删除' . $location->first . '下的所有次要地区。', 422);
        }

        if ($location->delete()) {
            TypeLocationRelation::whereLocationId($request->input('id'))->delete();

            return response()->json('', 200);
        }

        return response()->json('服务器错误。', 500);
    }
}
