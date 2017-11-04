<?php

namespace App\Http\Controllers\Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\Location;

class DetailController extends Controller
{
    public function data($id)
    {
        return response()->json(Location::findOrFail($id), 200);
    }
}
