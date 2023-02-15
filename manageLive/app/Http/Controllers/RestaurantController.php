<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use File;

use App\Models\RestaurantModel;
use App\Models\CategoryModel;
use App\Models\MenuModel;
use App\Models\TableModel;
use App\Models\CurrencyModel;
use App\Models\UserModel;
use App\Models\CountryModel;

class RestaurantController extends Controller
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
    public static function restaurant_details($id)
    {
        $restaurant_details = RestaurantModel::get_one_restaurant_details($id);

        $category_count = "0";
        $menu_count     = "0";
        $table_count    = "0";

        // Get Categories
        $categories = CategoryModel::get_restaurant_categories_by_type($id,'0');

        if($categories)
        {   
            $category_count = count($categories);
        }

        // Get Menus
        $menus = MenuModel::get_restaurant_menus($id);
        
        if($menus)
        {   
            $menu_count = count($menus);
        }

        // Get Tables
        $tables = TableModel::get_restaurant_tables($id);
        
        if($tables)
        {   
            $table_count = count($tables);
        }

        // Get Currency
        $currency_id = $restaurant_details->currency_id;

        $currency_name = CurrencyModel::get_currency_name($currency_id);

        // Get Country
        $country_id = $restaurant_details->country_id;

        $country_name = CountryModel::get_country_name($country_id);

        return view('restaurant/details',['restaurant' => $restaurant_details, 'category_count' => $category_count, 'menu_count' => $menu_count, 'table_count' => $table_count, 'currency_name' => $currency_name, 'country_name' => $country_name]);
    }

    // Update Restaurant Form
    public function update_restaurant_details($id)
    {
        // Restaurant details
        $restaurant_details = RestaurantModel::get_one_restaurant_details($id);

        // Get Currency
        $currency_array = CurrencyModel::get_all_currecy_rows();

        // Get Country Array
        $country_array = CountryModel::get_all_country_rows();

        return view('restaurant/edit',['restaurant' => $restaurant_details, 'currency_list' => $currency_array, 'country_list' => $country_array]);
    }

    // Update Restaurant Data
    public function update_restaurant(Request $request)
    {
        $restaurant_id = $request->restaurant_id;

        // Get current restaurant row
        $restaurant_details = RestaurantModel::get_one_restaurant_details($restaurant_id);

        if ($restaurant_details) 
        {
            $current_restaurant_logo = $restaurant_details->restaurant_logo;

            if ($current_restaurant_logo == "") 
            {
                $validator = Validator::make($request->all(), [
                                    'restaurant_name' => 'required',
                                    'first_name'      => 'required',
                                    'last_name'       => 'required',
                                    'contact_person'  => 'required',
                                    'email'           => 'required|email',
                                    'contact_number'  => 'required',
                                    'country_id'      => 'required',
                                    'location'        => 'required',
                                    'currency_id'     => 'required',
                                    'restaurant_logo' => 'required|mimes:jpeg,png|max:2048',
                                ]);
            }
            else
            {
                $validator = Validator::make($request->all(), [
                                    'restaurant_name' => 'required',
                                    'first_name'      => 'required',
                                    'last_name'       => 'required',
                                    'contact_person'  => 'required',
                                    'email'           => 'required|email',
                                    'contact_number'  => 'required',
                                    'country_id'      => 'required',
                                    'location'        => 'required',
                                    'currency_id'     => 'required',
                                    'restaurant_logo' => 'mimes:jpeg,png|max:2048',
                                ]);
            }

            if ($validator->passes()) 
            {
                $file = $request->file('restaurant_logo');

                if (!empty($file)) 
                {
                    $restaurant_logo_name = explode(".", $file->getClientOriginalName());
                    $restaurant_logo = $restaurant_logo_name[0].'-'.time().".".$restaurant_logo_name[1];

                    // File Path
                    $destinationPath = config('images.restaurant_url').$restaurant_id;

                    // Delete current file
                    File::delete($destinationPath.'/'.$current_restaurant_logo);

                    $file->move($destinationPath,$restaurant_logo);
                }
                else
                {
                    $restaurant_logo = $current_restaurant_logo;
                }

                $update_data = array(   
                                        'restaurant_name' => $request->restaurant_name,
                                        'restaurant_logo' => $restaurant_logo,
                                        'contact_person'  => $request->contact_person,
                                        'email'           => $request->email,
                                        'contact_number'  => $request->contact_number,
                                        'country_id'      => $request->country_id,
                                        'location'        => $request->location,
                                        'currency_id'     => $request->currency_id,
                                        'app_theme_color_1' => $request->app_theme_color_1,
                                        'app_theme_color_2' => $request->app_theme_color_2,
                                        'app_theme_color_3' => $request->app_theme_color_3,
                                        'app_theme_color_4' => $request->app_theme_color_4,
                                        'updated_at'      => date('Y-m-d H:i:s')
                                    );

                // Update restaurant row
                $update_restaurant = RestaurantModel::update_restaurant_details($restaurant_id,$update_data);

                if($update_restaurant)
                {
                    $user_update_data = array(   
                                        'first_name' => $request->first_name,
                                        'last_name'  => $request->last_name,
                                        'email'      => $request->email,
                                        'gender'     => $request->gender,
                                        'date_of_birth' => $request->date_of_birth,
                                        'updated_at' => date('Y-m-d H:i:s')
                                    );

                    // Update User row
                    $update_user = UserModel::update_user_details('restaurant_id',$restaurant_id,$user_update_data);

                    if ($update_user) 
                    {
                        return response()->json(['success'=>'Data Updated successfully']);
                    }
                    else
                    {
                        return response()->json(['errors'=>'Error while updating data']);
                    }
                }
                else
                {
                    return response()->json(['errors'=>'Error while updating data']);
                }
            }

            return response()->json(['error'=>$validator->errors()]);
        }
        else
        {
            return response()->json(['errors'=>'Incorrect restaurant details']);
        }
    }

    public function restaurant()
    {
        return view('restaurant');
    }
}
