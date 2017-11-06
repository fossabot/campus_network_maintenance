<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function show()
    {
        return view('user.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'user_id'   => 'required|numeric|digits_between:6,20',
            'user_pass' => 'required|min:4|max:32',
        ]);

        dump($request->input());
    }
}
