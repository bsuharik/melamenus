<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;    
use App\Http\Requests;
use Auth;
use Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers; 

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected function authenticated(Request $request)
    {
        $user_type = Auth::user()->user_type;
        

        if ($user_type == "2") 
        {
            $id = $request->restaurant_id;

            if ($id != "") 
            {
                return Redirect::to('user_home/'.$id);
            }
            else
            {
                return Redirect::to('login');
            }
        }
        else
        {
            if (isset($restaurant_id))
            {
                Auth::logout();
                return Redirect::to('user_login/'.$restaurant_id)->with('error', 'Incorrect user details');
            }
            else
            {
                return Redirect::to('home');
            }
        }
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Do logout
    public function logout(Request $request)
    {
        $user_type = Auth::user()->user_type;
        
        if ($user_type == "2") 
        {
            Auth::logout(); // log the user out of our application
            $restaurant_id = $request->restaurant_id;
            return Redirect::to('user_home/'.$restaurant_id); // redirect the user to the login screen
        }
        else
        {
            Auth::logout(); // log the user out of our application
            return Redirect::to('login'); // redirect the user to the login screen
        }
    }

}
