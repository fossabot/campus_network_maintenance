<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * 退出登录
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        session()->flush();

        return response()->json();
    }
}
