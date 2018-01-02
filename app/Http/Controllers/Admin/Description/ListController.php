<?php

namespace App\Http\Controllers\Admin\Description;

use App\Http\Controllers\Controller;
use App\Models\RepairUserDescription;
use Illuminate\Database\Eloquent\Model;

class ListController extends Controller
{
    public function data($type)
    {
        if ($type) {
            $description = RepairUserDescription::whereTypeId($type)->get();
        } else {
            $description = RepairUserDescription::all();
        }

        return response()->json($description->map([$this, 'transformer'])->toArray());
    }

    public function transformer(Model $description)
    {
        /**
         * @var RepairUserDescription $description
         */
        return [
            'id'          => $description->id,
            'type'        => (new \App\Http\Controllers\Admin\Type\ListController())->transformer($description->type),
            'description' => $description->description,
        ];
    }
}
