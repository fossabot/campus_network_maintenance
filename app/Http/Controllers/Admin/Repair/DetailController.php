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

        return response()->json($this->transformer($repair));
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
            'created_at'        => $repair->created_at ? $repair->created_at->format('Y-m-d H:i') : null,
            'accepted_at'       => $repair->accepted_at ? $repair->accepted_at->format('Y-m-d H:i') : null,
            'repaired_at'       => $repair->repaired_at ? $repair->repaired_at->format('Y-m-d H:i') : null,
            'completed_at'      => $repair->completed_at ? $repair->completed_at->format('Y-m-d H:i') : null,
            'updated_at'        => $repair->updated_at ? $repair->updated_at->format('Y-m-d H:i') : null,
        ];
    }

    /**
     * @param RepairDescription $description
     *
     * @return array
     */
    public function transformerDescription(RepairDescription $description)
    {
        return [
            'admin'       => $description->admin->name,
            'description' => $description->description,
            'created_at'  => $description->created_at ? $description->created_at->format('Y-m-d H:i') : null,
        ];
    }
}
