<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Redirect;
use Session;
class SocialLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {

    }
    protected $providers = [
        'facebook','google'
    ];
    public function redirectToProvider($driver)
    {
       
        if( ! $this->isProviderAllowed($driver) ) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
           return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }
    }
    public function handleProviderCallback( $driver )
    {
        
        
        try {
            $user = Socialite::driver($driver)->stateless()->user();
        }catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }
        if($driver =='facebook'){
            return $this->loginOrCreateAccount($user, $driver);
        }else{
            // check for email in returned user
            return empty( $user->email )
            ? $this->sendFailedResponse("No email id returned from {$driver} provider.")
            : $this->loginOrCreateAccount($user, $driver); 
        }
        
    }

    protected function sendSuccessResponse()
    {
        $restaurant_id = session()->get('restaurant_id');
        $url=url("/user_home/{$restaurant_id}");
        return Redirect::to($url);
       // return redirect('/user_home/'.$restaurant_id);
    }

    protected function sendFailedResponse($msg = null)
    {
        // return redirect()->route('social.login')
          $restaurant_id = session()->get('restaurant_id');
          if(empty($msg)){
              $msg='Unable to login, try with another provider to login.';
          }
          //session()->put('social_login_error',$msg);
          Session::flash('social_login_error', $msg); 
          return Redirect::to('/user_login/'.$restaurant_id);
    }

    protected function loginOrCreateAccount($providerUser, $driver)
    {
        // check for already has account
        if($driver =='facebook'){
            $user = User::where('provider_id', $providerUser->getId())->where('provider',$driver)->first();
        }else{
            $user = User::where('email', $providerUser->getEmail())->where('provider',$driver)->first();
        }
        
    //echo "<pre>here";print_r($providerUser);echo "</pre>";exit();
        // if user already found
        if( $user ) {
            // update the avatar and provider that might have changed
            $getUsername=explode(' ', $providerUser->getName(), 2);
            $user->first_name = $getUsername[0];
            $user->last_name = $getUsername[1];
            $user->provider_id = $providerUser->getId();
            $user->access_token = $providerUser->token;
            $user->save();
        } else {
            // create a new user
           $getUsername=explode(' ', $providerUser->getName(), 2);
             $user = new User();
             $user->first_name = $getUsername[0];
             $user->last_name = $getUsername[1];
             $user->email = $providerUser->getEmail();
             $user->provider = $driver;
             $user->provider_id = $providerUser->getId();
             $user->access_token = $providerUser->token;
             $user->user_type = '2';
                // user can use reset password to create a password
             $user->password = '';
             $user->save();
            
            
        }
        // login the user
        Auth::login($user, true);

        return $this->sendSuccessResponse();
    }
    private function isProviderAllowed($driver){
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }
    
    
}