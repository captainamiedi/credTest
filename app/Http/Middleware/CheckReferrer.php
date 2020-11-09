<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckReferrer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('ref')) {
            session(['referrer' => $request->query('ref')]);
            return redirect('/login');
//            return $next($request);
        }
        return $next($request);
    }
}
