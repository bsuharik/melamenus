<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class TagModel extends Model
{
    public function __construct()
    {
    }

    // Get restaturant menus
    public static function get_all_tags()
    {
        $tags = DB::select('select * from tags');

        if ($tags) 
        {
        	$tag_array = $tags;
        }
        else
        {
        	$tag_array = array();
        }

        return $tag_array;
    }

    // Shared function to get tag
    public static function get_tag_details($id)
    {
        // Get Tag
        $tags = DB::select('select * from tags WHERE tag_id = '.$id);

        if($tags)
        {   
            $tags_array = $tags[0];
        }
        else
        {
            $tags_array = [];
        }

        return $tags_array;
    }

    // Add tag
    public static function create_tag_details($add_data)
    {
        $row_added = DB::table('tags')->insert($add_data);

        if($row_added)
        {   
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Update tag
    public static function update_tag_details($tag_id,$update_data)
    {
        $row_updated = DB::table('tags')->where('tag_id',$tag_id)->update($update_data);

        if($row_updated)
        {   
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Delete tag
    public static function delete_tag_details($tag_id)
    {
        $row_deleted = DB::table('tags')->where('tag_id', $tag_id)->delete();

        if($row_deleted)
        {   
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Shared function to get tag names
    public static function get_tag_names($tag_ids)
    {
        // Get Tag
        $tags = DB::select('select tag_name from tags WHERE tag_id IN('.$tag_ids.')');

        if($tags)
        {   
            $tag_names = "";
            foreach ($tags as $key => $value) 
            {
                if ($tag_names == "") 
                {
                    $tag_names .= $value->tag_name;
                }
                else
                {
                    $tag_names .= ", ".$value->tag_name;
                }
            }
        }
        else
        {
            $tag_names = "";
        }

        return $tag_names;
    }

    // Shared function to get multiple tag
    public static function get_multiple_tag_details($tag_ids)
    {
        // Get Tag
        $tags = DB::select('select * from tags WHERE tag_id IN ('.$tag_ids.') ');

        if($tags)
        {   
            $tags_array = $tags;
        }
        else
        {
            $tags_array = [];
        }

        return $tags_array;
    }
}
