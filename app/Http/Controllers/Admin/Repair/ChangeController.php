<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Http\Controllers\Controller;
use App\Models\LogPartUse;
use App\Models\Part;
use App\Models\Repair;
use App\Models\RepairDescription;
use App\Models\RepairUserDescription;
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

                $description = RepairUserDescription::whereTypeId($repair->type_id)->whereDescription($repair->user_description)->first();

                $repair_description = $request->input('repair_description');
                if (!$repair_description && !$description) {
                    return response()->json('维修备注 不能为空。', 422);
                }

                $use = $request->input('use');
                if (is_array($use)) {
                    foreach ($request->input('use') as $item) {
                        $part = Part::whereName($item['name'])->first();
                        if ($part) {
                            LogPartUse::insert([
                                'repair_id'  => $repair->id,
                                'part_id'    => $part->id,
                                'admin_id'   => $this->id(),
                                'number'     => $item['number'],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                        }
                    }
                }

                $this->createDescription($request->input('repair_description') ?: $description->admin_description, $repair->id, $now);
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
            return response()->json();
        }

        return response()->json('服务器错误。', 500);
    }

    /**
     * @param Repair $repair
     * @param array $data
     *
     * @return bool
     */
    protected function attemptUpdate(Repair $repair, $data)
    {
        return $repair->forceFill($data)->save();
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
