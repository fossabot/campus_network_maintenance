<?php

namespace App\Http\Middleware;

use Closure;

class MustAdmin
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
        if ((int)session('admin.id') <= 0) {
            return redirect('/admin');
        }

        return $next($request);
    }
}
