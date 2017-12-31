<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Repair;
use Carbon\Carbon;

class ViewController extends Controller
{
    public function data($type, $start, $end)
    {
        $admins = Admin::whereIn('role_id', [1, 5]);

        if ($type) {
            $admins = $admins->whereTypeId($type);
        }

        $time = [
            'now'              => Carbon::now(),
            'startOfToday'     => Carbon::today(),
            'startOfYesterday' => Carbon::yesterday(),
            'startOfThisMonth' => (new Carbon())->startOfMonth(),
            'customStart'      => $start ? Carbon::parse($start) : Carbon::now(),
            'customEnd'        => $end ? Carbon::parse($end)->endOfDay() : Carbon::now(),
        ];

        $data1 = $data2 = $data3 = $data4 = $data5 = $data6 = $data7 = [];

        foreach ($admins->get() as $admin) {
            $today = $this->countRepair($admin->id, [$time['startOfToday'], $time['now']]);
            $yesterday = $this->countRepair($admin->id, [$time['startOfYesterday'], $time['startOfToday']]);
            $month = $this->countRepair($admin->id, [$time['startOfThisMonth'], $time['now']]);
            $custom = $this->countRepair($admin->id, [$time['customStart'], $time['customEnd']]);

            $data1 = array_merge($data1, [
                [
                    '维修人员' => $admin->name,
                    '今日'   => $today,
                    '昨日'   => $yesterday,
                    '本月'   => $month,
                    '自定义'  => $custom
                ]
            ]);
            $data2 = array_merge($data2, [
                [
                    '维修人员' => $admin->name,
                    '响应时间' => $this->countTime($admin->id, 1, [$time['customStart'], $time['customEnd']]),
                    '维修时间' => $this->countTime($admin->id, 2, [$time['customStart'], $time['customEnd']]),
                    '反馈时间' => $this->countTime($admin->id, 3, [$time['customStart'], $time['customEnd']])
                ]
            ]);
            $data3 = array_merge($data3, [['维修人员' => $admin->name, '用户评分' => $this->countStar($admin->id, [$time['customStart'], $time['customEnd']])]]);
            $data4 = array_merge($data4, [['维修人员' => $admin->name, '数量' => $today]]);
            $data5 = array_merge($data5, [['维修人员' => $admin->name, '数量' => $yesterday]]);
            $data6 = array_merge($data6, [['维修人员' => $admin->name, '数量' => $month]]);
            $data7 = array_merge($data7, [['维修人员' => $admin->name, '数量' => $custom]]);
        }

        return response()->json([
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
            'data4' => $data4,
            'data5' => $data5,
            'data6' => $data6,
            'data7' => $data7,
        ]);
    }

    /**
     * @param       $id
     * @param array $time
     *
     * @return int
     */
    protected function countRepair($id, array $time)
    {
        return Repair::whereAdminId($id)->whereIn('status_id', [3, 4])->whereBetween('repaired_at', $time)->count();
    }

    protected function countTime($id, $case, array $time)
    {
        $repair = Repair::whereAdminId($id)->where('status_id', 4)->whereBetween('repaired_at', $time);
        switch ($case) {
            case 1:
                $repair = $repair->selectRaw('TIMESTAMPDIFF (MINUTE, created_at, accepted_at) AS time');
                break;
            case 2:
                $repair = $repair->selectRaw('TIMESTAMPDIFF (MINUTE, accepted_at, repaired_at) AS time');
                break;
            case 3:
                $repair = $repair->selectRaw('TIMESTAMPDIFF (MINUTE, repaired_at, completed_at) AS time');
                break;
            default:
                $repair = $repair->selectRaw('TIMESTAMPDIFF (MINUTE, created_at, accepted_at) AS time');
                break;
        }
        return (int)$repair->value('time');
    }

    protected function countStar($id, array $time)
    {
        return round(Repair::whereAdminId($id)->where('status_id', 4)->whereBetween('repaired_at', $time)->avg('user_star'), 2);
    }

}
