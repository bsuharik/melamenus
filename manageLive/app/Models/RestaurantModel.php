<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RestaurantModel extends Model
{
    public function __construct()
    {
    }

    // Get active restaturant Row
    public static function get_active_restaurant_details($id)
    {
        $restaurants = DB::select('select * from restaurants AS res left join users AS usr ON res.restaurant_id = usr.restaurant_id where res.restaurant_id='.$id.' and res.is_approved = "1"');

        if ($restaurants) 
        {
            $restaurant_details = $restaurants[0];
        }
        else
        {
            $restaurant_details = array();
        }

        return $restaurant_details;
    }

    // Get restaturant Row
    public static function get_one_restaurant_details($id)
    {
        $restaurants = DB::select('select * from restaurants AS res left join users AS usr ON res.restaurant_id = usr.restaurant_id where res.restaurant_id='.$id);

        if ($restaurants) 
        {
        	$restaurant_details = $restaurants[0];
        }
        else
        {
        	$restaurant_details = array();
        }

        return $restaurant_details;
    }

    // Shared function to get restaurant name
    public static function get_restaurant_name($id)
    {
        $restaurants = DB::select('select restaurant_name from restaurants where restaurant_id='.$id);

        if($restaurants)
        {   
            $restaurants_array = $restaurants[0];

            $restaurant_name   = $restaurants_array->restaurant_name;
        }
        else
        {
            $restaurant_name = "";
        }

        return $restaurant_name;
    }

    // Get approved restaurants
    public static function get_approved_restaurants()
    {
        $approved_restaurants = DB::select('select * from restaurants where is_approved="1"');

        if ($approved_restaurants) 
        {
            $restaurants = $approved_restaurants;
        }
        else
        {
            $restaurants = array();
        }

        return $restaurants;
    }

    // Get Pending restaurants
    public static function get_pending_restaurants()
    {
        $pending_restaurants = DB::select('select * from restaurants where is_approved="0"');

        if ($pending_restaurants) 
        {
            $restaurants = $pending_restaurants;
        }
        else
        {
            $restaurants = array();
        }

        return $restaurants;
    }

    // Create restaurant details
    public static function create_restaurant_details($create_data = array())
    {   
        $rows_added = DB::table('restaurants')->insert($create_data);

        if ($rows_added) 
        {
            $restaurant_id = DB::getPdo()->lastInsertId();

            return $restaurant_id;
        }
        else
        {
            return 0;
        }
    }

    // Update restaurant details
    public static function update_restaurant_details($restaturant_id, $update_data = array())
    {
        $update_restaurant = DB::table('restaurants')
                                        ->where('restaurant_id', $restaturant_id)
                                        ->update($update_data);

        if ($update_restaurant) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
