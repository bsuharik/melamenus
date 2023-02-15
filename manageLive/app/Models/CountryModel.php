<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CountryModel extends Model
{
    public function __construct()
    {
    }

    // Get country Name
    public static function get_country_name($country_id)
    {
        $countries = DB::select('select country_name from countries where country_id ='.$country_id);

        if($countries)
        {   
            $country_array = $countries[0];
            $country_name  = $country_array->country_name;
        }
        else
        {
            $country_name = "";
        }

        return $country_name;
    }

    // Get All country rows
    public static function get_all_country_rows()
    {
        $countries = DB::select('select * from countries');

        if($countries)
        {   
            $countries_array = $countries;
        }
        else
        {
            $countries_array = array();
        }

        return $countries_array;
    }

    // Get restaurant currency icon
    public static function get_restaurant_currency_icon($id)
    {
        // Get Currency
        $currency = DB::select('select cur.currency_icon from restaurants AS res JOIN currency AS cur ON res.currency_id = cur.currency_id WHERE res.restaurant_id = '.$id);

        if($currency)
        {   
            $currency_array = $currency[0];
            $currency_icon  = $currency_array->currency_icon;
        }
        else
        {
            $currency_icon = "";
        }

        return $currency_icon;
    }
}
