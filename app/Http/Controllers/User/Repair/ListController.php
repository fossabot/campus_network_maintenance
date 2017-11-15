<?php

namespace App\Http\Controllers\User\Repair;

use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function show()
    {
        return view('user.repair.list');
    }
}
