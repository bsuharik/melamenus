<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MenuModel extends Model
{
    public function __construct()
    {
    }

    // Get restaturant menus
    public static function get_restaurant_menus($restaturant_id)
    {
        $menus = DB::select('select * from menus where restaurant_id = '.$restaturant_id);

        if ($menus) 
        {
        	$menu_array = $menus;
        }
        else
        {
        	$menu_array = array();
        }

        return $menu_array;
    }

    // Get restaturant menus
    public static function get_one_menu_details($menu_id)
    {
        $menu_details = DB::select('select * from menus where menu_id='.$menu_id);

        if ($menu_details) 
        {
            $menu_array = $menu_details[0];
        }
        else
        {
            $menu_array = array();
        }

        return $menu_array;
    }

    // Create Menu details
    public static function create_menu_details($insert_data = array())
    {
        $rows_created = DB::table('menus')->insert($insert_data);

        if ($rows_created) 
        {
            $menu_id = DB::getPdo()->lastInsertId();

            return $menu_id;
        }
        else
        {
            return 0;
        }
    }

    // Update Menu details
    public static function update_menu_details($menu_id, $update_data = array())
    {
        $rows_updated = DB::table('menus')
                                        ->where('menu_id', $menu_id)
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

    // Delete Menu details
    public static function delete_menu_details($menu_id)
    {
        $rows_deleted = DB::table('menus')->where('menu_id', $menu_id)->delete();
        $delete_question = DB::table('chef_questions')->where('menu_id', $menu_id)->delete();
        
        if ($rows_deleted) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Get restaurant menu chef questions
    public static function get_restaurant_menu_chef_questions($restaurant_id,$menu_id)
    {
        $chef_questions = DB::select('select * from chef_questions where restaurant_id='.$restaurant_id.' and menu_id = '.$menu_id);

        if ($chef_questions) 
        {
            $chef_questions_array = $chef_questions;
        }
        else
        {
            $chef_questions_array = [];
        }

        return $chef_questions_array;
    }

    // Create chef questions details
    public static function create_menu_chef_question_details($insert_data = array())
    {
        $rows_created = DB::table('chef_questions')->insert($insert_data);

        if ($rows_created) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Update chef questions details
    public static function update_menu_chef_question_details($chef_question_id, $update_data = array())
    {
        $rows_updated = DB::table('chef_questions')->where('chef_question_id', $chef_question_id)->update($update_data);

        if ($rows_updated) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Delete chef questions details
    public static function delete_menu_chef_question_details($chef_question_id)
    {
        $delete_question = DB::table('chef_questions')->where('chef_question_id', $chef_question_id)->delete();

        if ($delete_question) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Menu filters
    public static function get_menus_by_category(
                                                    $restaurant_id, 
                                                    $parent_category_id = '',
                                                    $main_category_id = '', 
                                                    $sub_category_id = '', 
                                                    $top_rated = 0
                                                )
    {
        $condition = "";

        if ($parent_category_id != "") 
        {
            $condition = " restaurant_id=".$restaurant_id." and parent_category = ".$parent_category_id."";
        }

        if ($main_category_id != "") 
        {
            $condition = " restaurant_id=".$restaurant_id." and parent_category = ".$parent_category_id." and main_category = ".$main_category_id."";
        }

        if ($sub_category_id != "") 
        {
            $condition = " restaurant_id=".$restaurant_id." and parent_category = ".$parent_category_id." and main_category = ".$main_category_id." and sub_category = ".$sub_category_id;
        }

        if ($condition == "") 
        {
            $condition = " restaurant_id=".$restaurant_id;
        }

        if ($top_rated) 
        {
            $condition .= " order by total_like DESC";
        }

        $menu_details = DB::select('select * from menus where '.$condition);

        if($menu_details)
        {   
            $menu_details_array = $menu_details;
        }
        else
        {
            $menu_details_array = [];
        }
        
        return $menu_details;
    }

    // Get Menu By Tags
    public static function get_menus_by_tag($restaurant_id, $tag_id, $parent_category_id = '',$main_category_id = '', $sub_category_id = '')
    {
        $condition = "";
        
        if ($parent_category_id != "") 
        {
            $condition = " restaurant_id=".$restaurant_id." and parent_category = ".$parent_category_id;
        }

        if ($main_category_id != "") 
        {
            $condition = " restaurant_id=".$restaurant_id." and parent_category = ".$parent_category_id." and main_category = ".$main_category_id;
        }

        if ($sub_category_id != "") 
        {
            $condition = " restaurant_id=".$restaurant_id." and parent_category = ".$parent_category_id." and main_category = ".$main_category_id." and sub_category = ".$sub_category_id;
        }

        if ($condition == "") 
        {
            $condition = " restaurant_id=".$restaurant_id;
        }

        $tag_ids = [];
        if ($tag_id != "" && $tag_id != "0") 
        {
            $tag_ids = explode(",", $tag_id);
            $tag_condition = "";

            foreach ($tag_ids as $key => $value) 
            {
                if ($value != "0") 
                {
                    if ($tag_condition == "") 
                    {
                        $tag_condition .= " and (tag_id LIKE ('%".$value."%')";
                    }
                    else
                    {
                        $tag_condition .= " or tag_id LIKE ('%".$value."%')";
                    }
                }
            }

            $condition .= $tag_condition.")";
        }

        if(in_array("0", $tag_ids) || $tag_id == "0")
        {
            $condition .= " order by total_like DESC";
        }

        $menu_details = DB::select('select * from menus where '.$condition);

        if($menu_details)
        {   
            $menu_details_array = $menu_details;
        }
        else
        {
            $menu_details_array = [];
        }
        
        return $menu_details_array;
    }

    // Get one menu vote rows
    public static function get_all_menu_votes($restaurant_id, $menu_id)
    {
        $menu_details = DB::select('select * from menu_votes as menu left join users as usr on menu.user_id = usr.id where menu.menu_id='.$menu_id.' and menu.restaurant_id ='.$restaurant_id);

        if ($menu_details) 
        {
            $menu_array = $menu_details;
        }
        else
        {
            $menu_array = array();
        }

        return $menu_array;
    }

    // Get user menu vote row
    public static function get_user_menu_vote($user_id, $restaurant_id, $menu_id)
    {
        $menu_details = DB::select('select * from menu_votes where menu_id='.$menu_id.' and restaurant_id ='.$restaurant_id.' and user_id='.$user_id);

        if ($menu_details) 
        {
            $menu_array = $menu_details[0];
        }
        else
        {
            $menu_array = array();
        }

        return $menu_array;
    }

    // Create Menu Vote details
    public static function create_menu_vote_details($insert_data = array())
    {
        $rows_created = DB::table('menu_votes')->insert($insert_data);

        if ($rows_created) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Update Menu Vote details
    public static function update_menu_vote_details($where_condition = array(), $update_data = array())
    {
        $rows_updated = DB::table('menu_votes')
                                        ->where($where_condition)
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

    // Get one menu Review rows
    public static function get_all_menu_reviews_not_used($restaurant_id, $menu_id)
    {
        $menu_details = DB::select('select * from menu_review as menu left join users as usr on menu.user_id = usr.id where menu.menu_id='.$menu_id.' and menu.restaurant_id ='.$restaurant_id);

        if ($menu_details) 
        {
            $menu_array = $menu_details;
        }
        else
        {
            $menu_array = array();
        }

        return $menu_array;
    }

    // Get one menu vote row
    public static function get_user_menu_review_not_used($user_id, $restaurant_id, $menu_id)
    {
        $menu_details = DB::select('select * from menu_review where menu_id='.$menu_id.' and restaurant_id ='.$restaurant_id.' and user_id='.$user_id);

        if ($menu_details) 
        {
            $menu_array = $menu_details[0];
        }
        else
        {
            $menu_array = array();
        }

        return $menu_array;
    }

    // Create Menu Review details
    public static function create_menu_review_details_not_used($insert_data = array())
    {
        $rows_created = DB::table('menu_review')->insert($insert_data);

        if ($rows_created) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Update Menu Review details
    public static function update_menu_review_details_not_used($where_condition = array(), $update_data = array())
    {
        $rows_updated = DB::table('menu_review')
                                        ->where($where_condition)
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
}
