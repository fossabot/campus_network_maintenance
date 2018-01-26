<?php

namespace App\Http\Controllers\Admin\Part;

use App\Http\Controllers\Controller;
use App\Models\LogPartAdd;
use App\Models\Part;
use Illuminate\Http\Request;

class NumberController extends Controller
{
    public function data(Request $request)
    {
        $per = (int)$request->input('per');
        $page = (int)$request->input('page');

        $query = new LogPartAdd();

        return response()->json([
            'total' => $query->count(),
            'data'  => $query->offset(($page - 1) * $per)->limit($per)->get()->map([$this, 'transformer']),
        ]);
    }

    public function add(Request $request)
    {
        $part = Part::findOrFail($request->input('id'));

        $number = (int)$request->input('number');

        if ($number <= 0) {
            return response()->json('增加的数量 不符合规则。', 422);
        }

        $part->left_number += $number;

        if ($part->save()) {
            $log = new LogPartAdd();
            $log->part_id = $part->id;
            $log->admin_id = $this->id();
            $log->number = $number;
            $log->save();

            return response()->json();
        }

        return response()->json('服务器错误。', 500);
    }

    public function transformer(LogPartAdd $log)
    {
        return [
            'id'         => $log->id,
            'part'       => [
                'id'   => $log->part->id,
                'name' => $log->part->name,
            ],
            'admin'      => [
                'id'   => $log->admin->id,
                'name' => $log->admin->name,
            ],
            'number'     => $log->number,
            'created_at' => $log->created_at->toDateTimeString(),
        ];
    }
}
