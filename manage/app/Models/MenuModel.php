<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB; 
 
class MenuModel extends Model
{ 
    protected $table="menus"; 
    protected $fillable = ['restaurant_id','name','description','menu_image','price','parent_category','main_category','sub_category','availiblity','ingredients','allergies','calories','tag_id','total_like','total_dislike','created_at','updated_at'];
    protected $primaryKey = 'menu_id';
    public function __construct()
    {
    }
    public function allergie_detail(){
        return $this->hasOne('App\Models\AllergyModel','allergy_id','allergies');
    }
    public function user_menu_fav(){
        return $this->hasMany('App\Models\FavMenu','menu_id','menu_id');
    }
    public function menu_image_detail(){ 
        return $this->hasMany('App\Models\MenuImage','menu_id','menu_id');
    }
}
