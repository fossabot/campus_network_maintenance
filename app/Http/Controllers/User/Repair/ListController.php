<?php

namespace App\Http\Controllers\User\Repair;

use App\Http\Controllers\Controller;
use App\Models\Repair;

class ListController extends Controller
{
    public function show()
    {
        $repairs = Repair::whereUserId(session('user.id'))->where('status_id', '>', 0)->orderByDesc('id')->paginate();

        return view('user.repair.list', ['repairs' => $repairs]);
    }
}
