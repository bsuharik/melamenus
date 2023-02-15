<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Redirect;
use Auth;
use Mail;

use App\Models\RestaurantModel;
use App\Models\TableModel;
use App\Models\CategoryModel;
use App\Models\MenuModel;
use App\Models\CurrencyModel;
use App\Models\CountryModel;
use App\Models\UserModel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    // Admin Dashboard
    public function index()
    {
        $user_type = Auth::user()->user_type;

        if ($user_type == "0") 
        {
            $restaurants = RestaurantModel::get_pending_restaurants();
            $approved_restaurants = RestaurantModel::get_approved_restaurants();
            $tables = TableModel::get_all_tables();

            return view('home',['restaurant_count' => count($approved_restaurants),'restaurants'=>$restaurants,'tables'=>$tables]);
        }
        else if ($user_type == "1") 
        {
            $id = Auth::user()->restaurant_id;

            $restaurant_details = RestaurantModel::get_active_restaurant_details($id);

            if (!empty($restaurant_details))
            {
                return RestaurantController::restaurant_details($id);
            }
            else
            {
                Auth::logout(); // log the user out of our application
                return redirect('login')->with('error', 'Please wait till your request is accepted by administrator!');
                // return Redirect::to('login'); // redirect the user to the login screen
            }
        }
        else
        {
            $id = Auth::user()->restaurant_id;
            return UserController::index($id);
        }
    }

    // List of restaurants
    public function restaurant()
    {
        $restaurants = RestaurantModel::get_approved_restaurants();
        return view('restaurant',['restaurants'=>$restaurants]);
    }

    // Approve restaurant Request
    public function approve_restaurant_request($id)
    {
        $restaurant_details = RestaurantModel::get_one_restaurant_details($id);

        if($restaurant_details)
        {   
            $update_data = array('is_approved' => '1');

        	$update_restaurant = RestaurantModel::update_restaurant_details($id,$update_data);

			if($update_restaurant)
			{
                $to_name  = $restaurant_details->restaurant_name;
                $to_email = $restaurant_details->email;

                $data = array(
                                'restaurant_name' => $restaurant_details->restaurant_name,
                                'email'           => $restaurant_details->email
                            );

                // Send email to restaurant owner
                Mail::send('email.approve_restaurant', ["data"=>$data] , function($message) use ($to_name, $to_email){
                    $message->to($to_email, $to_name)->subject('Mela Menus - Restaurant Request Approved');
                    $message->from('info@melamenus.com','Mela Menus');
                });

				return back()->with('success','Restaurant Request is approved successfully!');
			}
			else
			{
				return back()->with('error','Error While approving restaurant request');
			}
        }
        else
        {
            $restaurants = RestaurantModel::get_pending_restaurants();
        	return view('restaurant',['restaurants'=>$restaurants]);
        }
    }

    // Reject restaurant Request
    public function reject_restaurant_request($id)
    {
        $restaurant_details = RestaurantModel::get_one_restaurant_details($id);
        
        if($restaurant_details)
        {
            $update_data = array('is_approved' => '2');

            $update_restaurant = RestaurantModel::update_restaurant_details($id,$update_data);

            if($update_restaurant)
            { 
                $to_name  = $restaurant_details->restaurant_name;
                $to_email = $restaurant_details->email;

                $data = array(
                                'restaurant_name' => $restaurant_details->restaurant_name,
                                'email'           => $restaurant_details->email
                            );

                // Send email to restaurant owner
                Mail::send('email.reject_restaurant', ["data"=>$data] , function($message) use ($to_name, $to_email){
                    $message->to($to_email, $to_name)->subject('Mela Menus - Restaurant Request Rejected');
                    $message->from('info@melamenus.com','Mela Menus');
                });

                return back()->with('success','Restaurant Request is rejected successfully!');
            }
            else
            {
                return back()->with('error','Error While rejecting restaurant request');
            }
        }
        else
        {
            $restaurants = RestaurantModel::get_pending_restaurants();
            return view('restaurant',['restaurants'=>$restaurants]);
        }
    }

    // APP users list
    public function get_app_users()
    {
        $users = UserModel::get_all_users();
        return view('user/index',['users_list' => $users]);
    }
}
