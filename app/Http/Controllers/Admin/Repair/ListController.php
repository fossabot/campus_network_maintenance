<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $per = $request->input('per');
        $page = $request->input('page');

        $status_id = $request->input('status_id');
        $type_id = $request->input('type_id');
        $user_id = $request->input('user_id');
        $user_mobile = $request->input('user_mobile');

        $query = new Repair();

        if (!is_null($status_id)) {
            $query = $query->where('status_id', $status_id);
        } else {
            if (!$status_id && !$type_id && !$user_id && !$user_mobile) {
                $query = $query->whereIn('status_id', [1, 2, 3, 4]);
            }
        }

        if ($user_id) {
            $query = $query->where('user_id', 'like', '%' . $user_id . '%');
        }

        if ($user_mobile) {
            $query = $query->where('user_mobile', 'like', '%' . $user_mobile . '%');
        }

        if ($this->role() != 9) {
            $query = $query->whereTypeId($this->type())->orderBy('status_id');
        } else {
            if ($type_id) {
                $query = $query->whereTypeId($type_id);
            }
        }

        return response()->json([
            'total' => $query->count(),
            'data'  => $query->offset(($page - 1) * $per)->limit($per)->get()->map([$this, 'transformer']),
        ]);
    }

    /**
     * @param Repair $repair
     *
     * @return array
     */
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
            'admin'            => @$repair->admin->name,
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
