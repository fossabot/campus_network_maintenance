<?php

namespace App\Http\Controllers\User\Repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    public function show()
    {
        return view('user.repair.detail');
    }
}
