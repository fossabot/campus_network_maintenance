<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function data(Request $request)
    {
        $per = $request->input('per');
        $page = $request->input('page');

        if ($this->role() != 9) {
            $data = Repair::whereTypeId($this->type())->offset(($page - 1) * $per)->limit($per)->get();
        } else {
            $data = Repair::offset(($page - 1) * $per)->limit($per)->get();
        }

        return response()->json($data->map([$this, 'transformer']), 200);
    }

    public function transformer(Repair $repair)
    {
        return [
            'id'               => $repair->id,
            'status_id'        => $repair->status_id,
            'status'           => $repair->status,
            'type_id'          => $repair->type_id,
            'type'             => (new \App\Http\Controllers\Admin\Type\ListController())->transformer($repair->type),
            'location_id'      => $repair->location_id,
            'location'         => [
                'first'  => $repair->location->first,
                'second' => $repair->location->second,
            ],
            'user_room'        => $repair->user_room,
            'admin'            => $repair->admin->name,
            'user_id'          => $repair->user_id,
            'user_name'        => $repair->user_name,
            'user_mobile'      => $repair->user_mobile,
            'user_description' => $repair->user_description,
            'user_star'        => $repair->user_star . '星',
            'user_evaluation'  => $repair->user_evaluation,
            'created_at'       => $repair->created_at ? $repair->created_at->toDateTimeString() : null,
            'accepted_at'      => $repair->accepted_at ? $repair->accepted_at->toDateTimeString() : null,
            'repaired_at'      => $repair->repaired_at ? $repair->repaired_at->toDateTimeString() : null,
            'completed_at'     => $repair->completed_at ? $repair->completed_at->toDateTimeString() : null,
            'updated_at'       => $repair->updated_at ? $repair->updated_at->toDateTimeString() : null,
        ];
    }
}
