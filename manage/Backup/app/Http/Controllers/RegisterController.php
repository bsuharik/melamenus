<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use Validator;
use Hash;
use Mail;
use App\Models\UserModel;
use App\Models\CurrencyModel;
use App\Models\RestaurantModel;
use App\Models\CountryModel;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    // Show Register Form
    public function showRegister()
    {
        // Get Currency Array
        $currency_array = CurrencyModel::all();

        // Get Country Array
         $country_array =array();
         $country_array = CountryModel::all();

        return view('signup',['currency_list' => $currency_array, 'country_list' => $country_array]);
    }

    // Add User
    public function doRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'      => 'required',
            'last_name'       => 'required',
            'email'           => 'required|email|unique:users,email',
            'restaurant_name' => 'required',
            'contact_person'  => 'required',
            'contact_number'  => 'required|numeric',
            'location'        => 'required',
            'country_id'      => 'required',
            'currency'        => 'required',
            'password'        => [
                'required',
                'min:6',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
            'password_confirmation' => 'required|min:6',
        ]);

        if ($validator->passes()) 
        {
            // Add Restaurant
            $add_rest= new RestaurantModel();
                $add_rest->restaurant_name = $request->restaurant_name;
                $add_rest->contact_person  = $request->contact_person;
                $add_rest->email           = $request->email;
                $add_rest->contact_number  = $request->contact_number;
                $add_rest->location        = $request->location;
                $add_rest->country_id      = $request->country_id;
                $add_rest->currency_id     = $request->currency;
                $add_rest->is_approved     = '0';
                $add_rest->created_at      = date('Y-m-d H:i:s');
                $row_added = $add_rest->save();

            if(!empty($row_added))
            {
                $restaurant_id = $add_rest->restaurant_id;
                // Add user
                $user_add = new UserModel();
                $user_add->first_name    = $request->first_name;
                $user_add->last_name     = $request->last_name;
                $user_add->email         = $request->email;
                $user_add->gender        = $request->gender;
                $user_add->date_of_birth = $request->date_of_birth;
                $user_add->password      = Hash::make($request->password);
                $user_add->user_type     = '1';
                $user_add->restaurant_id = $restaurant_id;
                $user_add->created_at    = date('Y-m-d H:i:s');
                $user_row_added= $user_add->save();
                if ($user_row_added) 
                {
                    // // Send mail to user
                    $to_name  = $request->first_name." ".$request->last_name;
                    $to_email = $request->email;

                    $data = array(
                                    'restaurant_name' => $request->restaurant_name,
                                    'email'           => $request->email,
                                    'first_name'      => $request->first_name,
                                    'last_name'       => $request->last_name,
                                );

                    // Send email to restaurant owner
                    Mail::send('email.user_registartion', ["data"=>$data] , function($message) use ($to_name, $to_email){
                        $message->to($to_email, $to_name)->subject('Mela Menus - Restaurant Created');
                        $message->from('testcrestemail@gmail.com','Mela Menus');
                    });

                    return response()->json(['success'=> 'Your Restaurant - '.$request->restaurant_name.' is registered successfully. Wait for admin to approve your restaurant request']);
                }
                else
                {
                    return response()->json(['errors'=>'Error while adding data']);
                }
            }
            else
            {
                return response()->json(['errors'=>'Error while adding data']);
            }
        }
        
        return response()->json(['error'=>$validator->errors()]);
    }
}
