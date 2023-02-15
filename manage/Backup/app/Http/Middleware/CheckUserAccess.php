<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserAccess
{    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = Auth::user();

        if (isset($user)) 
        {
            $user_type = $user->user_type;

            if ($user_type == "1" || $user_type == "2") 
            {
                return redirect('/home');
            }

            return $next($request);
        }

        return $next($request);
    }
}
