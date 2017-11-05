<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Http\Controllers\Controller;
use App\Models\Repair;

class DetailController extends Controller
{
    public function data($id)
    {
        $repair = Repair::findOrFail($id);

        if ($this->role() != 9 && $repair->type_id != $this->type()) {
            return response()->json('没有此操作的权限。', 403);
        }

        return response()->json();
    }
}
