<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;

class IndexController extends Controller
{
    /**
     * 渲染页面
     */
    public function show()
    {
        $admin = Admin::find(session('admin.id'));

        if ($admin) {
            session()->put([
                'admin.id'   => $admin->id,
                'admin.role' => $admin->role_id,
                'admin.type' => $admin->type_id,
            ]);
        }

        return view('admin.index', ['admin' => $admin]);
    }
}
