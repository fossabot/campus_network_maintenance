<?php

namespace App\Http\Controllers\Admin\Part;

use App\Http\Controllers\Controller;
use App\Models\Part;

class DetailController extends Controller
{
    public function data($id)
    {
        return response()->json(Part::findOrFail($id));
    }
}
