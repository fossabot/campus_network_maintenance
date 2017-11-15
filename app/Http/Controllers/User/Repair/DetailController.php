<?php

namespace App\Http\Controllers\User\Repair;

use App\Http\Controllers\Controller;
use App\Models\Repair;

class DetailController extends Controller
{
    public function show($id)
    {
        $detail = Repair::findOrFail($id);

        if ($detail->user_id != session('user.id')) {
            abort(404);
        }

        return view('user.repair.detail');
    }
}
