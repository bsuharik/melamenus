<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;    
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Redirect;
use Auth;
use Mail; 
use App\Models\RestaurantModel;
use App\Models\TableModel;
use App\Models\CategoryModel; 
use App\Models\MenuModel;
use App\Models\CurrencyModel;
use App\Models\CountryModel;
use App\Models\UserModel;
use App\Models\TextureModel;
use App\Models\MenuImage;
use Validator;
use Hash;
use Illuminate\Support\Facades\File;
class HomeController extends Controller
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
    // Admin Dashboard
    public function index(){
        $user_type = Auth::user()->user_type;
        if ($user_type == "0")  
        {
            $restaurants =array();
            $restaurants=RestaurantModel::where('is_approved',"0")->get();
            $approved_restaurants=0;
            $approved_restaurant = RestaurantModel::where('is_approved',"1")->count();
            if($approved_restaurant > 0){
                $approved_restaurants =$approved_restaurant;
            }
            $tables=array();
           $tables = TableModel::all(); 
            return view('home',['restaurant_count' => $approved_restaurants,'restaurants'=>$restaurants,'tables'=>$tables]);
        }
        else if ($user_type == "1") 
        {
            $id = Auth::user()->restaurant_id;
            $restaurant_details = RestaurantModel::where('restaurant_id',$id)->where('is_approved',"1")->first();
            if (!empty($restaurant_details)){
                if(!empty(Auth::user()->restaurant_owner_id)){
                    $res_id = Auth::user()->restaurant_id;
                     return RestaurantController::restaurant_details($res_id);
                }else{
                     return RestaurantController::restaurant_details($id);
                }
            }
            else
            {
                Auth::logout(); // log the user out of our application
                return redirect('login')->with('error', 'Please wait till your request is accepted by administrator!');
                // return Redirect::to('login'); // redirect the user to the login screen
            }
        }
        else
        {
            $id = Auth::user()->restaurant_id;
            return UserController::index($id);
        }
    }
    // List of restaurants 
    public function restaurant() 
    {
        $restaurants=array();
        $restaurants = RestaurantModel::where('is_approved','1')->get();
        return view('restaurant',['restaurants'=>$restaurants]);
    }
    // Approve restaurant Request
    public function approve_restaurant_request($id)
    {
        $restaurant_details = RestaurantModel::where('restaurant_id',$id)->first();
        if(!empty($restaurant_details))
        {   
            $restaurant_details->is_approved='1';
            $update_restaurant=$restaurant_details->save();
            if($update_restaurant)
            {
                $to_name  = $restaurant_details->restaurant_name;
                $to_email = $restaurant_details->email;
                $data = array(
                                'restaurant_name' => $restaurant_details->restaurant_name,
                                'email'           => $restaurant_details->email
                            );
                // Send email to restaurant owner
                Mail::send('email.approve_restaurant', ["data"=>$data] , function($message) use ($to_name, $to_email){
                    $message->to($to_email, $to_name)->subject('Mela Menus - Restaurant Request Approved');
                    $message->from('info@melamenus.com','Mela Menus');
                });
                return back()->with('success','Restaurant Request is approved successfully!');
            }
            else
            {
                return back()->with('error','Error While approving restaurant request');
            }
        }
        else
        {
            $restaurants =array();
            $restaurants=RestaurantModel::where('is_approved',"0")->get();
            return view('restaurant',['restaurants'=>$restaurants]);
        }
    }
    // Reject restaurant Request
    public function reject_restaurant_request($id)
    {
        $restaurant_details = RestaurantModel::where('restaurant_id',$id)->first();
        if(!empty($restaurant_details))
        {
            $restaurant_details->is_approved='2';
            $update_restaurant=$restaurant_details->save();
            if($update_restaurant) 
            {
                $to_name  = $restaurant_details->restaurant_name;
                $to_email = $restaurant_details->email;
                $data = array(
                                'restaurant_name' => $restaurant_details->restaurant_name,
                                'email'           => $restaurant_details->email
                            );
                // Send email to restaurant owner
                Mail::send('email.reject_restaurant', ["data"=>$data] , function($message) use ($to_name, $to_email){
                    $message->to($to_email, $to_name)->subject('Mela Menus - Restaurant Request Rejected');
                    $message->from('info@melamenus.com','Mela Menus');
                });
                return back()->with('success','Restaurant Request is rejected successfully!');
            }
            else
            {
                return back()->with('error','Error While rejecting restaurant request');
            } 
        }
        else
        {
            $restaurants =array();
            $restaurants=RestaurantModel::where('is_approved',"0")->get();
            return view('restaurant',['restaurants'=>$restaurants]);
        }
    }
    // APP users list
    public function get_app_users(){
        $restaurants_id = Auth::user()->restaurant_id;
        $user_type=Auth::user()->user_type;
        $users=array();
        $restaurants=array();
        $currency_array=array();
        $country_array =array();
        if ($user_type == "0"){
            $users = UserModel::whereIn('user_type',['1','2'])->get(); 
        }else if(($user_type == "1")){
            // Get Currency Array
            $currency_array = CurrencyModel::all();
            $country_array = CountryModel::all();
            $usersId = UserModel::where('user_type','1')->where('restaurant_owner_id',$restaurants_id)->get();
            $resIds=array();
            if(!empty($usersId)){
                $resIds= array_column($usersId->toArray(),'restaurant_id');
            }
            $restaurants = RestaurantModel::where('is_approved','1')->whereIn('restaurant_id',$resIds)->get();
        }
        return view('user/index',['users_list' => $users,'country_array'=>$country_array,'currency_list'=>$currency_array,'restaurants'=>$restaurants]);
    } 
    // Add User 
    public function create_user(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name'      => 'required',
            'last_name'       => 'required',
            'email'           => 'required|email|unique:users,email',
            'restaurant_name' => 'required',
            'gender'       => 'required',
            'date_of_birth'=>'required',
            'contact_person'  => 'required',
            'contact_number'  => 'required|numeric',
            'address'        => 'required',
            'country'      => 'required',
            'time_zone'      => 'required',
            'currency'        => 'required',
            'password'        => [
                'required',
                'min:6',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
            'password_confirmation' => 'required|min:6',
        ]);
        if ($validator->passes())    
        {
            $parenet_restaurant_details=RestaurantModel::where('restaurant_id',$request->restaurant_id)->first();
            // Add Restaurant
            $add_rest= new RestaurantModel();
            $add_rest->restaurant_name = $request->restaurant_name;
            $add_rest->contact_person  = $request->contact_person;
            $add_rest->email           = $request->email;
            $add_rest->contact_number  = $request->contact_number;
            $add_rest->location        = $request->address;
            $add_rest->country_id      = $request->country;
            $add_rest->time_zone_id      = $request->time_zone;
            $add_rest->currency_id     = $request->currency;
            $add_rest->is_approved     = '1';
            if(!empty($parenet_restaurant_details->texture_id)){
                $add_rest->texture_id     = $parenet_restaurant_details->texture_id;
            }
            if(!empty($parenet_restaurant_details->app_theme_color_1)){
                $add_rest->app_theme_color_1 = $parenet_restaurant_details->app_theme_color_1;
            }
            if(!empty($parenet_restaurant_details->app_theme_color_2)){
                $add_rest->app_theme_color_2 = $parenet_restaurant_details->app_theme_color_2;
            }
            if(!empty($parenet_restaurant_details->app_theme_color_3)){
                $add_rest->app_theme_color_3 = $parenet_restaurant_details->app_theme_color_3;
            }
            if(!empty($parenet_restaurant_details->app_theme_color_4)){
                $add_rest->app_theme_color_4 = $parenet_restaurant_details->app_theme_color_4;
            }
            if(!empty($parenet_restaurant_details->app_theme_font_style_1)){
                $add_rest->app_theme_font_style_1 = $parenet_restaurant_details->app_theme_font_style_1;
            }
            if(!empty($parenet_restaurant_details->app_theme_font_style_2)){
                $add_rest->app_theme_font_style_2 = $parenet_restaurant_details->app_theme_font_style_2;
            }
            if(!empty($parenet_restaurant_details->app_theme_font_style_3)){
                $add_rest->app_theme_font_style_3 = $parenet_restaurant_details->app_theme_font_style_3;
            }
            if(!empty($parenet_restaurant_details->app_theme_font_style_4)){
                $add_rest->app_theme_font_style_4 = $parenet_restaurant_details->app_theme_font_style_4;
            }
            $add_rest->created_at      = date('Y-m-d H:i:s');
            $row_added = $add_rest->save();
            $new_restaurant_id=$add_rest->restaurant_id;
            if (! File::exists(config('images.restaurant_url').$new_restaurant_id)) {
                File::makeDirectory(config('images.restaurant_url').$new_restaurant_id);
            }
            if(!empty($parenet_restaurant_details->restaurant_logo)){
                $logo_image_oldPath = config('images.restaurant_url').$parenet_restaurant_details->restaurant_id.'/'.$parenet_restaurant_details->restaurant_logo;
                $logo_image_newPath = config('images.restaurant_url').$new_restaurant_id.'/'.$parenet_restaurant_details->restaurant_logo;
                File::copy($logo_image_oldPath,$logo_image_newPath);
                $add_rest->restaurant_logo = $parenet_restaurant_details->restaurant_logo;  
                $add_rest->save(); 
            }
            if(!empty($parenet_restaurant_details->restaurant_cover_image)){
                $cover_image_oldPath = config('images.restaurant_url').$parenet_restaurant_details->restaurant_id.'/'.$parenet_restaurant_details->restaurant_cover_image;
                $cover_image_newPath = config('images.restaurant_url').$new_restaurant_id.'/'.$parenet_restaurant_details->restaurant_cover_image;
                File::copy($cover_image_oldPath,$cover_image_newPath); 
                $add_rest->restaurant_cover_image = $parenet_restaurant_details->restaurant_cover_image; 
                $add_rest->save();
            }
            $restaurant_details=RestaurantModel::where('restaurant_id',$request->restaurant_id)->with('parent_category_detail','main_category_detail','sub_category_detail','menu_detail')->first();
                // Save Parent Caregrory  Start
                if($restaurant_details->parent_category_detail){
                    foreach($restaurant_details->parent_category_detail as $parent_cat){
                        $new_restaurant_id=$add_rest->restaurant_id;
                        if (! File::exists(config('images.category_url').$new_restaurant_id)) {
                            File::makeDirectory(config('images.category_url').$new_restaurant_id);
                        }
                        if(!empty($parent_cat->category_icon)){
                            $oldPath = config('images.category_url').$parent_cat->restaurant_id.'/'.$parent_cat->category_icon;
                            $newPath = config('images.category_url').$new_restaurant_id.'/'.$parent_cat->category_icon;
                            File::copy($oldPath,$newPath);   
                        }
                        $parent_category =new CategoryModel();
                        if(!empty($parent_cat->category_icon)){
                             $parent_category->category_icon = $parent_cat->category_icon;
                         }
                        $parent_category->restaurant_id=$new_restaurant_id;
                        $parent_category->category_name =$parent_cat->category_name;
                        $parent_category->created_at = date('Y-m-d H:i:s');
                        $parent_category->category_type = "0";
                        $parent_category->parent_res_cat_id =$parent_cat->category_id;
                        $last_order_category = CategoryModel::where('restaurant_id',$new_restaurant_id)->where('category_type',0)->orderBy('order_display', 'desc')->first();
                        if(!empty($last_order_category)){
                            $parent_category->order_display = $last_order_category->order_display + 1; 
                        }else{
                            $parent_category->order_display = 1;
                        }
                        $is_saved = $parent_category->save();
                    }
                }
                // Save Parent Caregrory  End 
                // Save Main Caregrory  Start
                if($restaurant_details->main_category_detail){
                    foreach($restaurant_details->main_category_detail as $main_cat){
                        $new_restaurant_id=$add_rest->restaurant_id;
                        $parent_category_detail =CategoryModel::where('parent_res_cat_id',$main_cat->parent_category_id)->where('restaurant_id',$new_restaurant_id)->first();
                        if(!empty($parent_category_detail->category_id)){
                            $oldPath = config('images.category_url').$main_cat->restaurant_id.'/'.$main_cat->category_icon;
                            if (! File::exists(config('images.category_url').$new_restaurant_id)) {
                                File::makeDirectory(config('images.category_url').$new_restaurant_id);
                            }
                            if(!empty($main_cat->category_icon)){
                                $oldPath = config('images.category_url').$main_cat->restaurant_id.'/'.$main_cat->category_icon;
                                $newPath = config('images.category_url').$new_restaurant_id.'/'.$main_cat->category_icon;
                                File::copy($oldPath,$newPath);   
                            }
                            $category_main= new CategoryModel();
                                if(!empty($main_cat->category_icon)){
                                    $category_main->category_icon = $main_cat->category_icon;
                                }
                            $category_main->restaurant_id=$new_restaurant_id;
                            $category_main->category_name =$main_cat->category_name;
                            $category_main->created_at = date('Y-m-d H:i:s');
                            $category_main->category_type = "1";
                            $category_main->parent_res_cat_id = $main_cat->category_id;
                            $category_main->parent_category_id =$parent_category_detail->category_id;
                            if($main_cat->display_type == "2"){
                                $category_main->display_type = $main_cat->display_type;
                                $category_main->day = $main_cat->display_type;
                                $category_main->start_time =  $main_cat->start_time;
                                $category_main->end_time =  $main_cat->end_time;
                            }else{
                              $category_main->parent_category_id =  $parent_category_detail->category_id;
                              $category_main->display_type = $main_cat->display_type;  
                            }
                            $last_order_category = CategoryModel::where('restaurant_id',$new_restaurant_id)->where('category_type',1)->orderBy('order_display', 'desc')->first();
                            if(!empty($last_order_category)){
                                $category_main->order_display = $last_order_category->order_display + 1;
                            }else{
                                $category_main->order_display = 1;
                            }
                            $is_saved = $category_main->save();
                        }
                    }
                }
                // Save Main Caregrory  End
                // Save Sub Caregrory  Start
                if($restaurant_details->sub_category_detail){
                    foreach($restaurant_details->sub_category_detail as $sub_cat){
                        $new_restaurant_id=$add_rest->restaurant_id;
                        $main_category_detail =CategoryModel::where('parent_res_cat_id',$sub_cat->main_category_id)->where('restaurant_id',$new_restaurant_id)->first();
                        if(!empty($main_category_detail->category_id)){
                            $oldPath = config('images.category_url').$sub_cat->restaurant_id.'/'.$sub_cat->category_icon;
                            if (! File::exists(config('images.category_url').$new_restaurant_id)) {
                                File::makeDirectory(config('images.category_url').$new_restaurant_id);
                            }
                            if(!empty($sub_cat->category_icon)){
                                $oldPath = config('images.category_url').$sub_cat->restaurant_id.'/'.$sub_cat->category_icon;
                                $newPath = config('images.category_url').$new_restaurant_id.'/'.$sub_cat->category_icon;
                                File::copy($oldPath,$newPath);   
                            }
                            $sub_category = new CategoryModel();
                            if(!empty($sub_cat->category_icon)){
                                $sub_category->category_icon=$sub_cat->category_icon;
                            }
                            $sub_category->restaurant_id=$new_restaurant_id;
                            $sub_category->category_type='2';
                            $sub_category->parent_category_id = $main_category_detail->parent_category_id;
                            $sub_category->main_category_id = $main_category_detail->category_id;
                            $sub_category->parent_res_cat_id = $sub_cat->category_id;
                            $sub_category->category_name =$sub_cat->category_name;
                            $sub_category->created_at = date('Y-m-d H:i:s');
                            $last_order_category = CategoryModel::where('restaurant_id',$new_restaurant_id)->where('category_type','2')->orderBy('order_display', 'desc')->first();
                            if(!empty($last_order_category)){
                                $sub_category->order_display = $last_order_category->order_display + 1;
                            }else{
                                $sub_category->order_display = 1;
                            }
                            $is_saved = $sub_category->save();
                        }
                    }
                }
                // Save Sub Caregrory  End
                // Save Menu Item  Start
                if($restaurant_details->menu_detail){
                    foreach($restaurant_details->menu_detail as $menu_detail){
                        $new_restaurant_id=$add_rest->restaurant_id;
                        $menu_details_get = MenuModel::where('menu_id',$menu_detail->menu_id)->with('menu_image_detail')->first(); 
                        if(!empty($menu_details_get)){
                            // Add row
                            $menu_create = new MenuModel ();
                            $menu_create->restaurant_id  = $new_restaurant_id;
                            $menu_create->name           = $menu_details_get->name;
                            $menu_create->slug           = $menu_details_get->slug.'-'.rand(pow(10, 2-1), pow(10, 2)-1);
                            $menu_create->price         = $menu_details_get->price;
                            $menu_create->price_description =$menu_details_get->price_description;
                            if(!empty($menu_details_get->parent_category)){
                                $menu_parent_category = CategoryModel::where('parent_res_cat_id',$menu_details_get->parent_category)->where('restaurant_id',$new_restaurant_id)->first();
                                if(!empty($menu_parent_category->category_id)){
                                    $menu_create->parent_category = $menu_parent_category->category_id;
                                } 
                            }
                            if(!empty($menu_details_get->main_category)){
                                $menu_main_category = CategoryModel::where('parent_res_cat_id',$menu_details_get->main_category)->where('restaurant_id',$new_restaurant_id)->first();
                                if(!empty($menu_main_category->category_id)){
                                    $menu_create->main_category  = $menu_main_category->category_id;
                                }
                            }
                            if(!empty($menu_details_get->sub_category)){
                                $menu_sub_category = CategoryModel::where('parent_res_cat_id',$menu_details_get->sub_category)->where('restaurant_id',$new_restaurant_id)->first();
                                if(!empty($menu_sub_category->category_id)){
                                    $menu_create->sub_category  = $menu_sub_category->category_id;
                                }
                            }
                            if (! File::exists(config('images.menu_url').$new_restaurant_id)) {
                                File::makeDirectory(config('images.menu_url').$new_restaurant_id);
                            }
                            if(!empty($menu_details_get->menu_image)){
                                $oldPath = config('images.menu_url').$menu_details_get->restaurant_id.'/'.$menu_details_get->menu_image;
                                $newPath = config('images.menu_url').$new_restaurant_id.'/'.$menu_details_get->menu_image;
                                File::copy($oldPath,$newPath);   
                            }
                            $destinationPath = config('images.menu_url').$menu_details_get->restaurant_id;
                            $menu_create->menu_image     = $menu_details_get->menu_image;
                            $menu_create->availiblity    = $menu_details_get->availiblity;
                            $menu_create->ingredients   = $menu_details_get->ingredients;
                            $menu_create->allergies     = $menu_details_get->allergies;
                            $menu_create->calories     = $menu_details_get->calories;
                            $menu_create->link     = $menu_details_get->link;
                            $menu_create->tag_id       = $menu_details_get->tag_id;
                            $menu_create->description   = $menu_details_get->description;
                            $menu_create->created_at     = date('Y-m-d H:i:s');
                            if(empty($menu_details_get->order_display)){
                                $order_menu = MenuModel::where('restaurant_id',$new_restaurant_id)->where('parent_category',$menu_parent_category->category_id)->where('main_category',$menu_main_category->category_id);
                                if(!empty($menu_main_category->category_id)){
                                   $order_menu->where('sub_category',$menu_main_category->category_id); 
                                }
                                $last_order_menu = $order_menu->first();
                                if(!empty($last_order_menu)){
                                    $menu_create->order_display = $last_order_menu->order_display + 1;
                                }else{
                                    $menu_create->order_display = 1;
                                }
                            }else{
                              $menu_create->order_display   = $menu_details_get->order_display;  
                            }
                            $is_save=$menu_create->save();
                            if(!empty($menu_details_get->menu_image_detail)){
                                foreach($menu_details_get->menu_image_detail as $menu_image){
                                    $add_menu_image =new MenuImage();
                                    if (! File::exists(config('images.menu_url').$new_restaurant_id)) {
                                        File::makeDirectory(config('images.menu_url').$new_restaurant_id);
                                    }
                                    $oldPath = config('images.menu_url').$menu_image->restaurant_id.'/'.$menu_image->image_name;
                                    $newPath = config('images.menu_url').$new_restaurant_id.'/'.$menu_image->image_name;
                                    File::copy($oldPath,$newPath); 
                                    $add_menu_image->menu_id = $menu_create->menu_id;  
                                    $add_menu_image->image_name=$menu_image->image_name;
                                    $add_menu_image->restaurant_id=$new_restaurant_id;
                                    $is_save=$add_menu_image->save();
                                }
                            } 
                        }
                    }
                }
                // Save Menu Item  End   
            if(!empty($row_added)){
                $restaurant_id = $add_rest->restaurant_id;
                // Add user
                $user = new UserModel();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->gender = $request->gender;
                $user->date_of_birth = \Carbon\Carbon::parse($request->date_of_birth)->format('Y/m/d');
                $user->password = Hash::make($request->password);
                $user->user_type = '1';
                $user->restaurant_id =$restaurant_id;
                $user->restaurant_owner_id = $request->restaurant_id;
                $user->created_at =  date('Y-m-d H:i:s');
                // Send mail to user
                $to_name  = $request->first_name." ".$request->last_name;
                $to_email = $request->email;
                $data = array(
                    'first_name' => $request->first_name,
                    'last_name'  => $request->last_name,
                    'email'  => $request->email,
                    'password'  => $request->password,
                    'login_url'  => url('/login'),
                ); 
                Mail::send('email.app_user_registartion', ["data"=>$data] , function($message) use ($to_name, $to_email){
                    $message->to($to_email, $to_name)->subject('Mela Menus - Restaurant Created');
                    $message->from('info@melamenus.com','Mela Menus');
                });
                $user->save(); 
                $user_row_added=1;
                if($user_row_added){
                    return response()->json(['success'=> 'User data added successfully']);
                }
                else{
                    return response()->json(['errors'=>'Error while adding data']);
                }
            }else
            {
                return response()->json(['errors'=>'Error while adding data']);
            }
        }
        return response()->json(['error'=>$validator->errors()]);
    }
    public function texture_list(){ 
        $textures_array = TextureModel::all();
        return view('textures/index',['texture_list' => $textures_array]);
    }
    // Create Texture
    public function create_texture(Request $request){
        $validator = Validator::make($request->all(),[
            'image' => 'required|mimes:jpeg,png|max:1000',
        ]);
        if ($validator->passes())  
        {
            $file = $request->file('image');
            $textture_icon_name = explode(".", $file->getClientOriginalName());
            $texture_image_name = $textture_icon_name[0].'-'.time().".".$textture_icon_name[1];
            // File Path
            $destinationPath = config('images.texture_url');
            $file->move($destinationPath,$texture_image_name);
            // Create Tag new
            $textures = new TextureModel();
            $textures->image= $texture_image_name;
            $textures->created_at=date('Y-m-d H:i:s');
            $is_saved = $textures->save();
            if ($is_saved) {
                return response()->json(['success'=>'Data Added successfully']);
            } else {
               return response()->json(['errors'=>'Error while adding data']);
            }
        }
        return response()->json(['error'=>$validator->errors()]);
    }
    // Update Texture
    public function update_texture(Request $request){
        $current_image = $request->current_image;
        if($current_image == ""){
            $validator = Validator::make($request->all(), [
                'image' => 'required|mimes:jpeg,png|max:100',
            ]);
        }else{
             $validator = Validator::make($request->all(), [
            ]);
        }
        if($validator->passes()){
            $file = $request->file('image');
            $textures = TextureModel::find($request->id);
            if (!empty($file)) 
            {
                $texture_image = explode(".", $file->getClientOriginalName());
                $texture_image_name = $texture_image[0].'-'.time().".".$texture_image[1];
                // File Path
                $destinationPath = config('images.texture_url');
                // Delete current file
                File::delete($destinationPath.'/'.$current_image);
                $file->move($destinationPath,$texture_image_name);
                $is_saved = $textures->update([
                    "image" => $texture_image_name,
                    "updated_at"=> date('Y-m-d H:i:s'),
                ]);
            }else{
                $is_saved = $textures->update([
                   "updated_at" => date('Y-m-d H:i:s'),
                ]);
            } 
            // Update Tag row
            if($is_saved)
            {
                return response()->json(['success'=>'Data Updated successfully']);
            }
            else
            {
                return response()->json(['errors'=>'Error while adding data']);
            }
        }
        return response()->json(['error'=>$validator->errors()]);
    }
    // Delete Texture details
    public function delete_texture($id){
        // Get Texture details
        $textures_array = TextureModel::find($id);
        if($textures_array)
        {
            $image = $textures_array->image;
            // File Path
            $destinationPath = config('images.texture_url');
            // Delete current file
            File::delete($destinationPath.'/'.$image);
            // Delete Tag
            $delete_texture = $textures_array->delete();
            if ($delete_texture) 
            {
                return redirect()->route('textures');
            }
            else
            {
                return back()->with('error','Error while deleting Tag details.');
            }
        }
        else
        {
            return back()->with('error','Incorrect Tag Details');
        }        
    }
}