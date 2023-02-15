<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserModel extends Model
{

    protected $table="users"; 
    protected $fillable = ['first_name','last_name','email','password','user_type','gender','date_of_birth','restaurant_id','remember_token','created_at','updated_at'];
    public function __construct()
    {
    }

    public function menu_fav(){
        return $this->hasMany('App\Models\FavMenu','id','user_id');
    }
}
