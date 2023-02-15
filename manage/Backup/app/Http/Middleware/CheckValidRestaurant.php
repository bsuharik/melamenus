<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckValidRestaurant
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
            $user_restaurant_id = $user->restaurant_id;

            $passed_in_restaurant_id = $request->route('id');
            if ($user_type == "1") 
            {
                if ($user_restaurant_id != $passed_in_restaurant_id) 
                {
                    return redirect('/home');
                }
            }

            return $next($request);
        }

        return $next($request);
    }
}
