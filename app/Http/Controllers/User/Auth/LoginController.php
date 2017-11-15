<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use App\School\Api\WebAuthenticate;
use App\School\Api\WebGetUserInfo;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function show()
    {
        return view('user.auth.login');
    }

    public function login(LoginRequest $request)
    {
        // 是否登录失败次数过多
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $seconds = $this->limiter()->availableIn($this->throttleKey($request));

            throw ValidationException::withMessages([
                'throttle' => [trans('auth.throttle', ['seconds' => $seconds])],
            ])->status(423);
        }

        // 尝试登录
        if ($this->attemptLogin($request)) {
            $name = '王晟';
            //$name = $this->getUserInfo($request);

            session()->regenerate(true);

            session()->put('user.id', $request->input('user_id'));
            session()->put('user.name', $name);

            return redirect()->intended('/user/repair/list');
        }

        // 登录失败次数加一
        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages(['fail' => [trans('auth.failed')]]);
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
        return mb_strtolower($request->input('user_id') . '|' . $request->ip(), 'UTF-8');
    }

    /**
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

    /**
     * @param LoginRequest $request
     */
    protected function incrementLoginAttempts(LoginRequest $request)
    {
        $this->limiter()->hit($this->throttleKey($request), 5);
    }

    /**
     * @param LoginRequest $request
     *
     * @return bool
     */
    protected function attemptLogin(LoginRequest $request)
    {
        $authenticate = new WebAuthenticate([
            'username' => $request->input('user_id'),
            'password' => $request->input('user_pass'),
        ]);

        $result = $authenticate->execute();

        if ($result['code'] == 200 && $result['content']['result'] == 1) {
            return true;
        }

        return false;
    }

    /**
     * @param LoginRequest $request
     *
     * @return bool|string
     */
    protected function getUserInfo(LoginRequest $request)
    {
        $info = new WebGetUserInfo(['username' => $request->input('user_id')]);

        $result = $info->execute();

        if ($result['code'] == 200 && $result['content']['result'] == 1) {
            return $result['content']['name'];
        }

        return false;
    }
}
