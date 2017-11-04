<?php

namespace App\Http\Controllers\Admin\Type;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\TypeLocationRelation;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function data($id)
    {
        return response()->json(TypeLocationRelation::whereTypeId($id)->pluck('location_id'), 200);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allot(Request $request)
    {
        Type::findOrFail($request->input('id'));

        $this->clearAllot($request);

        if ($this->attemptAllot($request)) {
            return response()->json('', 200);
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
