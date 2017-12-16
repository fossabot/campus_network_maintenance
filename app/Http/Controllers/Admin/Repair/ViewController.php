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
            'startOfLastMonth' => (new Carbon())->startOfMonth()->subSecond()->startOfMonth(),
            'customStart'      => $start ? Carbon::parse($start) : Carbon::now(),
            'customEnd'        => $end ? Carbon::parse($end)->endOfDay() : Carbon::now(),
        ];

        $data1 = $data2 = $data3 = [];

        foreach ($admins->get() as $admin) {
            $today = $this->countRepair($admin->id, [$time['startOfToday'], $time['now']]);
            $yesterday = $this->countRepair($admin->id, [$time['startOfYesterday'], $time['startOfToday']]);
            $month = $this->countRepair($admin->id, [$time['startOfThisMonth'], $time['now']]);
            $lastMonth = $this->countRepair($admin->id, [$time['startOfLastMonth'], $time['startOfThisMonth']]);
            $custom = $this->countRepair($admin->id, [$time['customStart'], $time['customEnd']]);

            $data1 = array_merge($data1, [['维修人员' => $admin->name, '今日'   => $today, '昨日'   => $yesterday, '本月'   => $month, '上个月'  => $lastMonth, '自定义'  => $custom]]);
            $data2 = array_merge($data2, [['维修人员' => $admin->name, '数量' => $today]]);
            $data3 = array_merge($data3, [['维修人员' => $admin->name, '数量' => $month]]);
        }

        return response()->json([
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
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
}
