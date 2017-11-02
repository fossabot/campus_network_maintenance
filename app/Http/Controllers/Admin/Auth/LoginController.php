<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        //dump($request->all());
        //return response()->json([], 422);
    }
}
