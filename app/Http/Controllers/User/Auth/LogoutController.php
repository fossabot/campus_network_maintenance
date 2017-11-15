<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function logout()
    {
        session()->flush();

        return redirect()->intended('/');
    }
}
