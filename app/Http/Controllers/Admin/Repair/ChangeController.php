<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Http\Controllers\Controller;
use App\Models\Repair;
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

        switch ($request->input('type')) {
            case 'accept':
                $status_id = 2;
                if ($repair->status_id != 1) {
                    return response()->json('当前状态为' . $repair->status . '。', 422);
                }
                break;
            case 'finish':
                $status_id = 3;
                if ($repair->status_id != 2) {
                    return response()->json('当前状态为' . $repair->status . '。', 422);
                }
                break;
            case 'delete':
                $status_id = 0;
                if ($repair->status_id != 1) {
                    return response()->json('当前状态为' . $repair->status . '，无法删除。', 422);
                }
                break;
            default:
                return response()->json('错误的类型。', 500);
                break;
        }

        if ($this->attemptUpdate($repair, $status_id)) {
            return response()->json('', 200);
        }

        return response()->json('服务器错误。', 500);
    }

    /**
     * @param Repair $repair
     * @param        $status_id
     *
     * @return bool
     */
    protected function attemptUpdate(Repair $repair, $status_id)
    {

        return $repair->update([
            'status_id'  => $status_id,
            'updated_at' => Carbon::now(),
        ]);
    }
}
