<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Repair\CreateRequest;
use App\Models\Repair;
use App\Models\TypeLocationRelation;
use Illuminate\Support\Carbon;

class CreateController extends Controller
{
    /**
     * @param CreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRequest $request)
    {
        if ($this->role() != 9 && $request->input('type_id') != $this->type()) {
            return response()->json('没有此操作的权限。', 403);
        }

        if (!$this->checkLocationExist($request->input('type_id'), $request->input('location_id'))) {
            return response()->json('请刷新后重试。', 422);
        }

        if ($id = $this->attemptCreate($request)) {
            return response()->json($id, 200);
        }

        return response()->json('服务器错误。', 500);
    }

    /**
     * @param $type_id
     * @param $location_id
     *
     * @return bool
     */
    protected function checkLocationExist($type_id, $location_id)
    {
        return (bool)TypeLocationRelation::whereTypeId($type_id)->whereLocationId($location_id)->first();
    }

    /**
     * @param CreateRequest $request
     *
     * @return int
     */
    protected function attemptCreate(CreateRequest $request)
    {
        $now = Carbon::now();

        $data = array_merge($request->only([
            'user_id', 'user_name', 'user_mobile', 'type_id', 'location_id', 'user_room', 'user_description',
        ]), [
            'status_id'  => 1,
            'admin_id'   => $this->id(),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        if ($request->input('repair') == true) {
            $data = array_merge($data, [
                'status_id'   => 3,
                'accepted_at' => $now,
                'repaired_at' => $now,
            ]);
        }

        return Repair::insertGetId($data);
    }
}
