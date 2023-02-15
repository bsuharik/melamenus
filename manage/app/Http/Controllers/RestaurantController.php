<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use File;
use App\Models\{RestaurantModel,CategoryModel,MenuModel,TableModel,CurrencyModel,UserModel,CountryModel,TextureModel,FontModel};
use Auth;
class RestaurantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public static function restaurant_details($id){
        $restaurant_details=RestaurantModel::where('restaurant_id',$id)->with('parent_category_detail','currency_detail','country_detail','menu_detail','table_detail','user_detail')->first();
        $category_count = "0";
        $menu_count     = "0";
        $table_count    = "0";
        $parent_category_count = "0";
        $parent_menu_count     = "0";
        $parent_restaurant_details=array();
        // Get Categories
        if(!empty($restaurant_details->parent_category_detail)){ 
            $category_count = count($restaurant_details->parent_category_detail);
            
        }
        // Get Currency
        $currency_name=" ";
        if(!empty($restaurant_details->currency_detail->currency_name)){
            $currency_name=$restaurant_details->currency_detail->currency_name;
        }
        // Get Menus 
        if(!empty($restaurant_details->menu_detail)){
            $menu_count=count($restaurant_details->menu_detail->toArray());
            
        }
        // Get Tables
        if(!empty($restaurant_details->table_detail)){
            $table_count=count($restaurant_details->table_detail->toArray());
        }
        // Get Country
        $country_name="";
        if(!empty($restaurant_details->country_detail->country_name)){
            $country_name=$restaurant_details->country_detail->country_name;
        }
        // check restaurant User or not  
        $user_detail=UserModel::where('restaurant_id',$id)->first();
        $parent_restaurant_details=array();
        $restaurant_details->restaurant_user=array();
        if(!empty($user_detail->restaurant_owner_id)){
            // Parent Restaurant Get Detail Start
            $parent_restaurant_details=RestaurantModel::where('restaurant_id',$user_detail->restaurant_owner_id)->with('user_detail')->first();
            $restaurant_details->restaurant_user =Auth::User();
        }
        
        // echo "<pre>"; print_r($parent_restaurant_details);  echo "</pre>"; exit();
        return view('restaurant/details',['restaurant' => $restaurant_details, 'category_count' => $category_count, 'menu_count' => $menu_count, 'table_count' => $table_count, 'currency_name' => $currency_name, 'country_name' => $country_name,'parent_restaurant_details'=>$parent_restaurant_details]);
    } 
    // Update Restaurant Form
    public function update_restaurant_details($id)
    { 
        // echo $id; exit();
        // Restaurant details
        $restaurant_details=RestaurantModel::where('restaurant_id',$id)->with('user_detail','font_type_detail','texture_detail')->first();  
        $font_type_detail = FontModel::where('restaurant_id',$id)->orWhere('is_default','1')->get();
        $restaurant_details->font_type_detail =$font_type_detail;
        $currency_array =array();
        $currency_array = CurrencyModel::all();
        $font_type=array();
        // Get Country Array
        $country_array =array();
        $country_array = CountryModel::all();
        $texture_array =array();
        $texture_array = TextureModel::all();
        return view('restaurant/edit',['restaurant' => $restaurant_details, 'currency_list' => $currency_array,'country_list' => $country_array,'texture_array'=>$texture_array]);
    }
    // Update Restaurant Data
    public function update_restaurant(Request $request)
    {
        $restaurant_id = $request->restaurant_id;
        // Get current restaurant 
        $restaurant_details=RestaurantModel::where('restaurant_id',$restaurant_id)->first();
        if (!empty($restaurant_details)) 
        {
            $current_restaurant_logo = $restaurant_details->restaurant_logo;
            $current_restaurant_coverimage = $restaurant_details->restaurant_cover_image;
            if ($current_restaurant_logo == "" && $current_restaurant_coverimage == "") 
            {
                $validator = Validator::make($request->all(), [
                                    'restaurant_name' => 'required',
                                    'first_name'      => 'required',
                                    'last_name'       => 'required',
                                    'contact_person'  => 'required',
                                    'email'           => 'required|email',
                                    'contact_number'  => 'required',
                                    'country_id'      => 'required',
                                    'time_zone'      => 'required',
                                    'location'        => 'required',
                                    'currency_id'     => 'required',
                                    'restaurant_logo' => 'required|mimes:jpeg,png|max:2048',
                                    'restaurant_cover_image' => 'required|mimes:jpeg,png|max:2048',
                                ]);
            }
            else
            {
                $validator = Validator::make($request->all(), [
                                    'restaurant_name' => 'required',
                                    'first_name'      => 'required',
                                    'last_name'       => 'required',
                                    'contact_person'  => 'required',
                                    'email'           => 'required|email',
                                    'contact_number'  => 'required',
                                    'country_id'      => 'required',
                                    'time_zone'      => 'required',
                                    'location'        => 'required',
                                    'currency_id'     => 'required',
                                    'restaurant_logo' => 'mimes:jpeg,png|max:2048',
                                    'restaurant_cover_image' => 'mimes:jpeg,png|max:2048',
                                ]);
            } 
            if ($validator->passes()) 
            {
                $file = $request->file('restaurant_logo');
                $coverfile = $request->file('restaurant_cover_image');
                if (!empty($file)) 
                {
                    $restaurant_logo_name = explode(".", $file->getClientOriginalName());
                    $restaurant_logo = $restaurant_logo_name[0].'-'.time().".".$restaurant_logo_name[1];
                    // File Path
                    $destinationPath = config('images.restaurant_url').$restaurant_id;
                    // Delete current file
                    File::delete($destinationPath.'/'.$current_restaurant_logo);
                    $file->move($destinationPath,$restaurant_logo);
                }
                else{
                    $restaurant_logo = $current_restaurant_logo;
                }
                if (!empty($coverfile)){
                    $restaurant_coverimage_name = explode(".", $coverfile->getClientOriginalName());
                    $restaurant_coverimage = $restaurant_coverimage_name[0].'-'.time().".".$restaurant_coverimage_name[1];
                    $destinationPath = config('images.restaurant_url').$restaurant_id;
                    // Delete current file
                    File::delete($destinationPath.'/'.$current_restaurant_coverimage);
                    $coverfile->move($destinationPath,$restaurant_coverimage);
                }
                else
                {
                    $restaurant_coverimage = $current_restaurant_coverimage;
                }
                if(!empty($request->texture_id)){
                    $texture_id=$request->texture_id;
                }else{
                    $texture_id =NULL;
                }
                // Update restaurant row
                $update_res = RestaurantModel::where('restaurant_id',$restaurant_id)->first();
                $update_res->restaurant_name = $request->restaurant_name;
                $update_res->contact_person  = $request->contact_person;
                $update_res->email           = $request->email;
                $update_res->contact_number  = $request->contact_number;
                $update_res->country_id      = $request->country_id;
                $update_res->time_zone_id      = $request->time_zone;
                $update_res->location        = $request->location;
                $update_res->currency_id     = $request->currency_id;
                $update_res->texture_id     = $texture_id;
                $update_res->restaurant_logo = $restaurant_logo;
                $update_res->restaurant_cover_image = $restaurant_coverimage;
                $update_res->app_theme_color_1 = $request->app_theme_color_1;
                $update_res->app_theme_color_2 = $request->app_theme_color_2;
                $update_res->app_theme_color_3 = $request->app_theme_color_3;
                $update_res->app_theme_color_4 = $request->app_theme_color_4;
                $update_res->app_theme_font_style_1 = $request->app_theme_font_style_1;
                $update_res->app_theme_font_style_2 = $request->app_theme_font_style_2;
                $update_res->app_theme_font_style_3 = $request->app_theme_font_style_3;
                $update_res->app_theme_font_style_4 = $request->app_theme_font_style_4;
                $update_res->app_theme_font_type_1 = $request->app_theme_font_type_1;
                $update_res->app_theme_font_type_2 = $request->app_theme_font_type_2;
                $update_res->app_theme_font_type_3 = $request->app_theme_font_type_3;
                $update_res->app_theme_font_type_4 = $request->app_theme_font_type_4;
                $update_res->updated_at      = date('Y-m-d H:i:s');
                $update_restaurant = $update_res->save();
                if($update_restaurant)
                {
                    // Update User row
                    $updateUser = UserModel::where('restaurant_id',$restaurant_id)->first();
                    $updateUser->first_name = $request->first_name;
                    $updateUser->last_name = $request->last_name; 
                    $updateUser->email    = $request->email;
                    $updateUser->gender    = $request->gender;
                    $updateUser->date_of_birth = $request->date_of_birth;
                    $updateUser->updated_at= date('Y-m-d H:i:s');
                    $update_user = $updateUser->save();
                    if ($update_user) 
                    {
                        return response()->json(['success'=>'Data Updated successfully']);
                    }
                    else
                    {
                        return response()->json(['errors'=>'Error while updating data']);
                    }
                }
                else
                {
                    return response()->json(['errors'=>'Error while updating data']);
                }
            }
            return response()->json(['error'=>$validator->errors()]);
        }
        else
        {
            return response()->json(['errors'=>'Incorrect restaurant details']);
        }
    }
    public function restaurant()
    {        return view('restaurant');
    }
}
