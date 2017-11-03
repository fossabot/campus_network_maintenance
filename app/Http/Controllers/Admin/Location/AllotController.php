<?php

namespace App\Http\Controllers\Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\TypeLocationRelation;
use Illuminate\Http\Request;

class AllotController extends Controller
{
    public function data()
    {

    }

    public function allot(Request $request)
    {
        $type = Type::findOrFail($request->input('id'));

        foreach ($request->input('locations') as $id) {
            echo $id;
        }

        TypeLocationRelation::insert([

        ]);
    }
}
