<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Hash;
use Auth;
use Cookie;
use Redirect;

use Mail;
use App\Models\CategoryModel;
use App\Models\RestaurantModel;
use App\Models\MenuModel;
use App\Models\TagModel;
use App\Models\ViewsModel;
use App\Models\UserModel;
use App\Models\CurrencyModel;
use App\Models\ChefQuestion;
use App\Models\MenuVote;
use App\Models\FavMenu;
use App\Models\AllergyModel;
use App\Models\MenuImage;
// use App\CurrencyValue;
use Session;
use Carbon\Carbon;
use App\Models\FavRestaurant;
use App\Models\MyTagModel;
use App\Models\MyAllergyModel;
use App\Models\TableModel;
use Stichoza\GoogleTranslate\GoogleTranslate;
use DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // APP User Dashboard
    public static function index($restaurant_id)
    {
        $parent_categories = array();
        $main_categories = array();
        $sub_categories = array();
        $restaurant_details = array();
        if ($restaurant_id != "") {
            session()->put('restaurant_id', $restaurant_id);
            if (request()->has('table_no') && request()->has('chair_no')) {
                $table_no = request()->table_no;
                $chair_no = request()->chair_no;
                $table = TableModel::where('restaurant_id', $restaurant_id)->where('table_number', $table_no)->first();
                if ($chair_no <= $table->chairs) {
                    session()->put('table_no', $table_no);
                    session()->put('chair_no', $chair_no);
                } else {
                    session()->put('table_no', '');
                    session()->put('chair_no', '');
                }
            }
			
			//fixed view
			if(!request()->has('prew')){
				
				$rest_views = session('rest_view');

				$rest_views_mass = explode(',', $rest_views);
				
				if(!in_array($restaurant_id, $rest_views_mass)){
					
					$rest_views_mass[] = $restaurant_id;
					$rest_views_mass = array_diff($rest_views_mass, array(''));
					$rest_views_mass = implode(',', $rest_views_mass);
					
					session(['rest_view' => $rest_views_mass]);
					
					$views = new ViewsModel();
                    $views->restaurant_id = $restaurant_id;
                   $views->date = date("Y-m-d");
                   // $views->date = '2023-03-11';
                    $is_saved = $views->save();
					$data = session()->all();

				}
					
				
			}
			//fixed view
            session()->save();
			

			
            // Restaurant Details 
            $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('parent_category_detail', 'main_category_detail', 'sub_category_detail', 'currency_detail', 'get_app_theme_font_type_1', 'get_app_theme_font_type_2', 'get_app_theme_font_type_3', 'get_app_theme_font_type_4', 'country_detail', 'texture_detail')->first();
            // Get Parent Categories
			//echo "<pre>main_categories"; print_r($restaurant_details); echo "</pre>";
        //exit();
            if (!empty($restaurant_details->parent_category_detail)) {
                $parent_categories = $restaurant_details->parent_category_detail;
            }
            // Get Country Detail
            // Get Main Categories
            if (!empty($restaurant_details->time_zone_detail)) {
                $timeZone = $restaurant_details->time_zone_detail->time_zone;
                if (!empty($restaurant_details->main_category_detail)) {
                    foreach ($restaurant_details->main_category_detail as $main_category_detail) {
                        if ($main_category_detail->display_type == 2) {
                            $daysArray = explode(",", $main_category_detail->day);
                            // echo "<pre>"; print_r($daysArray); echo "</pre>";
                            $mytime = Carbon::now($timeZone);
                            $today_date = $mytime->toRfc850String();
                            $current_day = substr($today_date, 0, strrpos($today_date, ","));
                            $daysArray = explode(",", $main_category_detail->day);
                            if (in_array("All", $daysArray)) {
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            } else if (in_array($current_day, $daysArray)) {
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            }
                        } else {
                            $main_categories[] = $main_category_detail;
                        }
                    }
                }
            }
            // exit();
            // Get Sub Categories
            if (!empty($restaurant_details->sub_category_detail)) {
                $sub_categories = $restaurant_details->sub_category_detail;
            }
            $fav_restaurant = 0;
            if (!empty(Auth::User()->id)) {
                $user_id = Auth::User()->id;
                $fav_restaurant = FavRestaurant::where('user_id', $user_id)->where('restaurant_id', $restaurant_id)->count();
            }
            $parent_restaurant_details = array();
            /* get Parent restauraant Detail Start */
            if (!empty($restaurant_details->user_detail->restaurant_owner_id)) {
                $parent_restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_details->user_detail->restaurant_owner_id)->first();
            }
            /* get Parent restauraant Detail End */
            // echo "<pre>"; print_r($parent_categories); echo "</pre>"; exit();
            return view('user_app/home', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'fav_restaurant' => $fav_restaurant, 'parent_restaurant_details' => $parent_restaurant_details]);
        } else {
            Auth::logout(); // log the user out of our application
            return Redirect::to('login'); // redirect the user to the login screen
        }
    }
    // Main Categories list
    public function main_categories($parent_category)
    {
        $parent_category_details = CategoryModel::where('category_id', $parent_category)->first();
        //echo $parent_category; exit();
        $restaurant_id = $parent_category_details->restaurant_id;
        $currency_icon = " ";
        $restaurant_details = array();
        $parent_categories = array();
        $main_categories = array();
        $sub_categories = array();
        $parent_main_categories = array();
        $in_main_categories = array();
        $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('currency_detail', 'parent_category_detail', 'main_category_detail', 'sub_category_detail', 'get_app_theme_font_type_1', 'get_app_theme_font_type_2', 'get_app_theme_font_type_3', 'get_app_theme_font_type_4', 'texture_detail')->first();
        //echo "<pre>"; print_r($restaurant_details->time_zone_detail); echo "</pre>"; 
        // Restaurant Details
        $fav_restaurant = 0;
        if (!empty($restaurant_details)) {
            // Get Currency icon
            if (!empty($restaurant_details->currency_detail)) {
                $currency_icon = $restaurant_details->currency_detail->currency_icon;
            }
            // Get Parent Categories
            if (!empty($restaurant_details->parent_category_detail)) {
                $parent_categories = $restaurant_details->parent_category_detail;
            }
            // Get Main Categories
            //if (!empty($restaurant_details->time_zone_detail)) {
               // $timeZone = $restaurant_details->time_zone_detail->time_zone;
                if (!empty($restaurant_details->main_category_detail)) {
                    foreach ($restaurant_details->main_category_detail as $main_category_detail) {
                        if ($main_category_detail->display_type == 2 && $kkkkkkkk==1) {
                            $mytime = Carbon::now($timeZone);
                            $today_date = $mytime->toRfc850String();
                            $current_day = substr($today_date, 0, strrpos($today_date, ","));
                            $daysArray = explode(",", $main_category_detail->day);
                            if (in_array("All", $daysArray)) {
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            }
                            if (in_array($current_day, $daysArray)) {
                                // if($main_category_detail->day ==$current_day){
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            }
                        } else {
                            $main_categories[] = $main_category_detail;
                        }
						$main_categories[] = $main_category_detail;
                    }
                }
            //}
            // Get Sub Categories
            if (!empty($restaurant_details->sub_category_detail)) {
                $sub_categories = $restaurant_details->sub_category_detail;
            }
            $parent_main_categories_all = CategoryModel::where('restaurant_id', $restaurant_id)->where('parent_category_id', $parent_category)->where('category_type', '1')->orderBy('order_display', 'ASC')->get();
            if (!empty($main_categories) && !empty($parent_main_categories_all)) {
                //if (!empty($restaurant_details->time_zone_detail)) {
                   // $timeZone = $restaurant_details->time_zone_detail->time_zone;
                    foreach ($parent_main_categories_all as $main_category_detail) {
                        if ($main_category_detail->display_type == 2  && $kkkkkkkk==1) {
                            $mytime = Carbon::now($timeZone);
                            $today_date = $mytime->toRfc850String();
                            $current_day = substr($today_date, 0, strrpos($today_date, ","));
                            $daysArray = explode(",", $main_category_detail->day);
                            if (in_array("All", $daysArray)) {
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $parent_main_categories[] = $main_category_detail;
                                    $in_main_categories[] = $main_category_detail->category_id;
                                }
                            }
                            if (in_array($current_day, $daysArray)) {
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $parent_main_categories[] = $main_category_detail;
                                    $in_main_categories[] = $main_category_detail->category_id;
                                }
                            }
                        } else {
                            $parent_main_categories[] = $main_category_detail;
                            $in_main_categories[] = $main_category_detail->category_id;
                        }
                    }
                //}
                // $parent_main_categories= $parent_main_categories_all;
            }
            if (!empty(Auth::User()->id)) {
                $user_id = Auth::User()->id;
                $fav_restaurant = FavRestaurant::where('user_id', $user_id)->where('restaurant_id', $restaurant_id)->count();
            }
        }
        // echo "<pre>parent_main_categories"; print_r($parent_main_categories); echo "</pre>";
        // echo "<pre>in_main_categories"; print_r($in_main_categories); echo "</pre>";
        // echo "<pre>main_categories"; print_r($main_categories); echo "</pre>";
        // exit();
        return view('user_app/main_categories', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'parent_main_categories' => $parent_main_categories, 'parent_category_id' => $parent_category, 'currency_icon' => $currency_icon, 'in_main_categories' => $in_main_categories, 'fav_restaurant' => $fav_restaurant]);
    }
    // Sub Categories list
    public static function sub_categories($main_category)
    {
        //echo $main_category; exit();
        $main_category_details = CategoryModel::where('category_id', $main_category)->first();
        $restaurant_id   = $main_category_details->restaurant_id;
        $restaurant_details = array();
        $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('parent_category_detail', 'main_category_detail', 'sub_category_detail', 'currency_detail', 'get_app_theme_font_type_1', 'get_app_theme_font_type_2', 'get_app_theme_font_type_3', 'get_app_theme_font_type_4', 'texture_detail')->first();
        //if (!empty($restaurant_details->time_zone_detail->time_zone)) {
            //$timeZone = $restaurant_details->time_zone_detail->time_zone;
            if ($main_category_details->display_type == 2 && $kkkkkkkk==1) {
                $mytime = Carbon::now($timeZone);
                $today_date = $mytime->toRfc850String();
                $current_day = substr($today_date, 0, strrpos($today_date, ","));
                $daysArray = explode(",", $main_category_details->day);
                if (in_array("All", $daysArray)) {
                    $current_time = $mytime->format('H:i');
                    $start_time = date("H:i", strtotime($main_category_details->start_time));
                    $end_time = date("H:i", strtotime($main_category_details->end_time));
                    if ($current_time >= $start_time && $current_time < $end_time) {
                        $main_category = $main_category;
                    } else {
                        $main_category = '';
                    }
                } else if (in_array($current_day, $daysArray)) {
                    // else if($main_category_details->day ==$current_day){
                    $current_time = $mytime->format('H:i');
                    $start_time = date("H:i", strtotime($main_category_details->start_time));
                    $end_time = date("H:i", strtotime($main_category_details->end_time));
                    if ($current_time >= $start_time && $current_time < $end_time) {
                        $main_category = $main_category;
                    } else {
                        $main_category = '';
                    }
                } else {
                    $main_category = '';
                }
            /*} else {
                $main_category = $main_category;
            }*/
        } else {
            $main_category = $main_category;
			//$main_category = '';
        }
        $parent_category = $main_category_details->parent_category_id;
        $sub_category    = '';
        // check valid  main category
        if (!empty($main_category)) {
            $menu_detail = MenuModel::select('*')->where('availiblity', '!=', '2');
            if (!empty($restaurant_id)) {
                $menu_detail->where('restaurant_id', $restaurant_id);
            }
            if (!empty($parent_category_id)) {
                $menu_detail->where('parent_category', $parent_category_id);
            }
            if (!empty($main_category)) {
                $menu_detail->where('main_category', $main_category);
            }
            $menu_item_data = $menu_detail->orderBy('order_display', 'ASC')->get();
        }
        $menu_items = array();
        $category_selected_tag_id = '';
        if (!empty($menu_item_data)) {
            foreach ($menu_item_data as $menu_value) {
                if (!empty($menu_value->tag_id)) {
                    $category_selected_tag_id .= $menu_value->tag_id . ',';
                }
                $tag_detail_data = TagModel::whereIn('tag_id', explode(',', $menu_value->tag_id))->get();
                if (!empty($tag_detail_data)) {
                    $menu_value->tag_detail = $tag_detail_data;
                } else {
                    $menu_value->tag_detail = array();
                }
                $user_menu_votes = '';
                $menu_value->menu_fav = 0;
                $menu_value->allergy_tag = 0;
                if (!empty(Auth::user()->id)) {
                    $user_id = Auth::user()->id;
                    $user_menu_votes = MenuVote::where('menu_id', $menu_value->menu_id)->where('restaurant_id', $menu_value->restaurant_id)->where('user_id', $user_id)->first();
                    if (!empty($user_menu_votes)) {
                        $menu_value->user_menu_votes = $user_menu_votes;
                    }
                    $user_menu_fav = FavMenu::where('restaurant_id', $menu_value->restaurant_id)->where('user_id', $user_id)->where('menu_id', $menu_value->menu_id)->first();
                    if (!empty($user_menu_fav)) {
                        $menu_value->menu_fav = 1;
                    }
                    if (!empty($menu_value->allergies)) {
                        $user_allergy = MyAllergyModel::whereIn('allergy_id', explode(',', $menu_value->allergies))->where('user_id', $user_id)->count();
                        if (!empty($user_allergy) && $user_allergy > 0) {
                            $menu_value->allergy_tag = 1;
                        }
                    }
                    $user_allergies = MyAllergyModel::where('user_id', $user_id)->get();
                    if (!empty($user_allergies)) {
                        foreach ($user_allergies as $Userallergy) {
                            if (!empty($Userallergy->allergy_name)) {
                                $get_menu_name = MenuModel::where('menu_id', $menu_value->menu_id)->where('restaurant_id', $restaurant_id)->where('name', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                $get_menu_desciption = MenuModel::where('menu_id', $menu_value->menu_id)->where('restaurant_id', $restaurant_id)->where('description', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                $get_menu_ingredients = MenuModel::where('menu_id', $menu_value->menu_id)->where('restaurant_id', $restaurant_id)->where('ingredients', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                if (!empty($get_menu_name) && $get_menu_name > 0 || !empty($get_menu_desciption) && $get_menu_desciption > 0 || !empty($get_menu_ingredients) && $get_menu_ingredients > 0) {
                                    $menu_value->allergy_tag = 1;
                                }
                            }
                        }
                    }
                }
                $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('currency_detail')->first();
                // Get Currency icon
                if (!empty($restaurant_details->currency_detail)) {
                    $currency_icon = $restaurant_details->currency_detail->currency_icon;
                }
                if (!empty($menu_value->price)) {
                    $price_array = explode(",", $menu_value->price);
                    if (Session::get('formatValue')) {
                        $menu_value->price = Session::get('currancy_symbol') . " " . number_format(Session::get('formatValue') *  max($price_array), 2, '.', '');
                    } else {
                        $menu_value->price = $currency_icon . " " . number_format(max($price_array), 2, '.', '');
                    }
                } else {
                    $menu_value->price = $currency_icon . " 00";
                }
                $menu_items[] = $menu_value;
            }
        }
        // Get sub Categories
        $main_sub_categories = array();
        if (!empty($main_category)) {
            $sub_categories = CategoryModel::where('restaurant_id', $restaurant_id)->where('parent_category_id', $parent_category)->where('main_category_id', $main_category)->where('category_type', '2')->orderBy('order_display', 'ASC')->get();
            if (!empty($sub_categories)) {
                $main_sub_categories = $sub_categories;
            }
        }
        $tags_array = array();
        if (!empty($category_selected_tag_id)) {
            $tagIdArray = explode(',', trim($category_selected_tag_id, ','));
            // Get Tags
            $tagIdArray = array_unique($tagIdArray);
            $tags_array = TagModel::whereIn('tag_id', $tagIdArray)->get();
        }
        //echo "<pre>here"; print_r($tagIdArray); echo "</pre>"; exit();
        // Restaurant Details
        $currency_icon = " ";
        $parent_categories = array();
        $main_categories = array();
        $sub_categories = array();
        $fav_restaurant = 0;
        if (!empty($restaurant_details)) {
            // Get Currency icon
            if (!empty($restaurant_details->currency_detail)) {
                $currency_icon = $restaurant_details->currency_detail->currency_icon;
            }
            // Get Parent Categories
            if (!empty($restaurant_details->parent_category_detail)) {
                $parent_categories = $restaurant_details->parent_category_detail;
            }
            // Get Main Categories
            if (!empty($restaurant_details->time_zone_detail)) {
                $timeZone = $restaurant_details->time_zone_detail->time_zone;
                if (!empty($restaurant_details->main_category_detail)) {
                    foreach ($restaurant_details->main_category_detail as $main_category_detail) {
                        if ($main_category_detail->display_type == 2) {
                            $mytime = Carbon::now($timeZone);
                            $today_date = $mytime->toRfc850String();
                            $current_day = substr($today_date, 0, strrpos($today_date, ","));
                            $daysArray = explode(",", $main_category_detail->day);
                            if (in_array("All", $daysArray)) {
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            }
                            if (in_array($current_day, $daysArray)) {
                                // if($main_category_detail->day ==$current_day){
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            }
                        } else {
                            $main_categories[] = $main_category_detail;
                        }
                    }
                }
            }
            // Get Sub Categories
            if (!empty($restaurant_details->sub_category_detail)) {
                $sub_categories = $restaurant_details->sub_category_detail;
            }
            if (!empty(Auth::User()->id)) {
                $user_id = Auth::User()->id;
                $fav_restaurant = FavRestaurant::where('user_id', $user_id)->where('restaurant_id', $restaurant_id)->count();
            }
        }
        return view('user_app/sub_categories', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'main_sub_categories' => $main_sub_categories, 'menu_items' => $menu_items, 'currency_icon' => $currency_icon, 'tags_array' => $tags_array, 'parent_category_id' => $parent_category, 'main_category_id' => $main_category, 'fav_restaurant' => $fav_restaurant]);
    }
    // Menu Item list
    public function menu_items($sub_category)
    {
        $main_sub_categories = [];
        $sub_category_details = CategoryModel::where('category_id', $sub_category)->first();
        $restaurant_id   = $sub_category_details->restaurant_id;
        $parent_category = $sub_category_details->parent_category_id;
        $main_category = '';
        // Restaurant Details
        $restaurant_details = array();
        $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('parent_category_detail', 'main_category_detail', 'sub_category_detail', 'currency_detail', 'get_app_theme_font_type_1', 'get_app_theme_font_type_2', 'get_app_theme_font_type_3', 'get_app_theme_font_type_4', 'texture_detail')->first();
        // check valid main caetegory or not 
        $main_category_detail = CategoryModel::where('category_id', $sub_category_details->main_category_id)->first();
        if (!empty($restaurant_details->time_zone_detail)) {
            $timeZone = $restaurant_details->time_zone_detail->time_zone;
            if (!empty($main_category_detail)) {
                if ($main_category_detail->display_type == 2) {
                    $mytime = Carbon::now($timeZone);
                    $today_date = $mytime->toRfc850String();
                    $current_day = substr($today_date, 0, strrpos($today_date, ","));
                    $daysArray = explode(",", $main_category_detail->day);
                    if (in_array("All", $daysArray)) {
                        $current_time = $mytime->format('H:i');
                        $start_time = date("H:i", strtotime($main_category_detail->start_time));
                        $end_time = date("H:i", strtotime($main_category_detail->end_time));
                        if ($current_time >= $start_time && $current_time < $end_time) {
                            $main_category = $sub_category_details->main_category_id;
                        }
                    }
                    if (in_array($current_day, $daysArray)) {
                        // if($main_category_detail->day ==$current_day){
                        $current_time = $mytime->format('H:i');
                        $start_time = date("H:i", strtotime($main_category_detail->start_time));
                        $end_time = date("H:i", strtotime($main_category_detail->end_time));
                        if ($current_time >= $start_time && $current_time < $end_time) {
                            $main_category = $sub_category_details->main_category_id;
                        }
                    }
                } else {
                    $main_category = $sub_category_details->main_category_id;
                }
            }
        }
        $currency_icon = " ";
        $parent_categories = array();
        $main_categories = array();
        $sub_categories = array();
        $fav_restaurant = 0;
        if (!empty($restaurant_details)) {
            // Get Currency icon
            if (!empty($restaurant_details->currency_detail)) {
                $currency_icon = $restaurant_details->currency_detail->currency_icon;
            }
            if (!empty($restaurant_details->parent_category_detail)) {
                $parent_categories = $restaurant_details->parent_category_detail;
            }
            if (!empty($restaurant_details->time_zone_detail)) {
                $timeZone = $restaurant_details->time_zone_detail->time_zone;
                if (!empty($restaurant_details->main_category_detail)) {
                    foreach ($restaurant_details->main_category_detail as $main_category_detail) {
                        if ($main_category_detail->display_type == 2) {
                            $mytime = Carbon::now($timeZone);
                            $today_date = $mytime->toRfc850String();
                            $current_day = substr($today_date, 0, strrpos($today_date, ","));
                            $daysArray = explode(",", $main_category_detail->day);
                            if (in_array("All", $daysArray)) {
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            }
                            if (in_array($current_day, $daysArray)) {
                                // if($main_category_detail->day ==$current_day){
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            }
                        } else {
                            $main_categories[] = $main_category_detail;
                        }
                    }
                }
            }
            // Get Sub Categories
            if (!empty($restaurant_details->sub_category_detail)) {
                $sub_categories = $restaurant_details->sub_category_detail;
            }
            if (!empty(Auth::User()->id)) {
                $user_id = Auth::User()->id;
                $fav_restaurant = FavRestaurant::where('user_id', $user_id)->where('restaurant_id', $restaurant_id)->count();
            }
        }
        // Get Menu Items
        if (!empty($main_category)) {
            $menu_item_detail = MenuModel::where('availiblity', '!=', '2')->where('restaurant_id', $restaurant_id)->where('parent_category', $parent_category)->where('main_category', $main_category)->where('sub_category', $sub_category)->orderBy('order_display', 'ASC')->get();
        }
        $menu_items = array();
        $category_selected_tag_id = '';
        if (!empty($menu_item_detail)) {
            foreach ($menu_item_detail as $menu_item_value) {
                if (!empty($menu_item_value->tag_id)) {
                    $category_selected_tag_id .= $menu_item_value->tag_id . ',';
                }
                if (!empty($menu_item_value)) {
                    $tag_detail_data = TagModel::whereIn('tag_id', explode(',', $menu_item_value->tag_id))->get();
                    if (!empty($tag_detail_data)) {
                        $menu_item_value->tag_detail = $tag_detail_data;
                    } else {
                        $menu_item_value->tag_detail = array();
                    }
                }
                $user_menu_votes = '';
                $menu_item_value->menu_fav = 0;
                $menu_item_value->user_menu_votes = '';
                $menu_item_value->allergy_tag = 0;
                $menu_item_value->fav_tag = 0;
                if (!empty(Auth::user()->id)) {
                    $user_id = Auth::user()->id;
                    $user_menu_votes = MenuVote::where('menu_id', $menu_item_value->menu_id)->where('restaurant_id', $menu_item_value->restaurant_id)->where('user_id', $user_id)->first();
                    if (!empty($user_menu_votes)) {
                        $menu_item_value->user_menu_votes = $user_menu_votes;
                    }
                    $user_menu_fav = FavMenu::where('menu_id', $menu_item_value->menu_id)->where('restaurant_id', $menu_item_value->restaurant_id)->where('user_id', $user_id)->first();
                    if (!empty($user_menu_fav)) {
                        $menu_item_value->menu_fav = 1;
                    }
                    if (!empty($menu_item_value->allergies)) {
                        $user_allergy = MyAllergyModel::whereIn('allergy_id', explode(',', $menu_item_value->allergies))->where('user_id', $user_id)->count();
                        if (!empty($user_allergy) && $user_allergy > 0) {
                            $menu_item_value->allergy_tag = 1;
                        }
                    }
                    $user_allergies = MyAllergyModel::where('user_id', $user_id)->get();
                    if (!empty($user_allergies)) {
                        foreach ($user_allergies as $Userallergy) {
                            if (!empty($Userallergy->allergy_name)) {
                                $get_menu_name = MenuModel::where('menu_id', $menu_item_value->menu_id)->where('restaurant_id', $restaurant_id)->where('name', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                $get_menu_desciption = MenuModel::where('menu_id', $menu_item_value->menu_id)->where('restaurant_id', $restaurant_id)->where('description', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                $get_menu_ingredients = MenuModel::where('menu_id', $menu_item_value->menu_id)->where('restaurant_id', $restaurant_id)->where('ingredients', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                if (!empty($get_menu_name) && $get_menu_name > 0 || !empty($get_menu_desciption) && $get_menu_desciption > 0 || !empty($get_menu_ingredients) && $get_menu_ingredients > 0) {
                                    $menu_item_value->allergy_tag = 1;
                                }
                            }
                        }
                    }
                    if (!empty($menu_item_value->tag_id)) {
                        $user_fav_tag = MyTagModel::whereIn('tag_id', explode(',', $menu_item_value->tag_id))->where('user_id', $user_id)->count();
                        if (!empty($user_fav_tag) && $user_fav_tag > 0) {
                            $menu_item_value->fav_tag = 1;
                        }
                    }
                }
                if (!empty($menu_item_value->price)) {
                    $price_array = explode(",", $menu_item_value->price);
                    if (Session::get('formatValue')) {
                        $menu_item_value->price = Session::get('currancy_symbol') . " " . number_format(Session::get('formatValue') * max($price_array), 2, '.', '');
                    } else {
                        $menu_item_value->price = $currency_icon . " " . number_format(max($price_array), 2, '.', '');
                    }
                } else {
                    $menu_item_value->price = '00';
                }
                $menu_items[] = $menu_item_value;
                // echo "<pre>"; print_r($menu_items); echo "</pre>"; exit();
                // $keys = array_column($menu_items, 'fav_tag');
                // array_multisort($keys, SORT_DESC, $menu_items);
            }
        }
        $tags_array = array();
        if (!empty($category_selected_tag_id)) {
            $tagIdArray = explode(',', trim($category_selected_tag_id, ','));
            // Get Tags
            $tagIdArray = array_unique($tagIdArray);
            $tags_array = TagModel::whereIn('tag_id', $tagIdArray)->get();
        }
        // echo "<pre>"; print_r($menu_items); echo "</pre>"; exit();
        return view('user_app/sub_categories', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'main_sub_categories' => $main_sub_categories, 'menu_items' => $menu_items, 'currency_icon' => $currency_icon, 'tags_array' => $tags_array, 'parent_category_id' => $parent_category, 'main_category_id' => $main_category, 'fav_restaurant' => $fav_restaurant]);
    }
    // Menu details
    public function menu_details($menu_id)
    {
        $main_sub_categories = [];
        // Get Menu details
        $menu_details = array();
		
        if (is_numeric($menu_id)) {
            $menuDetails = MenuModel::where('menu_id', $menu_id)->with('allergie_detail', 'menu_image_detail')->first();
        } else {
            $menuDetails = MenuModel::where('slug', $menu_id)->with('allergie_detail', 'menu_image_detail')->first();
        }

        $restaurant_id = $menuDetails->restaurant_id;
        $restaurant_details = array();
        $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('parent_category_detail', 'main_category_detail', 'sub_category_detail', 'currency_detail', 'get_app_theme_font_type_1', 'get_app_theme_font_type_2', 'get_app_theme_font_type_3', 'get_app_theme_font_type_4', 'texture_detail')->first();
        if (!empty($restaurant_details->time_zone_detail) && $menuDetails->availiblity !== '2') {
            $timeZone = $restaurant_details->time_zone_detail->time_zone;
            $main_category_detail = CategoryModel::where('category_id', $menuDetails->main_category)->first();
            if (!empty($main_category_detail)) {
                if ($main_category_detail->display_type == 2) {
                    $mytime = Carbon::now($timeZone);
                    $today_date = $mytime->toRfc850String();
                    $current_day = substr($today_date, 0, strrpos($today_date, ","));
                    $daysArray = explode(",", $main_category_detail->day);
                    if (in_array("All", $daysArray)) {
                        $current_time = $mytime->format('H:i');
                        $start_time = date("H:i", strtotime($main_category_detail->start_time));
                        $end_time = date("H:i", strtotime($main_category_detail->end_time));
                        if ($current_time >= $start_time && $current_time < $end_time) {
                            $menu_details = $menuDetails;
                        }
                    }
                    if (in_array($current_day, $daysArray)) {
                        $current_time = $mytime->format('H:i');
                        $start_time = date("H:i", strtotime($main_category_detail->start_time));
                        $end_time = date("H:i", strtotime($main_category_detail->end_time));
                        if ($current_time >= $start_time && $current_time < $end_time) {
                            $menu_details = $menuDetails;
                        }
                    }
                } else {
                    $menu_details = $menuDetails;
                }
            }
        }
        $currency_icon = "";
        if (!empty($restaurant_details->currency_detail->currency_icon)) {
            $currency_icon = $restaurant_details->currency_detail->currency_icon;
        }
        $tag_details = array();
        $allergie_details = array();
        $user_menu_votes = array();
        $menu_fav_count = 0;
        $chef_questions_array = array();
        if (!empty($menu_details)) {
            if (empty($menu_details->slug)) {
                $menu_slugs = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $menu_details->name)));
                $regex = "/\-+$/";
                $menu_slug = preg_replace($regex, "", $menu_slugs);
                $menuName_check = DB::table('menus')->whereNotIn('menu_id', [$menu_details->id])->where('slug', $menu_slug)->get()->count();
                if ($menuName_check > 0) {
                    $menuSlug = $menu_slug . '' . rand(pow(10, 2 - 1), pow(10, 2) - 1);
                } else {
                    $menuSlug = $menu_slug;
                }
                $menu_details->slug = $menuSlug;
                $menu_details->save();
            }
            if (!empty($menu_details->tag_id)) {
                $tag_details = TagModel::whereIn('tag_id', explode(',', $menu_details->tag_id))->get();
            }
            if (!empty($menu_details->tag_id)) {
                $allergie_details = AllergyModel::select('allergy_name')->whereIn('allergy_id', explode(',', $menu_details->allergies))->get();
            }
            $restaurant_id = $menu_details->restaurant_id;
            if (!empty(Auth::user()->id)) {
                $user_id = Auth::user()->id;
                $user_menu_votes = array();
                $user_menu_votes = MenuVote::where('menu_id', $menu_id)->where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->first();
                $menu_fav_count = FavMenu::where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->where('menu_id', $menu_id)->count();
            }
            // Get Chef questionsuser
            $chef_questions_array = ChefQuestion::where('restaurant_id', $restaurant_id)->where('menu_id', $menu_id)->get();
            $priceArray = array();
            if (!empty($menu_details->price)) {
                $price_descArray = array();
                if (!empty($menu_details->price_description)) {
                    $price_descArray = explode(",", $menu_details->price_description);
                }
                foreach (explode(",", $menu_details->price) as $key => $menuPrice) {
                    if (Session::get('formatValue')) {
                        if (!empty($price_descArray[$key])) {
                            $priceArray[] = '<h5>' . $price_descArray[$key] . '</h5><span>' . Session::get('currancy_symbol') . " " . number_format(Session::get('formatValue') * $menuPrice, 2, '.', '') . '</span>';
                        } else {
                            $priceArray[] = '<span>' . Session::get('currancy_symbol') . '' . number_format(Session::get('formatValue') * $menuPrice, 2, '.', '') . '</span>';
                        }
                    } else {
                        if (!empty($price_descArray[$key])) {
                            $priceArray[] = '<h5>' . $price_descArray[$key] . '</h5><span>' . $currency_icon . "" . number_format($menuPrice, 2, '.', '') . '</span>';
                        } else {
                            $priceArray[] = '<span>' . $currency_icon . '' . number_format($menuPrice, 2, '.', '') . '</span>';
                        }
                    }
                }
            }
            $menu_details->price = implode(",", $priceArray);
        }
        $parent_categories = array();
        $main_categories = array();
        $sub_categories = array();
        $fav_restaurant = 0;
        // Restaurant Details
        if (!empty($restaurant_details)) {
            // Get Parent Categories
            if (!empty($restaurant_details->parent_category_detail)) {
                $parent_categories = $restaurant_details->parent_category_detail;
            }
            // Get Main Categories
            if (!empty($restaurant_details->time_zone_detail)) {
                $timeZone = $restaurant_details->time_zone_detail->time_zone;
                if (!empty($restaurant_details->main_category_detail)) {
                    foreach ($restaurant_details->main_category_detail as $main_category_detail) {
                        if ($main_category_detail->display_type == 2) {
                            $mytime = Carbon::now($timeZone);
                            $today_date = $mytime->toRfc850String();
                            $current_day = substr($today_date, 0, strrpos($today_date, ","));
                            $daysArray = explode(",", $main_category_detail->day);
                            if (in_array("All", $daysArray)) {
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            }
                            if (in_array($current_day, $daysArray)) {
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            }
                        } else {
                            $main_categories[] = $main_category_detail;
                        }
                    }
                }
            }
            // Get Sub Categories
            if (!empty($restaurant_details->sub_category_detail)) {
                $sub_categories = $restaurant_details->sub_category_detail;
            }
            if (!empty(Auth::User()->id)) {
                $user_id = Auth::User()->id;
                $fav_restaurant = FavRestaurant::where('user_id', $user_id)->where('restaurant_id', $restaurant_details->restaurant_id)->count();
            }
        }
        $menu_link = url()->current();
        $socialShare = \Share::page('https://projectdemo.app:8443/Mila_Menu_Admin/public/menu-details/33')->facebook()->twitter()->reddit()->linkedin()->whatsapp()->telegram();
		

		
        $item_name = isset($menuDetails->name)  ? $menuDetails->name : '';
        $restaurant_name = isset($restaurant_details->restaurant_name) ? $restaurant_details->restaurant_name : '';
        $meta_title = 'You have to try this! - ' . $item_name . ' - ' . $restaurant_name . ' - Mela Menu';
        $meta_image = url('/') . '/' . config('images.menu_url') . $restaurant_details->restaurant_id . '/' . $menuDetails->menu_image;


        return view('user_app/menu_details', ['meta_title' => $meta_title, 'meta_image' => $meta_image, 'parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'menu_details' => $menuDetails, 'currency_icon' => $currency_icon, 'chef_questions' => $chef_questions_array, 'tag_details' => $tag_details, 'user_menu_votes' => $user_menu_votes, 'menu_fav_count' => $menu_fav_count, 'allergie_details' => $allergie_details, 'fav_restaurant' => $fav_restaurant, 'socialShare' => $socialShare]);
    }
    // get Menus by tag
    public function get_menus_by_tag(Request $request)
    {
        $restaurant_id      = $request->restaurant_id;
        $currency_icon      = $request->currency_icon;
        $tag_id             = $request->tag_id;
        $parent_category_id = $request->parent_category_id;
        $main_category_id   = $request->main_category_id;
        $sub_category_id    = $request->sub_category_id;
        //Get Menu Items
        $menu_detail = MenuModel::select('*');
        if (!empty($restaurant_id)) {
            $menu_detail->where('restaurant_id', $restaurant_id);
        }
        if (!empty($parent_category_id)) {
            $menu_detail->where('parent_category', $parent_category_id);
        }
        if (!empty($main_category_id)) {
            $menu_detail->where('main_category', $main_category_id);
        }
        if (!empty($sub_category_id)) {
            $menu_detail->where('sub_category', $sub_category_id);
        }
        $tag_ids = [];
        if (!empty($tag_id) && $tag_id != "0") {
            $tag_ids = explode(",", $tag_id);
            $i = 0;
            foreach ($tag_ids as $key => $value) {
                if ($value != 0) {
                    if ($i == 0) {
                        $menu_detail->whereRaw("find_in_set('" . $value . "',tag_id)");
                    } else {
                        $menu_detail->orwhereRaw("find_in_set('" . $value . "',tag_id)");
                    }
                }
                $i++;
            }
        }
        if (in_array("0", $tag_ids) || $tag_id == "0") {
            $menu_detail->where('total_like','>', 0)->orderBy('total_like', 'desc');
        }
        $menu_details = $menu_detail->where('availiblity', '!=', '2')->get();
        //echo "<pre>"; print_r($menu_details);echo "</pre>"; exit();
        if ($menu_details) {
            $return_array = [];
            if (count($menu_details) > '0') {
                foreach ($menu_details as $key => $value) {
                    if ($value->availiblity !== '2') {
                        if ($value->main_category == $main_category_id) {
                            $menu_like_icon = '<i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>';
                            $menu_unlike_icon = '<i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>';
                            $menu_fav_icon = '<i class="fa fa-heart-o" aria-hidden="true" ></i>';
                            $value->allergy_tag = 0;
                            $value->fav_tag = 0;
                            if (Auth::user() !== NULL) {
                                $user_id = Auth::user()->id;
                                if ($user_id != "") {
                                    $user_menu_votes = MenuVote::where('menu_id', $value->menu_id)->where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->first();
                                    if (!empty($user_menu_votes)) {
                                        $user_menu_vote = $user_menu_votes->vote;
                                        if ($user_menu_vote == "1") {
                                            $menu_like_icon = '<i class="fa fa-thumbs-up thumbs_icon" aria-hidden="true"></i>';
                                        } else if ($user_menu_vote == "0") {
                                            $menu_unlike_icon = '<i class="fa fa-thumbs-down thumbs_down_icon" aria-hidden="true"></i>';
                                        }
                                    }
                                    $user_menu_fav = FavMenu::where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->where('menu_id', $value->menu_id)->first();
                                    if (!empty($user_menu_fav)) {
                                        $menu_fav_icon = '<i class="fa fa-heart" aria-hidden="true" ></i>';
                                    }
                                    if (!empty($value->allergies)) {
                                        $user_allergy = MyAllergyModel::whereIn('allergy_id', explode(',', $value->allergies))->where('user_id', $user_id)->count();
                                        if (!empty($user_allergy) && $user_allergy > 0) {
                                            $value->allergy_tag = 1;
                                        }
                                    }
                                    $user_allergies = MyAllergyModel::where('user_id', $user_id)->get();
                                    if (!empty($user_allergies)) {
                                        foreach ($user_allergies as $Userallergy) {
                                            if (!empty($Userallergy->allergy_name)) {
                                                $get_menu_name = MenuModel::where('menu_id', $value->menu_id)->where('restaurant_id', $restaurant_id)->where('name', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                                $get_menu_desciption = MenuModel::where('menu_id', $value->menu_id)->where('restaurant_id', $restaurant_id)->where('description', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                                $get_menu_ingredients = MenuModel::where('menu_id', $value->menu_id)->where('restaurant_id', $restaurant_id)->where('ingredients', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                                if (!empty($get_menu_name) && $get_menu_name > 0 || !empty($get_menu_desciption) && $get_menu_desciption > 0 || !empty($get_menu_ingredients) && $get_menu_ingredients > 0) {
                                                    $value->allergy_tag = 1;
                                                }
                                            }
                                        }
                                    }
                                    if (!empty($value->tag_id)) {
                                        $user_fav_tag = MyTagModel::whereIn('tag_id', explode(',', $value->tag_id))->where('user_id', $user_id)->count();
                                        if (!empty($user_fav_tag) && $user_fav_tag > 0) {
                                            $value->fav_tag = 1;
                                        }
                                    }
                                }
                            }
                            if ($value->tag_id != "") {
                                $tag_details = TagModel::whereIn('tag_id', explode(',', $value->tag_id))->get();
                                if (!empty($tag_details)) {
                                    $tag_icons = [];
                                    $tmp_tag_icons = [];
                                    foreach ($tag_details as $key => $value1) {
                                        if (!in_array($value1->tag_icon, $tmp_tag_icons)) {
                                            $tag_icons[] = $value1->tag_icon;
                                            $tmp_tag_icons[] = $value1->tag_icon;
                                        }
                                    }
                                } else {
                                    $tag_icons = [];
                                }
                            } else {
                                $tag_icons = [];
                            }
                            if (!empty($value->price)) {
                                $PriceArray = explode(",", $value->price);
                                if (Session::get('formatValue')) {
                                    $value->price = Session::get('currancy_symbol') . "" . number_format(Session::get('formatValue') * $PriceArray[0], 2, '.', '');
                                } else {
                                    $value->price = $currency_icon . "" . number_format($PriceArray[0], 2, '.', '');
                                }
                            } else {
                                $value->price = $currency_icon . " 00";
                            }
                            $return_array[] = array(
                                'menu_id'       => $value->menu_id,
                                'menu_image'    => $value->menu_image,
                                'menu_sub_category'    => $value->sub_category,
                                'name'          => $value->name,
                                'menu_like_icon'   => $menu_like_icon,
                                'menu_unlike_icon' => $menu_unlike_icon,
                                'menu_fav_icon'    => $menu_fav_icon,
                                'price'         => $value->price,
                                'total_like'    => $value->total_like,
                                'total_dislike' => $value->total_dislike,
                                'tag_id'        => $tag_icons,
                                'description'   => $value->description,
                                'availiblity'   => $value->availiblity,
                                'allergy_tag'   => $value->allergy_tag,
                                'fav_tag'       => $value->fav_tag,
                                'menu_click_count'  => $value->menu_click_count,
                            );
                        }
                    }
                }
            } else {
                $return_array = [];
            }
            return response()->json(['success' => $return_array]);
        } else {
            return response()->json(['error' => 'No data found']);
        }
    }
    // Login Page
    public function showLogin($restaurant_id)
    {
        $restaurant_details = array();
        $restaurant_details = array();
        $parent_categories = array();
        $main_categories = array();
        $sub_categories = array();
        // Restaurant Details
        $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('parent_category_detail', 'main_category_detail', 'sub_category_detail', 'currency_detail', 'get_app_theme_font_type_1', 'get_app_theme_font_type_2', 'get_app_theme_font_type_3', 'get_app_theme_font_type_4', 'texture_detail')->first();
        if (!empty($restaurant_details)) {
            // Get Parent Categories
            if (!empty($restaurant_details->parent_category_detail)) {
                $parent_categories = $restaurant_details->parent_category_detail;
            }
            // Get Main Categories
            if (!empty($restaurant_details->time_zone_detail)) {
                $timeZone = $restaurant_details->time_zone_detail->time_zone;
                if (!empty($restaurant_details->main_category_detail)) {
                    foreach ($restaurant_details->main_category_detail as $main_category_detail) {
                        if ($main_category_detail->display_type == 2) {
                            $mytime = Carbon::now($timeZone);
                            $today_date = $mytime->toRfc850String();
                            $current_day = substr($today_date, 0, strrpos($today_date, ","));
                            $daysArray = explode(",", $main_category_detail->day);
                            if (in_array("All", $daysArray)) {
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            }
                            if (in_array($current_day, $daysArray)) {
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            }
                        } else {
                            $main_categories[] = $main_category_detail;
                        }
                    }
                }
            }
            // Get Sub Categories
            if (!empty($restaurant_details->sub_category_detail)) {
                $sub_categories = $restaurant_details->sub_category_detail;
            }
            session()->put('restaurant_id', $restaurant_id);
            session()->save();
        }
        return view('user_app/user_login', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details]);
    }
    // Show Register Form
    public function showRegister($restaurant_id)
    {
        $restaurant_details = array();
        $parent_categories = array();
        $main_categories = array();
        $sub_categories = array();
        $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('parent_category_detail', 'main_category_detail', 'sub_category_detail', 'currency_detail', 'get_app_theme_font_type_1', 'get_app_theme_font_type_2', 'get_app_theme_font_type_3', 'get_app_theme_font_type_4', 'texture_detail')->first();
        if (!empty($restaurant_details)) {
            // Get Parent Categories
            if (!empty($restaurant_details->parent_category_detail)) {
                $parent_categories = $restaurant_details->parent_category_detail;
            }
            // Get Main Categories
            if (!empty($restaurant_details->time_zone_detail)) {
                $timeZone = $restaurant_details->time_zone_detail->time_zone;
                if (!empty($restaurant_details->main_category_detail)) {
                    foreach ($restaurant_details->main_category_detail as $main_category_detail) {
                        if ($main_category_detail->display_type == 2) {
                            $mytime = Carbon::now($timeZone);
                            $today_date = $mytime->toRfc850String();
                            $current_day = substr($today_date, 0, strrpos($today_date, ","));
                            $daysArray = explode(",", $main_category_detail->day);
                            if (in_array("All", $daysArray)) {
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            }
                            if (in_array($current_day, $daysArray)) {
                                $current_time = $mytime->format('H:i');
                                $start_time = date("H:i", strtotime($main_category_detail->start_time));
                                $end_time = date("H:i", strtotime($main_category_detail->end_time));
                                if ($current_time >= $start_time && $current_time < $end_time) {
                                    $main_categories[] = $main_category_detail;
                                }
                            }
                        } else {
                            $main_categories[] = $main_category_detail;
                        }
                    }
                }
            }
            // Get Sub Categories
            if (!empty($restaurant_details->sub_category_detail)) {
                $sub_categories = $restaurant_details->sub_category_detail;
            }
        }
        return view('user_app/user_signup', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details]);
    }
    // Add User
    public function doRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'      => 'required',
            'last_name'       => 'required',
            'email'           => 'required|email|unique:users,email',
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
        if ($validator->passes()) {
            // Create User
            $create_user = array(
                'first_name'      => $request->first_name,
                'last_name'       => $request->last_name,
                'email'           => $request->email,
                'gender'          => $request->gender,
                'date_of_birth'   => \Carbon\Carbon::parse($request->date_of_birth)->format('Y/m/d'),
                'password'        => Hash::make($request->password),
                'user_type'       => '2',
                'created_at'      => date('Y-m-d H:i:s')
            );
            // Add user
            $user = new UserModel();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->date_of_birth = \Carbon\Carbon::parse($request->date_of_birth)->format('Y/m/d');
            $user->password = Hash::make($request->password);
            $user->user_type = '2';
            $user->created_at =  date('Y-m-d H:i:s');
            $user->save();
            Auth::loginUsingId($user->id);
            // Send mail to user
            $to_name  = $request->first_name . " " . $request->last_name;
            $to_email = $request->email;
            $data = array(
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
            );
            //Send email to restaurant owner
            Mail::send('email.app_user_registartion', ["data" => $data], function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject('Mela Menus - User Created');
                $message->from('info@melamenus.com', 'Mela Menus');
            });
            $user_row_added = 1;
            if ($user_row_added) {
                $redirect_url = url('/') . '/profile/' . Auth::user()->id;
                return response()->json(['redirect_url' => $redirect_url, 'success' => 'User data added successfully']);
            } else {
                return response()->json(['errors' => 'Error while adding data']);
            }
        }
        return response()->json(['error' => $validator->errors()]);
    }
    // Like Menu item
    public function like_menu_item(Request $request)
    {
        $menu_id = $request->menu_id;
        $this->middleware('auth');
        if (Auth::user() === NULL) {
            return response()->json(['login_error' => 'User Not logged in.']);
        } else {
            $row_updated = 0;
            $data_updated = 0;
            $user_id = Auth::user()->id;
            // Get Menu details
            $menu_details = MenuModel::find($menu_id);
            $restaurant_id         = $menu_details->restaurant_id;
            $current_total_like    = $menu_details->total_like;
            $current_total_dislike = $menu_details->total_dislike;
            // Update menu like/unlike status
            $current_menu_vote = MenuVote::where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->where('menu_id', $menu_id)->first();
            if (!empty($current_menu_vote)) {
                $user_current_vote_id = $current_menu_vote->menu_vote_id;
                $user_current_vote = $current_menu_vote->vote;
                if ($user_current_vote != "1") {
                    $menu_vote = MenuVote::where('menu_vote_id', $user_current_vote_id)->first();
                    $menu_vote->vote = '1';
                    $menu_vote->updated_at = date('Y-m-d H:i:s');
                    $row_updated = $menu_vote->save();
                } else {
                }
            } else {
                $menu_vote = new MenuVote();
                $menu_vote->restaurant_id = $restaurant_id;
                $menu_vote->menu_id = $menu_id;
                $menu_vote->user_id       = $user_id;
                $menu_vote->vote        = '1';
                $menu_vote->created_at   = date('Y-m-d H:i:s');
                $row_updated = $menu_vote->save();
            }
            if ($row_updated) {
                // Update Menu total like/dislike
                if ($current_total_dislike > 0) {
                    $current_total_dislike = $current_total_dislike - 1;
                }
                $menu_update = MenuModel::where('menu_id', $menu_id)->first();
                $menu_update->total_like   = $current_total_like + 1;
                $menu_update->total_dislike = $current_total_dislike;
                $menu_update->updated_at    = date('Y-m-d H:i:s');
                $data_updated = $menu_update->save();
            }
            if ($data_updated) {
                // update menu click count
                $menu_click_count = MenuModel::where('menu_id', $menu_id)->first();
                $menu_click_count->menu_click_count   = $menu_click_count->menu_click_count + 1;
                $menu_click_count->save();
                return response()->json(['success' => 'Data Updated successfully']);
            } else {
                return response()->json(['error' => 'Error While Updateing data.']);
            }
        }
    }
    // DisLike Menu item
    public function dislike_menu_item(Request $request)
    {
        $menu_id = $request->menu_id;
        $this->middleware('auth');
        if (Auth::user() === NULL) {
            return response()->json(['login_error' => 'User Not logged in.']);
        } else {
            $rows_updated = 0;
            $data_updated = 0;
            $user_id = Auth::user()->id;
            // Get Menu details
            $menu_details = MenuModel::find($menu_id);
            $restaurant_id         = $menu_details->restaurant_id;
            $current_total_like    = $menu_details->total_like;
            $current_total_dislike = $menu_details->total_dislike;
            // Update menu like/unlike status
            $current_menu_vote = MenuVote::where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->where('menu_id', $menu_id)->first();
            if (!empty($current_menu_vote)) {
                $user_current_vote_id = $current_menu_vote->menu_vote_id;
                $user_current_vote = $current_menu_vote->vote;
                if ($user_current_vote != "0") {
                    $menu_vote = MenuVote::where('menu_vote_id', $user_current_vote_id)->first();
                    $menu_vote->vote = '0';
                    $menu_vote->updated_at = date('Y-m-d H:i:s');
                    $rows_updated = $menu_vote->save();
                }
            } else {
                $menu_vote = new MenuVote();
                $menu_vote->restaurant_id = $restaurant_id;
                $menu_vote->menu_id = $menu_id;
                $menu_vote->user_id       = $user_id;
                $menu_vote->vote        = '0';
                $menu_vote->created_at   = date('Y-m-d H:i:s');
                $rows_updated = $menu_vote->save();
            }
            if ($rows_updated) {
                // Update Menu total like/dislike
                if ($current_total_like > 0) {
                    $current_total_like = $current_total_like - 1;
                }
                $menu_update = MenuModel::where('menu_id', $menu_id)->first();
                $menu_update->total_like   = $current_total_like;
                $menu_update->total_dislike = $current_total_dislike + 1;
                $menu_update->updated_at    = date('Y-m-d H:i:s');
                $data_updated = $menu_update->save();
            }
            if ($data_updated) {
                // update menu click count
                $menu_click_count = MenuModel::where('menu_id', $menu_id)->first();
                $menu_click_count->menu_click_count   = $menu_click_count->menu_click_count + 1;
                $menu_click_count->save();
                return response()->json(['success' => 'Data Updated successfully']);
            } else {
                return response()->json(['error' => 'Error While Updateing data.']);
            }
        }
    }
    // Favourite & UnFavouirte Menu
    public function fav_menu_item(Request $request)
    {
        $menu_id = $request->menu_id;
        $menu_fav_count = 0;
        $this->middleware('auth');
        if (Auth::user() === NULL) {
            return response()->json(['login_error' => 'User Not logged in.']);
        } else {
            $row_updated = 0;
            $user_id = Auth::user()->id;
            // Get Menu details
            $menu_details = MenuModel::find($menu_id);
            $restaurant_id         = $menu_details->restaurant_id;
            // Update menu like/unlike status
            $current_menu_fav = FavMenu::where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->where('menu_id', $menu_id)->first();
            if (!empty($current_menu_fav)) {
                $row_updated = $current_menu_fav->delete();
            } else {
                $menu_fav = new FavMenu();
                $menu_fav->restaurant_id = $restaurant_id;
                $menu_fav->menu_id = $menu_id;
                $menu_fav->user_id = $user_id;
                $menu_fav->created_at = date('Y-m-d H:i:s');
                $row_updated = $menu_fav->save();
            }
            // update menu click count
            $menu_details->menu_click_count   = $menu_details->menu_click_count + 1;
            $menu_details->save();
            if ($row_updated) {
                $menu_fav_count = FavMenu::where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->where('menu_id', $menu_id)->count();
                return response()->json(['success' => $menu_fav_count]);
            } else {
                return response()->json(['error' => 'Error While Updateing data.']);
            }
        }
    }
    // Favourite & UnFavouirte Restaurant
    public function fav_restaurant(Request $request)
    {
        $restaurant_id = $request->restaurant_id;
        $this->middleware('auth');
        if (Auth::user() === NULL) {
            return response()->json(['login_error' => 'User Not logged in.']);
        } else {
            $row_updated = 0;
            $user_id = Auth::user()->id;
            // Update menu like/unlike status
            $current_fav = FavRestaurant::where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->first();
            // echo '<pre>'; print_r($current_fav); echo "</pre>"; exit();
            if (!empty($current_fav)) {
                $row_updated = $current_fav->delete();
            } else {
                $menu_res = new FavRestaurant();
                $menu_res->restaurant_id = $restaurant_id;
                $menu_res->user_id = $user_id;
                $menu_res->created_at = date('Y-m-d H:i:s');
                $row_updated = $menu_res->save();
            }
            if ($row_updated) {
                $menu_fav_count = FavMenu::where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->count();
                return response()->json(['success' => $menu_fav_count]);
            } else {
                return response()->json(['error' => 'Error While Updateing data.']);
            }
        }
    }
    // Review Menu item
    public function review_menu_item(Request $request)
    {
        $menu_id       = $request->menu_id;
        $restaurant_id = $request->restaurant_id;
        $this->middleware('auth');
        if (Auth::user() === NULL) {
            return response()->json(['login_error' => 'User Not logged in.']);
        } else {
            $user_id = Auth::user()->id;
            $validator = Validator::make($request->all(), [
                'name'    => 'required',
                'email'   => 'required',
                'comment' => 'required',
            ]);
            if ($validator->passes()) {
                // Update menu like/unlike status
                $current_user_menu_review = MenuVote::where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->where('menu_id', $menu_id)->first();
                if (!empty($current_user_menu_review)) {
                    $menu_review_id = $current_user_menu_review->menu_vote_id;
                    // Update Menu Review details
                    $menu_vote = MenuVote::where('menu_vote_id', $menu_review_id)->first();
                    $menu_vote->review = $request->comment;
                    $menu_vote->name   = $request->name;
                    $menu_vote->email  = $request->email;
                    $menu_vote->updated_at = date('Y-m-d H:i:s');
                    $rows_updated = $menu_vote->save();
                } else {
                    // Add New Menu Review
                    // $insert_data = array(
                    //     'restaurant_id' => $restaurant_id,
                    //     'menu_id'       => $menu_id,
                    //     'user_id'       => $user_id,
                    //     'review'        => $request->comment,
                    //     'name'          => $request->name,
                    //     'email'         => $request->email,
                    //     'created_at'    => date('Y-m-d H:i:s')
                    // );
                    $menu_vote = new MenuVote();
                    $menu_vote->restaurant_id = $restaurant_id;
                    $menu_vote->menu_id = $menu_id;
                    $menu_vote->user_id       = $user_id;
                    $menu_vote->name        = $request->name;
                    $menu_vote->email        = $request->email;
                    $menu_vote->created_at   = date('Y-m-d H:i:s');
                    $rows_updated = $menu_vote->save();
                }
                if ($rows_updated) {
                    return response()->json(['success' => 'Data Added successfully']);
                } else {
                    return response()->json(['error' => 'Error While adding data.']);
                }
            }
            return response()->json(['error' => $validator->errors()]);
        }
    }
    // get Menus by Parent Category
    public function get_menus_by_parent_category(Request $request)
    {
        //echo "<pre>"; print_r($request->all()); echo "</pre>";
        // exit();
        $restaurant_id      = $request->restaurant_id;
        $currency_icon      = $request->currency_icon;
        $parent_category_id = $request->parent_category_id;
        $main_category_id   = $request->main_category_id;
        if (!empty($main_category_id) || !empty($request->in_main_categories)) {
            $menu_detail = MenuModel::select('*');
            if (!empty($restaurant_id)) {
                $menu_detail->where('restaurant_id', $restaurant_id);
            }
            if (!empty($parent_category_id)) {
                $menu_detail->where('parent_category', $parent_category_id);
                if (empty($main_category_id)) {
                    if (!empty($request->in_main_categories)) {
                        foreach (explode(",", $request->in_main_categories) as $key => $cat_id) {
                            if ($key == 0) {
                                $menu_detail->where('main_category', $cat_id);
                            } else {
                                $menu_detail->orWhere('main_category', $cat_id);
                            }
                        }
                    }
                }
            }
            if (!empty($main_category_id)) {
                $menu_detail->where('main_category', $main_category_id);
            }
            $menu_details = $menu_detail->where('availiblity', '!=', '2')->orderBy('order_display', 'ASC')->get();
        } else {
            $menu_details = '';
        }
		$old_cat = '';
		$display = '';
        // echo "<pre>";print_r($menu_details); echo "</pre>"; exit();
        if (!empty($menu_details)) {
            $return_array = [];
            if (count($menu_details) > '0') {
                foreach ($menu_details as $key => $value) {
                    $menu_like_icon = '<i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>';
                    $menu_unlike_icon = '<i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>';
                    $menu_fav_icon = '<i class="fa fa-heart-o" aria-hidden="true" ></i>';
                    $value->fav_tag = 0;
                    if (Auth::user() !== NULL) {
                        $user_id = Auth::user()->id;
                        if ($user_id != "") {
                            $user_menu_votes = MenuVote::where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->where('menu_id', $value->menu_id)->first();
                            if (!empty($user_menu_votes)) {
                                $user_menu_vote = $user_menu_votes->vote;
                                if ($user_menu_vote == "1") {
                                    $menu_like_icon = '<i class="fa fa-thumbs-up thumbs_icon" aria-hidden="true"></i>';
                                } else if ($user_menu_vote == "0") {
                                    $menu_unlike_icon = '<i class="fa fa-thumbs-down thumbs_down_icon" aria-hidden="true"></i>';
                                }
                            }
                            $user_menu_fav = FavMenu::where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->where('menu_id', $value->menu_id)->first();
                            if (!empty($user_menu_fav)) {
                                $menu_fav_icon = '<i class="fa fa-heart" aria-hidden="true" ></i>';
                            }
                            if (!empty($value->allergies)) {
                                $user_allergy = MyAllergyModel::whereIn('allergy_id', explode(',', $value->allergies))->where('user_id', $user_id)->count();
                                if (!empty($user_allergy) && $user_allergy > 0) {
                                    $value->allergy_tag = 1;
                                }
                            }
                            $user_allergies = MyAllergyModel::where('user_id', $user_id)->get();
                            if (!empty($user_allergies)) {
                                foreach ($user_allergies as $Userallergy) {
                                    if (!empty($Userallergy->allergy_name)) {
                                        $get_menu_name = MenuModel::where('menu_id', $value->menu_id)->where('restaurant_id', $restaurant_id)->where('name', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                        $get_menu_desciption = MenuModel::where('menu_id', $value->menu_id)->where('restaurant_id', $restaurant_id)->where('description', 'LIKE', $Userallergy->allergy_name . "%")->count();
                                        $get_menu_ingredients = MenuModel::where('menu_id', $value->menu_id)->where('restaurant_id', $restaurant_id)->where('ingredients', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                        if (!empty($get_menu_name) && $get_menu_name > 0 || !empty($get_menu_desciption) && $get_menu_desciption > 0 || !empty($get_menu_ingredients) && $get_menu_ingredients > 0) {
                                            $value->allergy_tag = 1;
                                        }
                                    }
                                }
                            }
                            if (!empty($value->tag_id)) {
                                $user_fav_tag = MyTagModel::whereIn('tag_id', explode(',', $value->tag_id))->where('user_id', $user_id)->count();
                                if (!empty($user_fav_tag) && $user_fav_tag > 0) {
                                    $value->fav_tag = 1;
                                }
                            }
                        }
                    }
                    if ($value->tag_id != "") {
                        $tag_details = TagModel::whereIn('tag_id', explode(',', $value->tag_id))->get();
                        if (!empty($tag_details)) {
                            $tag_icons = [];
                            $tmp_tag_icons = [];
                            foreach ($tag_details as $key => $value1) {
                                if (!in_array($value1->tag_icon, $tmp_tag_icons)) {
                                    $tag_icons[] = $value1->tag_icon;
                                    $tmp_tag_icons[] = $value1->tag_icon;
                                }
                            }
                        } else {
                            $tag_icons = [];
                        }
                    } else {
                        $tag_icons = [];
                    }
                    if (!empty($value->price)) {
                        $price_array = explode(",", $value->price);
                        if (Session::get('formatValue')) {
                            $value->price = Session::get('currancy_symbol') . " " . number_format(Session::get('formatValue') * max($price_array), 2, '.', '');
                        } else {
                            $value->price = $currency_icon . " " . number_format(max($price_array), 2, '.', '');
                        }
                    } else {
                        $value->price = $currency_icon . " 00";
                    }
					$mainCat = '';
					$mainCat = CategoryModel::where('category_id', $value->main_category)->first();
					
					if($mainCat->category_name != $old_cat){
						$old_cat = $mainCat->category_name;
						$display = '';
					} else {
						$display = 'display:none;';
					}
					
                    $return_array[] = array(
                        'menu_id'       => $value->menu_id,
                        'menu_image'    => $value->menu_image,
                        'name'          => $value->name,
                        'category'          => $mainCat->category_name,
                        'display'          => $display,
                        'menu_like_icon'   => $menu_like_icon,
                        'menu_unlike_icon' => $menu_unlike_icon,
                        'menu_fav_icon'    => $menu_fav_icon,
                        'price'         => $value->price,
                        'total_like'    => $value->total_like,
                        'total_dislike' => $value->total_dislike,
                        'tag_id'        => $tag_icons,
                        'description'   => $value->description,
                        'availiblity'   => $value->availiblity,
                        'allergy_tag'   => $value->allergy_tag,
                        'fav_tag'       => $value->fav_tag,
                        'menu_click_count'  => $value->menu_click_count,
                    );
                    // $keys = array_column($return_array, 'fav_tag');
                    // array_multisort($keys, SORT_DESC, $return_array);
                }
            } else {
                $return_array = [];
            }
            // echo "<pre>";print_r($return_array); echo "</pre>"; exit();
            return response()->json(['success' => $return_array]);
        } else {
            return response()->json(['error' => 'No data found']);
        }
    }
    // get Top Rated Menus by Parent Category
    public function get_top_rated_menus_by_parent_category(Request $request)
    {
        //echo "<pre>"; print_r($request->all()); echo "</pre>";
        $restaurant_id      = $request->restaurant_id;
        $currency_icon      = $request->currency_icon;
        $parent_category_id = $request->parent_category_id;
        $main_category_id   = $request->main_category_id;
        if (!empty($main_category_id) || !empty($request->in_main_categories)) {
            $menu_detail = MenuModel::select('*');
            if (!empty($restaurant_id)) {
                $menu_detail->where('restaurant_id', $restaurant_id);
            }
            if (!empty($parent_category_id)) {
                $menu_detail->where('parent_category', $parent_category_id);
                if (empty($main_category_id)) {
                    if (!empty($request->in_main_categories)) {
                        foreach (explode(",", $request->in_main_categories) as $key => $cat_id) {
                            if ($key == 0) {
                                $menu_detail->where('main_category', $cat_id);
                            } else {
                                $menu_detail->orWhere('main_category', $cat_id);
                            }
                        }
                    }
                }
            }
            if (!empty($main_category_id)) {
                $menu_detail->where('main_category', $main_category_id);
            }
            $menu_details = $menu_detail->where('total_like','>', 0)->orderBy('total_like', 'desc')->orderBy('order_display', 'ASC')->where('availiblity', '!=', '2')->get();
        } else {
            $menu_details = '';
        }
        if (!empty($menu_details)) {
            $return_array = [];
            if (count($menu_details) > '0') {
                foreach ($menu_details as $key => $value) {
                    if ($value->availiblity !== '2' && $value->total_like > 0) {
                        $menu_like_icon = '<i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>';
                        $menu_unlike_icon = '<i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>';
                        $menu_fav_icon = '<i class="fa fa-heart-o" aria-hidden="true" ></i>';
                        $value->allergy_tag = 0;
                        $value->fav_tag = 0;
                        if (Auth::user() !== NULL) {
                            $user_id = Auth::user()->id;
                            if ($user_id != "") {
                                $user_menu_votes = MenuVote::where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->where('menu_id', $value->menu_id)->first();
                                if (!empty($user_menu_votes)) {
                                    $user_menu_vote = $user_menu_votes->vote;
                                    if ($user_menu_vote == "1") {
                                        $menu_like_icon = '<i class="fa fa-thumbs-up thumbs_icon" aria-hidden="true"></i>';
                                    } else if ($user_menu_vote == "0") {
                                        $menu_unlike_icon = '<i class="fa fa-thumbs-down thumbs_down_icon" aria-hidden="true"></i>';
                                    }
                                }
                                $user_menu_fav = FavMenu::where('restaurant_id', $restaurant_id)->where('user_id', $user_id)->where('menu_id', $value->menu_id)->first();
                                if (!empty($user_menu_fav)) {
                                    $menu_fav_icon = '<i class="fa fa-heart" aria-hidden="true" ></i>';
                                }
                                if (!empty($value->allergies)) {
                                    $user_allergy = MyAllergyModel::whereIn('allergy_id', explode(',', $value->allergies))->where('user_id', $user_id)->count();
                                    if (!empty($user_allergy) && $user_allergy > 0) {
                                        $value->allergy_tag = 1;
                                    }
                                }
                                $user_allergies = MyAllergyModel::where('user_id', $user_id)->get();
                                if (!empty($user_allergies)) {
                                    foreach ($user_allergies as $Userallergy) {
                                        if (!empty($Userallergy->allergy_name)) {
                                            $get_menu_name = MenuModel::where('menu_id', $value->menu_id)->where('restaurant_id', $restaurant_id)->where('name', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                            $get_menu_desciption = MenuModel::where('menu_id', $value->menu_id)->where('restaurant_id', $restaurant_id)->where('description', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                            $get_menu_ingredients = MenuModel::where('menu_id', $value->menu_id)->where('restaurant_id', $restaurant_id)->where('ingredients', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                            if (!empty($get_menu_name) && $get_menu_name > 0 || !empty($get_menu_desciption) && $get_menu_desciption > 0 || !empty($get_menu_ingredients) && $get_menu_ingredients > 0) {
                                                $value->allergy_tag = 1;
                                            }
                                        }
                                    }
                                }
                                if (!empty($value->tag_id)) {
                                    $user_fav_tag = MyTagModel::whereIn('tag_id', explode(',', $value->tag_id))->where('user_id', $user_id)->count();
                                    if (!empty($user_fav_tag) && $user_fav_tag > 0) {
                                        $value->fav_tag = 1;
                                    }
                                }
                            }
                        }
                        if ($value->tag_id != "") {
                            $tag_details = TagModel::whereIn('tag_id', explode(',', $value->tag_id))->get();
                            if (!empty($tag_details)) {
                                $tag_icons = [];
                                $tmp_tag_icons = [];
                                foreach ($tag_details as $key => $value1) {
                                    if (!in_array($value1->tag_icon, $tmp_tag_icons)) {
                                        $tag_icons[] = $value1->tag_icon;
                                        $tmp_tag_icons[] = $value1->tag_icon;
                                    }
                                }
                            } else {
                                $tag_icons = [];
                            }
                        } else {
                            $tag_icons = [];
                        }
                        if (!empty($value->price)) {
                            $price_array = explode(",", $value->price);
                            if (Session::get('formatValue')) {
                                $value->price = Session::get('currancy_symbol') . " " . number_format(Session::get('formatValue') * max($price_array), 2, '.', '');
                            } else {
                                $value->price = $currency_icon . " " . number_format(max($price_array), 2, '.', '');
                            }
                        } else {
                            $value->price = $currency_icon . " 00";
                        }
                        $return_array[] = array(
                            'menu_id'       => $value->menu_id,
                            'menu_image'    => $value->menu_image,
                            'name'          => $value->name,
                            'menu_like_icon'   => $menu_like_icon,
                            'menu_unlike_icon' => $menu_unlike_icon,
                            'menu_fav_icon'    => $menu_fav_icon,
                            'price'         => $value->price,
                            'total_like'    => $value->total_like,
                            'total_dislike' => $value->total_dislike,
                            'tag_id'        => $tag_icons,
                            'description'   => $value->description,
                            'availiblity'   => $value->availiblity,
                            'allergy_tag'   => $value->allergy_tag,
                            'fav_tag'       => $value->fav_tag,
                            'menu_click_count'  => $value->menu_click_count
                        );
                        // $keys = array_column($return_array, 'fav_tag');
                        // array_multisort($keys, SORT_DESC, $return_array);
                    }
                }
            } else {
                $return_array = [];
            }
            return response()->json(['success' => $return_array]);
        } else {
            return response()->json(['error' => 'No data found']);
        }
    }
    // get Menu tags
    public function get_multiple_tag_details(Request $request)
    {
        $tag_id = $request->tag_id;
        // Get Tag Items
        $tag_details = TagModel::whereIn('tag_id', explode(',', $tag_id))->get();
        if (!empty($tag_details)) {
            return response()->json(['success' => $tag_details]);
        } else {
            return response()->json(['error' => 'No data found']);
        }
    }
    public function profile()
    {
        $parent_categories = array();
        $main_categories = array();
        $sub_categories = array();
        $restaurant_id = session()->get('restaurant_id');
        $restaurant_details = array();
        // Restaurant Details
        $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('parent_category_detail', 'main_category_detail', 'sub_category_detail', 'currency_detail', 'get_app_theme_font_type_1', 'get_app_theme_font_type_2', 'get_app_theme_font_type_3', 'get_app_theme_font_type_4', 'texture_detail')->first();
        // Get Parent Categories
        if (!empty($restaurant_details->parent_category_detail)) {
            $parent_categories = $restaurant_details->parent_category_detail;
        }
        // Get Main Categories
        if (!empty($restaurant_details->time_zone_detail)) {
            $timeZone = $restaurant_details->time_zone_detail->time_zone;
            if (!empty($restaurant_details->main_category_detail)) {
                foreach ($restaurant_details->main_category_detail as $main_category_detail) {
                    if ($main_category_detail->display_type == 2) {
                        $mytime = Carbon::now($timeZone);
                        $today_date = $mytime->toRfc850String();
                        $current_day = substr($today_date, 0, strrpos($today_date, ","));
                        $daysArray = explode(",", $main_category_detail->day);
                        if (in_array("All", $daysArray)) {
                            $current_time = $mytime->format('H:i');
                            $start_time = date("H:i", strtotime($main_category_detail->start_time));
                            $end_time = date("H:i", strtotime($main_category_detail->end_time));
                            if ($current_time >= $start_time && $current_time < $end_time) {
                                $main_categories[] = $main_category_detail;
                            }
                        }
                        if (in_array($current_day, $daysArray)) {
                            $current_time = $mytime->format('H:i');
                            $start_time = date("H:i", strtotime($main_category_detail->start_time));
                            $end_time = date("H:i", strtotime($main_category_detail->end_time));
                            if ($current_time >= $start_time && $current_time < $end_time) {
                                $main_categories[] = $main_category_detail;
                            }
                        }
                    } else {
                        // echo "<pre>1"; print_r($main_category_detail);echo "</pre>"; 
                        $main_categories[] = $main_category_detail;
                    }
                }
            }
        }
        // Get Sub Categories
        if (!empty($restaurant_details->sub_category_detail)) {
            $sub_categories = $restaurant_details->sub_category_detail;
        }
        $currency_icon = "";
        if (!empty($restaurant_details->currency_detail->currency_icon)) {
            $currency_icon = $restaurant_details->currency_detail->currency_icon;
        }
        $fav_menu_array = array();
        $fav_restaurant = 0;
        if (!empty(Auth::User())) {
            $user_id = Auth::User()->id;
            if (!empty($restaurant_id)) {
                $fav_restaurant = FavRestaurant::where('user_id', $user_id)->where('restaurant_id', $restaurant_id)->count();
            }
        }
        return view('user_app/profile', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'fav_menu_array' => $fav_menu_array, 'fav_restaurant' => $fav_restaurant]);
    }
    public function user_profile()
    {
        $parent_categories = array();
        $main_categories = array();
        $sub_categories = array();
        $restaurant_id = session()->get('restaurant_id');
        $restaurant_details = array();
        // Restaurant Details
        $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('parent_category_detail', 'main_category_detail', 'sub_category_detail', 'currency_detail', 'get_app_theme_font_type_1', 'get_app_theme_font_type_2', 'get_app_theme_font_type_3', 'get_app_theme_font_type_4', 'texture_detail')->first();
        // Get Parent Categories
        if (!empty($restaurant_details->parent_category_detail)) {
            $parent_categories = $restaurant_details->parent_category_detail;
        }
        // Get Main Categories
        if (!empty($restaurant_details->time_zone_detail)) {
            $timeZone = $restaurant_details->time_zone_detail->time_zone;
            if (!empty($restaurant_details->main_category_detail)) {
                foreach ($restaurant_details->main_category_detail as $main_category_detail) {
                    if ($main_category_detail->display_type == 2) {
                        $mytime = Carbon::now($timeZone);
                        $today_date = $mytime->toRfc850String();
                        $current_day = substr($today_date, 0, strrpos($today_date, ","));
                        $daysArray = explode(",", $main_category_detail->day);
                        if (in_array("All", $daysArray)) {
                            $current_time = $mytime->format('H:i');
                            $start_time = date("H:i", strtotime($main_category_detail->start_time));
                            $end_time = date("H:i", strtotime($main_category_detail->end_time));
                            if ($current_time >= $start_time && $current_time < $end_time) {
                                $main_categories[] = $main_category_detail;
                            }
                        }
                        if (in_array($current_day, $daysArray)) {
                            $current_time = $mytime->format('H:i');
                            $start_time = date("H:i", strtotime($main_category_detail->start_time));
                            $end_time = date("H:i", strtotime($main_category_detail->end_time));
                            if ($current_time >= $start_time && $current_time < $end_time) {
                                $main_categories[] = $main_category_detail;
                            }
                        }
                    } else {
                        // echo "<pre>1"; print_r($main_category_detail);echo "</pre>"; 
                        $main_categories[] = $main_category_detail;
                    }
                }
            }
        }
        // Get Sub Categories
        if (!empty($restaurant_details->sub_category_detail)) {
            $sub_categories = $restaurant_details->sub_category_detail;
        }
        $currency_icon = "";
        if (!empty($restaurant_details->currency_detail->currency_icon)) {
            $currency_icon = $restaurant_details->currency_detail->currency_icon;
        }
        $user_id = Auth::User()->id;
        $fav_menu_array = array();
        $fav_restaurant = 0;
        if (!empty($restaurant_id)) {
            $fav_menu = FavMenu::where('user_id', $user_id)->with('menu_detail', 'menu_image')->get();
            if (!empty($fav_menu)) {
                foreach ($fav_menu as $favmenu) {
                    $tag_detail_data = TagModel::whereIn('tag_id', explode(',', $favmenu->menu_detail->tag_id))->get();
                    if (!empty($tag_detail_data)) {
                        $favmenu->menu_detail->tag_detail = $tag_detail_data;
                    } else {
                        $favmenu->menu_detail->tag_detail = array();
                    }
                    $menu_image_data = MenuImage::where('menu_id', $favmenu->menu_detail->menu_id)->get();
                    if (!empty($menu_image_data)) {
                        $favmenu->menu_detail->menu_image_detail = $menu_image_data;
                    } else {
                        $favmenu->menu_detail->menu_image_detail = array();
                    }
                    $user_menu_votes = MenuVote::where('menu_id', $favmenu->menu_detail->menu_id)->where('restaurant_id', $favmenu->menu_detail->restaurant_id)->where('user_id', $user_id)->first();
                    if (!empty($user_menu_votes)) {
                        $favmenu->menu_detail->user_menu_votes = $user_menu_votes;
                    }
                    if (!empty($favmenu->menu_detail->price)) {
                        $price_array = explode(",", $favmenu->menu_detail->price);
                        if (Session::get('formatValue')) {
                            $favmenu->menu_detail->price = Session::get('currancy_symbol') . " " . number_format(Session::get('formatValue') * max($price_array), 2, '.', '');
                        } else {
                            $favmenu->menu_detail->price = $currency_icon . " " . number_format(max($price_array), 2, '.', '');
                        }
                    } else {
                        $favmenu->menu_detail->price = $currency_icon . " 00";
                    }
                    $fav_menu_array[] = $favmenu;
                }
            }
            $fav_restaurant = FavRestaurant::where('user_id', $user_id)->where('restaurant_id', $restaurant_id)->count();
        }
        //Start  Allergy page
        $admin_allergy = AllergyModel::all();
        $user_allergy = MyAllergyModel::where('user_id', Auth::User()->id)->with('allergy_detail')->get();
        $user_allergy_id_array = array();
        if (!empty($user_allergy) && count($user_allergy) > 0) {
            foreach ($user_allergy as $userAllergy) {
                if (!empty($userAllergy->allergy_id)) {
                    $user_allergy_id_array[] =  $userAllergy->allergy_id;
                }
            }
        }
        //End Allergy page 
        //Start  Tags page
        $admin_tag = TagModel::all();
        $user_tag = MyTagModel::where('user_id', Auth::User()->id)->with('tag_detail')->get();
        $tag_id_array = array();
        if (!empty($user_tag) && count($user_tag) > 0) {
            foreach ($user_tag as $userTag) {
                if (!empty($userTag->tag_id)) {
                    $tag_id_array[] =  $userTag->tag_id;
                }
            }
        }
        //End Tags page my_tag_name_list
        // Start Favourite Page
        $fav_restaurant_list = array();
        $fav_restaurant_list = FavRestaurant::where('user_id', $user_id)->with('restaurant_detail')->get();
        $fav_menu_list = array();
        $fav_menu_list = FavMenu::where('user_id', $user_id)->with('menu_detail', 'restaurant_detail')->get();
        return view('user_app/user_profile', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'fav_menu_array' => $fav_menu_array, 'fav_restaurant' => $fav_restaurant, 'admin_tag' => $admin_tag, 'user_tag' => $user_tag, 'admin_allergy' => $admin_allergy, 'user_allergy' => $user_allergy, 'tag_id_array' => $tag_id_array, 'user_allergy_id_array' => $user_allergy_id_array, 'fav_restaurant_list' => $fav_restaurant_list, 'fav_menu_list' => $fav_menu_list]);
    }
    public function update_user_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'      => 'required',
            'last_name'       => 'required',
            'email'           => 'required|email',
        ]);
        if ($validator->passes()) {
            // Update User row
            $updateUser = UserModel::where('id', Auth::User()->id)->first();
            $updateUser->first_name = $request->first_name;
            $updateUser->last_name = $request->last_name;
            $updateUser->email    = $request->email;
            $updateUser->gender    = $request->gender;
            $updateUser->date_of_birth = \Carbon\Carbon::parse($request->date_of_birth)->format('Y/m/d');
            $updateUser->updated_at = date('Y-m-d H:i:s');
            $update_user = $updateUser->save();
            if ($update_user) {
                return response()->json(['success' => 'Data Updated successfully']);
            } else {
                return response()->json(['errors' => 'Error while updating data']);
            }
        }
        return response()->json(['error' => $validator->errors()]);
    }
    public function update_allergy_and_tag(Request $request)
    {
        // echo "<pre>"; print_r($request->all()); echo '</pre>'; exit();
        if ($request->type == 'allergy') {
            // if(empty($request->allergy_name) && empty($request->new_allergy_name)){
            //     return response()->json(['required_tag'=>'Atleast one Allergy Required']);
            // }
            if (!empty($request->new_allergy_name)) {
                foreach ($request->new_allergy_name as $new_allergy) {
                    $allergy = AllergyModel::where('allergy_name', ucwords($new_allergy))->first();
                    if (!empty($allergy->allergy_id)) {
                        $new_allergy = $allergy->allergy_id;
                    }
                    if (is_numeric($new_allergy)) {
                        $old_allergy = MyAllergyModel::where('allergy_id', $new_allergy)->where('user_id', Auth::User()->id)->count();
                    } else {
                        $old_allergy = MyAllergyModel::where('allergy_name', ucwords($new_allergy))->where('user_id', Auth::User()->id)->count();
                    }
                    if ($old_allergy == 0) {
                        $my_alergy = new MyAllergyModel();
                        if (is_numeric($new_allergy)) {
                            $my_alergy->allergy_id = $new_allergy;
                        } else {
                            $my_alergy->allergy_name = ucwords($new_allergy);
                        }
                        $my_alergy->user_id = Auth::User()->id;
                        $save_tag = $my_alergy->save();
                    }
                }
            }
            if (!empty($request->remove_allergy_id)) {
                foreach ($request->remove_allergy_id as $remove_allergy_id) {
                    $my_allergy = MyAllergyModel::find($remove_allergy_id)->delete();
                }
            }
            return response()->json(['success' => 'Data Updated successfully']);
        } else {
            // if(empty($request->tag_name) && empty($request->new_tag_name)){
            //     return response()->json(['required_tag'=>'Atleast one Tag Required']);
            // }
            if (!empty($request->new_tag_name)) {
                foreach ($request->new_tag_name as $new_tag) {
                    $tag_detail = TagModel::where('tag_name', ucwords($new_tag))->first();
                    if (!empty($tag_detail->tag_id)) {
                        $new_tag = $tag_detail->tag_id;
                    }
                    if (is_numeric($new_tag)) {
                        $old_tag = MyTagModel::where('tag_id', $new_tag)->where('user_id', Auth::User()->id)->count();
                    } else {
                        $old_tag = MyTagModel::where('tag_name', ucwords($new_tag))->where('user_id', Auth::User()->id)->count();
                    }
                    if ($old_tag == 0) {
                        $my_tag = new MyTagModel();
                        if (is_numeric($new_tag)) {
                            $my_tag->tag_id = $new_tag;
                        } else {
                            $my_tag->tag_name = ucwords($new_tag);
                        }
                        $my_tag->user_id = Auth::User()->id;
                        $save_tag = $my_tag->save();
                    }
                }
            }
            if (!empty($request->remove_tag_id)) {
                foreach ($request->remove_tag_id as $remove_tag_id) {
                    $my_tag = MyTagModel::find($remove_tag_id);
                    if (!empty($my_tag)) {
                        $my_tag->delete();
                    }
                }
            }
            return response()->json(['success' => 'Data Updated successfully']);
        }
    }
    // APP User get Search
    // public static function get_search($restaurant_id){
    //     $parent_categories=array();
    //     $main_categories=array();
    //     $sub_categories=array();
    //     $restaurant_details=array();
    //     if ($restaurant_id != ""){
    //         // Restaurant Details 
    //         $restaurant_details=RestaurantModel::where('restaurant_id',$restaurant_id)->with('parent_category_detail','main_category_detail','sub_category_detail','currency_detail','get_app_theme_font_type_1','get_app_theme_font_type_2','get_app_theme_font_type_3','get_app_theme_font_type_4','country_detail','texture_detail')->first();    
    //         // Get Parent Categories
    //         if(!empty($restaurant_details->parent_category_detail)){
    //             $parent_categories=$restaurant_details->parent_category_detail;
    //         }
    //          // Get Currency icon
    //         if(!empty($restaurant_details->currency_detail)){
    //             $currency_icon=$restaurant_details->currency_detail->currency_icon;
    //         }
    //          // Get Country Detail
    //         // Get Main Categories
    //         if(!empty($restaurant_details->time_zone_detail)){
    //             $timeZone=$restaurant_details->time_zone_detail->time_zone;
    //             if(!empty($restaurant_details->main_category_detail)){
    //                 foreach($restaurant_details->main_category_detail as $main_category_detail){
    //                     if($main_category_detail->display_type == 2){
    //                         $daysArray=explode(",",$main_category_detail->day);
    //                         // echo "<pre>"; print_r($daysArray); echo "</pre>";
    //                         $mytime = Carbon::now($timeZone);
    //                         $today_date=$mytime->toRfc850String();
    //                         $current_day= substr($today_date, 0, strrpos($today_date,","));
    //                         $daysArray=explode(",",$main_category_detail->day);
    //                         if (in_array("All", $daysArray)){
    //                             $current_time=$mytime->format('H:i');
    //                             $start_time=date("H:i", strtotime($main_category_detail->start_time));
    //                             $end_time=date("H:i", strtotime($main_category_detail->end_time));
    //                             if ($current_time >= $start_time && $current_time < $end_time){
    //                                 $main_categories[]=$main_category_detail;
    //                             }
    //                         }
    //                         else if(in_array($current_day, $daysArray)){
    //                             $current_time=$mytime->format('H:i');
    //                             $start_time=date("H:i", strtotime($main_category_detail->start_time));
    //                             $end_time=date("H:i", strtotime($main_category_detail->end_time));
    //                             if ($current_time >= $start_time && $current_time < $end_time){
    //                                 $main_categories[]=$main_category_detail;
    //                             }
    //                         }
    //                     }else{
    //                         $main_categories[]=$main_category_detail;
    //                     } 
    //                 }
    //             }
    //         }
    //         // Get Sub Categories
    //         if(!empty($restaurant_details->sub_category_detail)){
    //             $sub_categories=$restaurant_details->sub_category_detail;
    //         }
    //         $fav_restaurant=0;
    //         // if(!empty(Auth::User()->id)){
    //         //     $user_id=Auth::User()->id;
    //         //     $fav_restaurant=FavRestaurant::where('user_id',$user_id)->where('restaurant_id',$restaurant_id)->count();
    //         // }
    //         // echo "<pre>"; print_r($restaurant_details->time_zone_detail); echo "</pre>"; exit();
    //         return view('user_app/search',['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details,'fav_restaurant'=>$fav_restaurant,'currency_icon'=>$currency_icon]); 
    //     }
    //     else
    //     {
    //         Auth::logout(); // log the user out of our application
    //         return Redirect::to('login'); // redirect the user to the login screen
    //     }
    // }
    public function get_search(Request $request, $restaurant_id)
    {
        // echo "here"; exit(); 
        $restaurant_id = $restaurant_id;

        $search_name = $request->search;
        // session()->put('search_name',$request->search);
        // session()->save();


        $language_list = DB::table('list')->where('id', session('language_id'))->first();
        if (!empty($language_list->short_name)) {
            $translation_language = new GoogleTranslate();
            $translation_language->setSource($language_list->short_name);
            $translation_language->setTarget('en');
            $search_name = $translation_language->translate($request->search);
        }

        //  echo "<pre>"; print_r($search_name); echo "</pre>"; exit();
        // Restaurant Details

        $restaurant_details = array();

        $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('parent_category_detail', 'main_category_detail', 'sub_category_detail', 'currency_detail', 'get_app_theme_font_type_1', 'get_app_theme_font_type_2', 'get_app_theme_font_type_3', 'get_app_theme_font_type_4', 'texture_detail')->first();



        $currency_icon = " ";

        $parent_categories = array();

        $main_categories = array();

        $sub_categories = array();



        $fav_restaurant = 0;

        if (!empty($restaurant_details)) {

            // Get Currency icon

            if (!empty($restaurant_details->currency_detail)) {

                $currency_icon = $restaurant_details->currency_detail->currency_icon;
            }

            if (!empty($restaurant_details->parent_category_detail)) {

                $parent_categories = $restaurant_details->parent_category_detail;
            }

            $valid_main_category_id = array();

            if (!empty($restaurant_details->time_zone_detail)) {

                $timeZone = $restaurant_details->time_zone_detail->time_zone;

                if (!empty($restaurant_details->main_category_detail)) {

                    foreach ($restaurant_details->main_category_detail as $main_category_detail) {

                        if ($main_category_detail->display_type == 2) {

                            $mytime = Carbon::now($timeZone);

                            $today_date = $mytime->toRfc850String();

                            $current_day = substr($today_date, 0, strrpos($today_date, ","));

                            $daysArray = explode(",", $main_category_detail->day);

                            if (in_array("All", $daysArray)) {

                                $current_time = $mytime->format('H:i');

                                $start_time = date("H:i", strtotime($main_category_detail->start_time));

                                $end_time = date("H:i", strtotime($main_category_detail->end_time));

                                if ($current_time >= $start_time && $current_time < $end_time) {

                                    $main_categories[] = $main_category_detail;

                                    $valid_main_category_id[] = $main_category_detail->category_id;
                                }
                            }

                            if (in_array($current_day, $daysArray)) {

                                // if($main_category_detail->day ==$current_day){

                                $current_time = $mytime->format('H:i');

                                $start_time = date("H:i", strtotime($main_category_detail->start_time));

                                $end_time = date("H:i", strtotime($main_category_detail->end_time));

                                if ($current_time >= $start_time && $current_time < $end_time) {

                                    $main_categories[] = $main_category_detail;

                                    $valid_main_category_id[] = $main_category_detail->category_id;
                                }
                            }
                        } else {

                            $valid_main_category_id[] = $main_category_detail->category_id;

                            $main_categories[] = $main_category_detail;
                        }
                    }
                }
            }



            // Get Sub Categories

            if (!empty($restaurant_details->sub_category_detail)) {

                $sub_categories = $restaurant_details->sub_category_detail;
            }

            if (!empty(Auth::User()->id)) {

                $user_id = Auth::User()->id;

                $fav_restaurant = FavRestaurant::where('user_id', $user_id)->where('restaurant_id', $restaurant_id)->count();
            }
        }

        if (!empty($search_name)) {

            $menu_item_detail = MenuModel::where('availiblity', '!=', '2')->where('restaurant_id', $restaurant_id)->where('name', 'LIKE', '%' . $search_name . "%")->whereIn('main_category', $valid_main_category_id)->orderBy('order_display', 'ASC')->get();
        }

        $menu_items = array();

        $category_selected_tag_id = '';

        if (!empty($menu_item_detail)) {

            foreach ($menu_item_detail as $menu_item_value) {



                if (!empty($menu_item_value->tag_id)) {

                    $category_selected_tag_id .= $menu_item_value->tag_id . ',';
                }

                if (!empty($menu_item_value)) {



                    $tag_detail_data = TagModel::whereIn('tag_id', explode(',', $menu_item_value->tag_id))->get();

                    if (!empty($tag_detail_data)) {

                        $menu_item_value->tag_detail = $tag_detail_data;
                    } else {

                        $menu_item_value->tag_detail = array();
                    }
                }

                $user_menu_votes = '';

                $menu_item_value->menu_fav = 0;

                $menu_item_value->user_menu_votes = '';

                $menu_item_value->allergy_tag = 0;

                $menu_item_value->fav_tag = 0;



                if (!empty(Auth::user()->id)) {

                    $user_id = Auth::user()->id;

                    $user_menu_votes = MenuVote::where('menu_id', $menu_item_value->menu_id)->where('restaurant_id', $menu_item_value->restaurant_id)->where('user_id', $user_id)->first();

                    if (!empty($user_menu_votes)) {

                        $menu_item_value->user_menu_votes = $user_menu_votes;
                    }

                    $user_menu_fav = FavMenu::where('menu_id', $menu_item_value->menu_id)->where('restaurant_id', $menu_item_value->restaurant_id)->where('user_id', $user_id)->first();

                    if (!empty($user_menu_fav)) {

                        $menu_item_value->menu_fav = 1;
                    }
                    if (!empty($menu_item_value->allergies)) {
                        $user_allergy = MyAllergyModel::whereIn('allergy_id', explode(',', $menu_item_value->allergies))->where('user_id', $user_id)->count();
                        if (!empty($user_allergy) && $user_allergy > 0) {
                            $menu_item_value->allergy_tag = 1;
                        }
                    }
                    $user_allergies = MyAllergyModel::where('user_id', $user_id)->get();
                    if (!empty($user_allergies)) {
                        foreach ($user_allergies as $Userallergy) {
                            if (!empty($Userallergy->allergy_name)) {
                                $get_menu_name = MenuModel::where('menu_id', $menu_item_value->menu_id)->where('restaurant_id', $restaurant_id)->where('name', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();

                                $get_menu_desciption = MenuModel::where('menu_id', $menu_item_value->menu_id)->where('restaurant_id', $restaurant_id)->where('description', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();

                                $get_menu_ingredients = MenuModel::where('menu_id', $menu_item_value->menu_id)->where('restaurant_id', $restaurant_id)->where('ingredients', 'LIKE', '%' . $Userallergy->allergy_name . "%")->count();
                                if (!empty($get_menu_name) && $get_menu_name > 0 || !empty($get_menu_desciption) && $get_menu_desciption > 0 || !empty($get_menu_ingredients) && $get_menu_ingredients > 0) {
                                    $menu_item_value->allergy_tag = 1;
                                }
                            }
                        }
                    }
                    // exit();
                    if (!empty($menu_item_value->tag_id)) {

                        $user_fav_tag = MyTagModel::whereIn('tag_id', explode(',', $menu_item_value->tag_id))->where('user_id', $user_id)->count();

                        if (!empty($user_fav_tag) && $user_fav_tag > 0) {

                            $menu_item_value->fav_tag = 1;
                        }
                    }
                }



                if (!empty($menu_item_value->price)) {

                    $price_array = explode(",", $menu_item_value->price);

                    if (Session::get('formatValue')) {

                        $menu_item_value->price = Session::get('currancy_symbol') . " " . number_format(Session::get('formatValue') * max($price_array), 2, '.', '');
                    } else {

                        $menu_item_value->price = $currency_icon . " " . number_format(max($price_array), 2, '.', '');
                    }
                } else {

                    $menu_item_value->price = '00';
                }

                $menu_items[] = $menu_item_value;

                // $keys = array_column($menu_items, 'fav_tag');

                // array_multisort($keys, SORT_DESC, $menu_items);

            }
        }

        // echo "<pre>"; print_r($menu_items); echo "</pre>"; exit();

        return view('user_app/search', ['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'menu_items' => $menu_items, 'currency_icon' => $currency_icon, 'fav_restaurant' => $fav_restaurant]);
    }
}
