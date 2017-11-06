<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use App\Models\RepairDescription;
use Illuminate\Database\Eloquent\Model;

class DetailController extends Controller
{
    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data($id)
    {
        $repair = Repair::findOrFail($id);

        if ($this->role() != 9 && $repair->type_id != $this->type()) {
            return response()->json('没有此操作的权限。', 403);
        }

        return response()->json($this->transformer($repair), 200);
    }

    /**
     * @param Model $repair
     *
     * @return array
     */
    public function transformer(Model $repair)
    {
        /**
         * @var Repair $repair
         */
        return [
            'id'                => $repair->id,
            'status_id'         => $repair->status_id,
            'status'            => $repair->status,
            'type_id'           => $repair->type_id,
            'type'              => $repair->type->name,
            'location_id'       => $repair->location_id,
            'location'          => [
                'first'  => $repair->location->first,
                'second' => $repair->location->second,
            ],
            'user_id'           => $repair->user_id,
            'user_name'         => $repair->user_name,
            'user_mobile'       => $repair->user_mobile,
            'user_room'         => $repair->user_room,
            'user_description'  => $repair->user_description,
            'admin_description' => $repair->description->map([$this, 'transformerDescription']),
            'user_star'         => $repair->user_star,
            'user_evaluation'   => $repair->user_evaluation,
            'created_at'        => $repair->created_at ? $repair->created_at->toDateTimeString() : null,
            'accepted_at'       => $repair->accepted_at ? $repair->accepted_at->toDateTimeString() : null,
            'repaired_at'       => $repair->repaired_at ? $repair->repaired_at->toDateTimeString() : null,
            'completed_at'      => $repair->completed_at ? $repair->completed_at->toDateTimeString() : null,
            'updated_at'        => $repair->updated_at ? $repair->updated_at->toDateTimeString() : null,
        ];
    }

    public function transformerDescription(RepairDescription $description)
    {
        return [
            'admin'       => $description->admin->name,
            'description' => $description->description,
            'created_at'  => $description->created_at ? $description->created_at->toDateTimeString() : null,
        ];
    }
}
