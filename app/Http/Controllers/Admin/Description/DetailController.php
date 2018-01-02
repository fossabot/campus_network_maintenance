<?php

namespace App\Http\Controllers\Admin\Description;

use App\Http\Controllers\Controller;
use App\Models\RepairUserDescription;

class DetailController extends Controller
{
    public function data($id)
    {
        return response()->json(RepairUserDescription::findOrFail($id));
    }
}
