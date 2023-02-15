<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class FavMenu extends Model
{ 
     protected $table="menu_fav"; 
    protected $fillable = ['restaurant_id','user_id','menu_id','created_at','updated_at'];
    public function __construct()
    {
    }
    public function user_detail(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
    public function menu_detail(){
        return $this->hasOne('App\Models\MenuModel','menu_id','menu_id');
    }
    public function menu_image(){
        return $this->hasMany('App\Models\MenuImage','menu_id','menu_id');
    }
    public function restaurant_detail(){
        return $this->hasOne('App\Models\RestaurantModel','restaurant_id','restaurant_id');
    } 
}
