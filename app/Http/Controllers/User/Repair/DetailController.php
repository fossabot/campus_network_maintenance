<?php

namespace App\Http\Controllers\User\Repair;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use App\Models\Type;
use App\Models\TypeLocationRelation;

class DetailController extends Controller
{
    public function show($id)
    {
        $detail = Repair::findOrFail($id);

        if ($detail->user_id != session('user.id')) {
            abort(404);
        }

        $types = [];
        foreach (Type::whereAllowUserCreate(1)->get() as $type) {
            $locations = [];
            foreach (TypeLocationRelation::whereTypeId($type->id)->get() as $location) {
                $locations = array_merge($locations, [[
                    'id'   => $location->location->id,
                    'name' => $location->location->first . ' ' . $location->location->second,
                ]]);
            }
            $types = array_merge($types, [[
                'id'        => $type->id,
                'name'      => $type->name,
                'locations' => $locations,
            ]]);
        }

        return view('user.repair.detail', [
            'detail' => $detail,
            'types'  => $types,
        ]);
    }
}
