<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAppUserAccess
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
        //echo "<pre>"; print_r($request->all());echo "</pre>"; exit();
        if (isset($user)) 
        {
            $user_type = $user->user_type;

            if ($user_type == "0" || $user_type == "1") 
            {
                return redirect('/login');
            }

            return $next($request);
        }

        return $next($request);
    }
}
