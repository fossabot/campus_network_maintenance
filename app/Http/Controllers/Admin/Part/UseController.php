<?php

namespace App\Http\Controllers\Admin\Part;

use App\Http\Controllers\Controller;
use App\Models\LogPartUse;

class UseController extends Controller
{
    public function data()
    {
        return response()->json(LogPartUse::all()->map([$this, 'transformer']));
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
            'created_at' => $log->created_at->toDateTimeString(),
        ];
    }
}
