<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use DB;



class RestaurantModel extends Model

{

    protected $table = "restaurants";

    protected $fillable = ['restaurant_name', 'restaurant_logo', 'restaurant_cover_image', 'contact_person', 'email', 'contact_number', 'country_id', 'location', 'currency_id', 'is_approved', 'app_theme_color_1', 'app_theme_color_2', 'app_theme_color_3', 'app_theme_color_4', 'created_at', 'updated_at'];

    protected $primaryKey = 'restaurant_id';

    public function __construct()
    {
    }

    public function currency_detail()
    {

        return $this->hasOne('App\Models\CurrencyModel', 'currency_id', 'currency_id');
    }

    public function country_detail()
    {

        return $this->hasOne('App\Models\CountryModel', 'country_id', 'country_id');
    }

    public function time_zone_detail()
    {

        return $this->hasOne('App\Models\CountryModel', 'country_id', 'time_zone_id');
    }

    public function texture_detail()
    {

        return $this->hasOne('App\Models\TextureModel', 'id', 'texture_id');
    }

    public function parent_category_detail()
    {

        return $this->hasMany('App\Models\CategoryModel', 'restaurant_id', 'restaurant_id')->where('category_type', '0')->orderBy('order_display', 'ASC');
    }

    public function main_category_detail()
    {

        return $this->hasMany('App\Models\CategoryModel', 'restaurant_id', 'restaurant_id')->where('category_type', '1')->orderBy('order_display', 'ASC');
    }

    public function sub_category_detail()
    {

        return $this->hasMany('App\Models\CategoryModel', 'restaurant_id', 'restaurant_id')->where('category_type', '2')->orderBy('order_display', 'ASC');
    }

    public function menu_detail()
    {

        return $this->hasMany('App\Models\MenuModel', 'restaurant_id', 'restaurant_id');
    }

    public function table_detail()
    {

        return $this->hasMany('App\Models\TableModel', 'restaurant_id', 'restaurant_id');
    }

    public function font_type_detail(){
        return $this->hasMany('App\Models\FontModel', 'restaurant_id', 'restaurant_id');
    }

    public function user_detail()
    {

        return $this->hasOne('App\Models\UserModel', 'restaurant_id', 'restaurant_id');
    }

    public function get_app_theme_font_type_1()
    {

        return $this->hasOne('App\Models\FontModel', 'id', 'app_theme_font_type_1');
    }

    public function get_app_theme_font_type_2()
    {

        return $this->hasOne('App\Models\FontModel', 'id', 'app_theme_font_type_2');
    }

    public function get_app_theme_font_type_3()
    {

        return $this->hasOne('App\Models\FontModel', 'id', 'app_theme_font_type_3');
    }

    public function get_app_theme_font_type_4()
    {

        return $this->hasOne('App\Models\FontModel', 'id', 'app_theme_font_type_4');
    }
}
