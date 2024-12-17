<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class setupPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $permission = session()->get('user_id')['setup_permission'];
        if ($permission != 'on') {

            return redirect('/403');
        }
        return $next($request);
    }
}
