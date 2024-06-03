<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if(Auth::check()){  //check is you are authenticated
            if(Auth::user()->role_as == '1') {  // checks if the role on our database is equel to one and redirecte to admin dashboard
                return $next($request);
            } else {
                return redirect('/')->with('error', 'Access denied');
            }
        } else {
            return redirect('/')->with('error', 'Please login first'); // if not authenticated redirect to homepage
        }
    }
}
