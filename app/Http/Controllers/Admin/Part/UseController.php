<?php

namespace App\Http\Controllers\Admin\Part;

use App\Http\Controllers\Controller;
use App\Models\LogPartUse;
use Illuminate\Http\Request;

class UseController extends Controller
{
    public function data(Request $request)
    {
        $per = (int)$request->input('per');
        $page = (int)$request->input('page');

        $query = new LogPartUse();

        return response()->json([
            'total' => $query->count(),
            'data'  => $query->offset(($page - 1) * $per)->limit($per)->get()->map([$this, 'transformer']),
        ]);
    }

    public function transformer(LogPartUse $log)
    {
        return [
            'id'         => $log->id,
            'repair_id'  => $log->repair_id,
            'part'       => [
                'id'   => $log->part->id,
                'name' => $log->part->name,
            ],
            'admin'      => [
                'id'   => $log->admin->id,
                'name' => $log->admin->name,
            ],
            'number'     => $log->number,
            'created_at' => $log->created_at->format('Y-m-d H:i'),
        ];
    }
}
