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

        if ($request->getMethod() != 'GET') {
            if (in_array(@explode('/', $request->route()->action['prefix'])[2], ['location', 'part', 'type'])) {
                if ((int)session('admin.role') != 9) {
                    return response()->json('没有此操作的权限。', 500);
                }
            }
        }

        return $next($request);
    }
}
