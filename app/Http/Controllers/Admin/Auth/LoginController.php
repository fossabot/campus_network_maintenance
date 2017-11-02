<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function login(LoginRequest $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $seconds = $this->limiter()->availableIn($this->throttleKey($request));
            return response()->json(Lang::get('auth.throttle', ['seconds' => $seconds]), 423);
        }

        if ($this->attemptLogin($request)) {
            return response()->json([], 200);
        }

        $this->incrementLoginAttempts($request);

        return response()->json(trans('auth.failed'), 422);
    }

    /**
     * @return RateLimiter
     */
    protected function limiter()
    {
        return app(RateLimiter::class);
    }

    /**
     * @param LoginRequest $request
     *
     * @return mixed|string
     */
    protected function throttleKey(LoginRequest $request)
    {
        return mb_strtolower($request->input('username') . '|' . $request->ip(), 'UTF-8');
    }

    /**
     * 是否登录次数过多
     *
     * @param LoginRequest $request
     *
     * @return bool
     */
    protected function hasTooManyLoginAttempts(LoginRequest $request)
    {
        return $this->limiter()->tooManyAttempts($this->throttleKey($request), 5, 5);
    }

    /**
     * @param LoginRequest $request
     */
    protected function fireLockoutEvent(LoginRequest $request)
    {
        event(new Lockout($request));
    }

    protected function incrementLoginAttempts(LoginRequest $request)
    {
        $this->limiter()->hit($this->throttleKey($request), 5);
    }

    protected function attemptLogin(LoginRequest $request)
    {
        $this->admin;
    }
}
