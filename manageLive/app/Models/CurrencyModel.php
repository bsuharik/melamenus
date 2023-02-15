<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CurrencyModel extends Model
{
    public function __construct()
    {
    }

    // Get currecy Name
    public static function get_currency_name($currency_id)
    {
        $currency = DB::select('select currency_name from currency where currency_id ='.$currency_id);

        if($currency)
        {   
            $currency_array = $currency[0];
            $currency_name  = $currency_array->currency_name;
        }
        else
        {
            $currency_name = "";
        }

        return $currency_name;
    }

    // Get All currecy rows
    public static function get_all_currecy_rows()
    {
        $currency = DB::select('select * from currency');

        if($currency)
        {   
            $currency_array = $currency;
        }
        else
        {
            $currency_array = array();
        }

        return $currency_array;
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
