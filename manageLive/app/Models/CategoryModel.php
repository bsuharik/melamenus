<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CategoryModel extends Model
{
    public function __construct()
    {
    }

    // Get restaturant categories by Type
    public static function get_restaurant_categories_by_type($restaurant_id,$category_type)
    {
        $categories = DB::select('select * from category where restaurant_id='.$restaurant_id.' and category_type = "'.$category_type.'"');

        if ($categories) 
        {
            $categories_details = $categories;
        }
        else
        {
            $categories_details = [];
        }

        return $categories_details;
    }

    // Get restaturant categories
    public static function get_restaurant_categories($restaurant_id)
    {
        $categories = DB::select('select * from category where restaurant_id='.$restaurant_id);

        if ($categories) 
        {
            $categories_details = $categories;
        }
        else
        {
            $categories_details = [];
        }

        return $categories_details;
    }

    // Get one category row
    public static function get_one_category_row($category_id)
    {
        $category_details = DB::select('select * from category where category_id='.$category_id);

        if($category_details)
        {   
            $category_details_array = $category_details[0];
        }
        else
        {
            $category_details_array = [];
        }

        return $category_details_array;
    }

    // Get category name by id
    public static function get_category_name($category_id)
    {
        $category_name = "";
        
        $category_details = DB::select('select category_name from category where category_id='.$category_id);

        if($category_details)
        {   
            $category_details_array = $category_details[0];
            $category_name = $category_details_array->category_name;
        }

        return $category_name;
    }

    // Delete category row
    public static function delete_category_row($id)
    {
        // Delete Category
        $delete_category        = DB::table('category')->where('category_id', $id)->delete();
        $delete_category_parent = DB::table('category')->where('parent_category_id', $id)->delete();
        $delete_category_main   = DB::table('category')->where('main_category_id', $id)->delete();

        // Delete Menus
        $delete_menu_parent = DB::table('menus')->where('parent_category', $id)->delete();
        $delete_menu_main   = DB::table('menus')->where('main_category', $id)->delete();
        $delete_menu_sub    = DB::table('menus')->where('sub_category', $id)->delete();

        if ($delete_category) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Update category details
    public static function update_category_details($category_id, $update_data = array())
    {
        $rows_updated = DB::table('category')
                                        ->where('category_id', $category_id)
                                        ->update($update_data);

        if ($rows_updated) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Create category details
    public static function create_category_details($insert_data = array())
    {
        $rows_created = DB::table('category')->insert($insert_data);

        if ($rows_created) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Get Main categories
    public static function get_restaurant_main_categories($restaurant_id,$parent_category_id)
    {
        if ($parent_category_id != "") 
        {
            $main_categories = DB::select('select * from category where restaurant_id='.$restaurant_id.' and category_type = "1" and parent_category_id = '.$parent_category_id);

            if ($main_categories) 
            {
                $main_category_array = $main_categories;
            }
            else
            {
                $main_category_array = [];
            }
        }
        else
        {
            $main_category_array = [];
        }

        return $main_category_array;
    }

    // Get Sub categories
    public static function get_restaurant_sub_categories($restaurant_id,$parent_category_id,$main_category_id)
    {
        if ($parent_category_id == "") 
        {
            $sub_category_array = [];
        }
        else if ($main_category_id == "") 
        {
            $sub_category_array = [];
        }
        else
        {
            $sub_categories = DB::select('select * from category where restaurant_id='.$restaurant_id.' and category_type = "2" and parent_category_id = '.$parent_category_id.' and main_category_id = '.$main_category_id);

            if ($sub_categories) 
            {
                $sub_category_array = $sub_categories;
            }
            else
            {
                $sub_category_array = [];
            }
        }

        return $sub_category_array;
    }

    // category Filters
    public static function get_categories_by_id($restaurant_id, $parent_category_id = '',$main_category_id = '', $sub_category_id = '')
    {
        $condition = "";

        if ($parent_category_id != "") 
        {
            $condition = " restaurant_id=".$restaurant_id." and (parent_category_id = ".$parent_category_id." or category_id = ".$parent_category_id.")";
        }

        if ($main_category_id != "") 
        {
            $condition = " restaurant_id=".$restaurant_id." and parent_category_id = ".$parent_category_id." and main_category_id = ".$main_category_id." or category_id IN (".$main_category_id.",".$parent_category_id.")";
        }

        if ($sub_category_id != "") 
        {
            $condition = " restaurant_id=".$restaurant_id." and category_id IN (".$parent_category_id.",".$main_category_id.",".$sub_category_id.")";
        }

        if ($condition == "") 
        {
            $condition = " restaurant_id=".$restaurant_id;
        }

        $category_details = DB::select('select * from category where '.$condition);

        if($category_details)
        {   
            $category_details_array = $category_details;
        }
        else
        {
            $category_details_array = [];
        }
        
        return $category_details;
    }
}
