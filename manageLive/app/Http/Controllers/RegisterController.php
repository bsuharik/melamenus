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
        $currency_array = CurrencyModel::get_all_currecy_rows();

        // Get Country Array
        $country_array = CountryModel::get_all_country_rows();

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
            // Create Restaurant
            $create_restaurant = array(
                                    'restaurant_name' => $request->restaurant_name,
                                    'contact_person'  => $request->contact_person,
                                    'email'           => $request->email,
                                    'contact_number'  => $request->contact_number,
                                    'location'        => $request->location,
                                    'country_id'      => $request->country_id,
                                    'currency_id'     => $request->currency,
                                    'is_approved'     => '0',
                                    'created_at'      => date('Y-m-d H:i:s')
                                );

            // Add Restaurant
            $row_added = RestaurantModel::create_restaurant_details($create_restaurant);

            if($row_added)
            {
                $restaurant_id = $row_added;

                // Create User
                $create_user = array(
                                        'first_name'      => $request->first_name,
                                        'last_name'       => $request->last_name,
                                        'email'           => $request->email,
                                        'gender'          => $request->gender,
                                        'date_of_birth'   => $request->date_of_birth,
                                        'password'        => Hash::make($request->password),
                                        'user_type'       => '1',
                                        'restaurant_id'   => $restaurant_id,
                                        'created_at'      => date('Y-m-d H:i:s')
                                    );

                // Add user
                $user_row_added = UserModel::create_user_details($create_user);

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
                        $message->from('info@melamenus.com','Mela Menus');
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
