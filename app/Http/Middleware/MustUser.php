<?php

namespace App\Http\Middleware;

use Closure;

class MustUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ((int)session('user.id') <= 0) {
            return redirect('/user');
        }

        return $next($request);
    }
}
