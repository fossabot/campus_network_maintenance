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

        return view('admin.index', ['admin' => $admin]);
    }
}
