<?php

namespace App\Http\Controllers\Admin\Type;

use App\Http\Controllers\Controller;
use App\Models\Type;

class ListController extends Controller
{
    public function data()
    {
        return response()->json(Type::all(), 200);
    }
}
