<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AllergyModel extends Model
{
    public function __construct()
    {
    }

    // Get list of allergies
    public static function get_all_allergies()
    {
        $allergies = DB::select('select * from allergies');

        if ($allergies) 
        {
        	$allergy_array = $allergies;
        }
        else
        {
        	$allergy_array = array();
        }

        return $allergy_array;
    }

    // Shared function to get allergies
    public static function get_allergy_details($id)
    {
        // Get allergy
        $allergies = DB::select('select * from allergies WHERE allergy_id = '.$id);

        if($allergies)
        {   
            $allergy_array = $allergies[0];
        }
        else
        {
            $allergy_array = [];
        }

        return $allergy_array;
    }

    // Add allergies
    public static function create_allergy_details($add_data)
    {
        $row_added = DB::table('allergies')->insert($add_data);

        if($row_added)
        {   
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Update allergy
    public static function update_allergy_details($allergy_id,$update_data)
    {
        $row_updated = DB::table('allergies')->where('allergy_id',$allergy_id)->update($update_data);

        if($row_updated)
        {   
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Delete allergy
    public static function delete_allergy_details($allergy_id)
    {
        $row_deleted = DB::table('allergies')->where('allergy_id', $allergy_id)->delete();

        if($row_deleted)
        {   
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
