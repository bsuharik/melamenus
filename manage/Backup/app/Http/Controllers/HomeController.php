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
    public function index(){
        $user_type = Auth::user()->user_type;

        if ($user_type == "0")  
        {
            $restaurants =array();
            $restaurants=RestaurantModel::where('is_approved',"0")->get();
            $approved_restaurants=0;
            $approved_restaurant = RestaurantModel::where('is_approved',"1")->count();
            if($approved_restaurant > 0){
                $approved_restaurants =$approved_restaurant;
            }
            $tables=array();
           $tables = TableModel::all();


            return view('home',['restaurant_count' => $approved_restaurants,'restaurants'=>$restaurants,'tables'=>$tables]);
        }
        else if ($user_type == "1") 
        {
            $id = Auth::user()->restaurant_id;
            $restaurant_details = RestaurantModel::where('restaurant_id',$id)->where('is_approved',"1")->first();
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
        $restaurants=array();
        $restaurants = RestaurantModel::where('is_approved','1')->get();
        return view('restaurant',['restaurants'=>$restaurants]);
    }
    // Approve restaurant Request
    public function approve_restaurant_request($id)
    {
        $restaurant_details = RestaurantModel::where('restaurant_id',$id)->first();
        if(!empty($restaurant_details))
        {   
            $restaurant_details->is_approved='1';
            $update_restaurant=$restaurant_details->save();

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
                    $message->from('testcrestemail@gmail.com','Mela Menus');
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
            $restaurants =array();
            $restaurants=RestaurantModel::where('is_approved',"0")->get();
        	return view('restaurant',['restaurants'=>$restaurants]);
        }
    }

    // Reject restaurant Request
    public function reject_restaurant_request($id)
    {
        $restaurant_details = RestaurantModel::where('restaurant_id',$id)->first();
        if(!empty($restaurant_details))
        {
            $restaurant_details->is_approved='2';
            $update_restaurant=$restaurant_details->save();

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
                    $message->from('testcrestemail@gmail.com','Mela Menus');
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
            $restaurants =array();
            $restaurants=RestaurantModel::where('is_approved',"0")->get();
            return view('restaurant',['restaurants'=>$restaurants]);
        }
    }

    // APP users list
    public function get_app_users()
    {
        $users=array();
        $users = UserModel::all();
        return view('user/index',['users_list' => $users]);
    }
}
