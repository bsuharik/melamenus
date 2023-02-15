<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserModel extends Model
{
    protected $table="users"; 
    protected $fillable = [];
    public function __construct()
    {
    }

    // Get All users
    public static function get_all_users($create_data = array())
    {
        $users = DB::select('select * from users where user_type="2"');

        if ($users) 
        {
            $users_array = $users;
        }
        else
        {
            $users_array = [];
        }

        return $users_array;
    }

    // Create User details
    public static function create_user_details($create_data = array())
    {
        $rows_added = DB::table('users')->insert($create_data);

        if ($rows_added) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    // Update User details
    public static function update_user_details($where_column, $where_column_value, $update_data = array())
    {
        $update_user = DB::table('users')
                                ->where($where_column, $where_column_value)
                                ->update($update_data);

        if ($update_user) 
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
