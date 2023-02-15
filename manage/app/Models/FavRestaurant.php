<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; 
class FavRestaurant extends Model{ 
     protected $table="fav_restaurant"; 
    protected $fillable = ['restaurant_id','user_id','created_at','updated_at'];
    public function __construct()
    {
    }
    public function user_detail(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
    public function restaurant_detail(){
        return $this->hasOne('App\Models\RestaurantModel','restaurant_id','restaurant_id');
    } 
     
}
