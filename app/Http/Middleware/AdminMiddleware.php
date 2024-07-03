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
        if(Auth::check()){  //check if you are authenticated as admin or user
            if(Auth::user()->role_as == '1') {  // checks if the role on our database is equel to one( role = 1 in our database) redirect user to admin dashboard
                return $next($request);
            } else {
                return redirect('/')->with('error', 'Access denied');
            }
        } else {
            return redirect('/')->with('error', 'Please login first'); // if not role on our database is equel to one(role =! 1 in our database) redirect user to homepage
        }
    }
}
