<?php

namespace App\Http\Controllers\Admin\Part;

use App\Http\Controllers\Controller;
use App\Models\LogPartUse;
use App\Models\Part;
use Carbon\Carbon;

class UseController extends Controller
{
    public function data($start, $end)
    {
        $parts = Part::all();

        $time = [
            'now'              => Carbon::now(),
            'startOfToday'     => Carbon::today(),
            'startOfYesterday' => Carbon::yesterday(),
            'startOfThisMonth' => (new Carbon())->startOfMonth(),
            'customStart'      => $start ? Carbon::parse($start) : Carbon::now(),
            'customEnd'        => $end ? Carbon::parse($end)->endOfDay() : Carbon::now(),
        ];

        $data1 = [];

        foreach ($parts as $part) {
            $data1 = array_merge($data1, [
                [
                    '备件名称' => $part->name,
                    '今日'   => $this->countPart($part->id, [$time['startOfToday'], $time['now']]),
                    '昨日'   => $this->countPart($part->id, [$time['startOfYesterday'], $time['startOfToday']]),
                    '本月'   => $this->countPart($part->id, [$time['startOfThisMonth'], $time['now']]),
                    '总共'   => $this->countPart($part->id, [0, $time['now']]),
                    '自定义'  => $this->countPart($part->id, [$time['customStart'], $time['customEnd']]),
                ]
            ]);
        }

        return response()->json(['data1' => $data1]);
    }

    protected function countPart($id, array $time)
    {
        return LogPartUse::wherePartId($id)->whereBetween('created_at', $time)->count();
    }
}
