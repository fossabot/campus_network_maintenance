<?php

namespace App\Http\Controllers\Admin\Type;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function data(Request $request)
    {
        return response()->json(Type::findOrFail($request->input('id')), 200);
    }
}
