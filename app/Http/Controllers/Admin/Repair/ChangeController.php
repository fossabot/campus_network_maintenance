<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use App\Models\RepairDescription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChangeController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function change(Request $request)
    {
        $repair = Repair::find($request->input('id'));

        $now = Carbon::now();

        switch ($request->input('type')) {
            case 'accept':
                $data = [
                    'status_id'   => 2,
                    'accepted_at' => $now,
                    'updated_at'  => $now,
                ];
                if ($repair->status_id != 1) {
                    return response()->json('当前状态为' . $repair->status . '。', 422);
                }
                break;
            case 'finish':
                $data = [
                    'status_id'   => 3,
                    'repaired_at' => $now,
                    'updated_at'  => $now,
                ];
                if ($repair->status_id != 2) {
                    return response()->json('当前状态为' . $repair->status . '。', 422);
                }
                $this->createDescription($request->input('repair_description'), $repair->id, $now);
                break;
            case 'delete':
                $data = [
                    'status_id'  => 0,
                    'updated_at' => $now,
                ];
                if ($repair->status_id != 1) {
                    return response()->json('当前状态为' . $repair->status . '，无法删除。', 422);
                }
                break;
            case 'addDescription':
                $data = [
                    'updated_at' => $now,
                ];
                if ($repair->status_id < 3) {
                    return response()->json('当前状态为' . $repair->status . '。', 422);
                }
                $this->createDescription($request->input('repair_description'), $repair->id, $now);
                break;
            default:
                return response()->json('错误的类型。', 500);
                break;
        }

        if ($this->attemptUpdate($repair, $data)) {
            return response()->json('', 200);
        }

        return response()->json('服务器错误。', 500);
    }

    /**
     * @param Repair $repair
     * @param array  $data
     *
     * @return bool
     */
    protected function attemptUpdate(Repair $repair, $data)
    {
        return $repair->update($data);
    }

    /**
     * @param $repair_description
     * @param $id
     * @param $now
     *
     * @return bool
     */
    protected function createDescription($repair_description, $id, $now)
    {
        return RepairDescription::insert([
            'repair_id'   => $id,
            'admin_id'    => $this->id(),
            'description' => $repair_description,
            'created_at'  => $now,
            'updated_at'  => $now,
        ]);
    }
}
