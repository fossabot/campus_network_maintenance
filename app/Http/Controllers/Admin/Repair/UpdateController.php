<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RepairRequest;
use App\Models\Repair;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UpdateController extends Controller
{
    /**
     * @param RepairRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RepairRequest $request)
    {
        $repair = Repair::findOrFail($request->input('id'));

        if ($repair->status_id != 1) {
            return response()->json('当前状态为' . $repair->status . '，无法修改。', 422);
        }

        if ($this->attemptUpdate($repair, $request)) {
            return response()->json('', 200);
        }

        return response()->json('服务器错误。', 500);
    }

    /**
     * @param Model         $repair
     * @param RepairRequest $request
     *
     * @return bool
     */
    protected function attemptUpdate(Model $repair, RepairRequest $request)
    {
        return $repair->forceFill(array_merge($request->only([
            'user_id', 'user_name', 'user_mobile', 'type_id', 'location_id', 'user_room', 'user_description',
        ]), [
            'updated_at' => Carbon::now(),
        ]))->save();
    }
}
