<?php

namespace App\Http\Controllers\Admin\Part;

use App\Http\Controllers\Controller;
use App\Models\Part;

class ListController extends Controller
{
    public function data()
    {
        return response()->json(Part::all());
    }
}
