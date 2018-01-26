<?php

namespace App\Http\Controllers\Admin\Part;

use App\Http\Controllers\Controller;
use App\Models\LogPartAdd;
use App\Models\Part;
use Illuminate\Http\Request;

class NumberController extends Controller
{
    public function add(Request $request)
    {
        $part = Part::findOrFail($request->input('id'));

        $number = (int)$request->input('number');

        if ($number <= 0) {
            return response()->json('增加的数量 不符合规则。', 422);
        }

        $part->left_number = $number;

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
}
