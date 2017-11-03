<?php

namespace App\Http\Controllers\Admin\Type;

use App\Http\Controllers\Controller;
use App\Models\Type;

class DetailController extends Controller
{
    public function data($id)
    {
        dump($id);
        die;
        return response()->json(Type::findOrFail($id), 200);
    }
}
