<?php

namespace App\Http\Controllers\Admin\Type;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function data(Request $request)
    {
        $type = Type::findOrFail($request->input('id'));

        if ($type) {
            return response()->json($type, 200);
        }

        return response()->json('', 404);
    }
}
