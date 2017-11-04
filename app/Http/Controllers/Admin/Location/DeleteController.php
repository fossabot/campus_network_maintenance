<?php

namespace App\Http\Controllers\Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Location;
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
        if (Location::findOrFail($request->input('id'))->delete()) {
            return response()->json('', 200);
        }

        return response()->json('服务器错误。', 500);
    }
}
