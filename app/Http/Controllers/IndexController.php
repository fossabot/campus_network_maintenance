<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        if ($this->id()) {
            if ($this->role()) {
                return redirect('/admin/');
            } else {
                return redirect('/user/repair/list');
            }
        } else {
            return redirect('/user/auth/login');
        }
    }
}
