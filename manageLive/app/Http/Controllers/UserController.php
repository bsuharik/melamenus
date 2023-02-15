<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Item;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Validator;

use Hash;

use Auth;

use Redirect;

use Mail;



use App\Models\CategoryModel;

use App\Models\RestaurantModel;

use App\Models\MenuModel;

use App\Models\TagModel;

use App\Models\UserModel;

use App\Models\CurrencyModel;
use App\Models\TableModel;



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

        if ($restaurant_id != "") 

        {

            if(request()->has('table_no') && request()->has('chair_no')){
                $table_no=request()->table_no;
                $chair_no=request()->chair_no;
                $table=TableModel::where('restaurant_id',$restaurant_id)->where('table_number',$table_no)->first();

                if($chair_no <= $table->chairs){
                    session()->put('table_no',$table_no);
                    session()->put('chair_no',$chair_no);
                }else{
                    session()->put('table_no', '');
                    session()->put('chair_no', '');
                }


                session()->save();
            }
            

            // Get Parent Categories

            $parent_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'0');



            // Get Main Categories

            $main_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'1');



            // Get Sub Categories

            $sub_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'2');



            // Restaurant Details

            $restaurant_details = RestaurantModel::get_one_restaurant_details($restaurant_id);



            return view('user_app/home',['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details]);

        }

        else

        {

            Auth::logout(); // log the user out of our application

            return Redirect::to('login'); // redirect the user to the login screen

        }

    }



    // Main Categories list

    public function main_categories($parent_category)

    {

        $parent_category_details = CategoryModel::get_one_category_row($parent_category);



        $restaurant_id = $parent_category_details->restaurant_id;



        // Get Currency icon

        $currency_icon = CurrencyModel::get_restaurant_currency_icon($restaurant_id); 



        // Restaurant Details

        $restaurant_details = RestaurantModel::get_one_restaurant_details($restaurant_id);



        // Get Main Categories

        $parent_main_categories = CategoryModel::get_restaurant_main_categories($restaurant_id,$parent_category);

        

        // Get Parent Categories

        $parent_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'0');



        // Get Main Categories

        $main_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'1');



        // Get Sub Categories

        $sub_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'2');



        return view('user_app/main_categories',['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'parent_main_categories' => $parent_main_categories, 'parent_category_id' => $parent_category, 'currency_icon' => $currency_icon]);

    }



    // Sub Categories list

    public static function sub_categories($main_category)

    {

        $main_category_details = CategoryModel::get_one_category_row($main_category);



        $restaurant_id   = $main_category_details->restaurant_id;

        $parent_category = $main_category_details->parent_category_id;

        $sub_category    = '';



        // Get Menu Items

        $menu_items = MenuModel::get_menus_by_category($restaurant_id, $parent_category, $main_category, $sub_category);



        // Get Currency icon

        $currency_icon = CurrencyModel::get_restaurant_currency_icon($restaurant_id);



        // Get sub Categories

        $main_sub_categories = CategoryModel::get_restaurant_sub_categories($restaurant_id, $parent_category, $main_category);

        

        // Get Parent Categories

        $parent_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'0');



        // Get Main Categories

        $main_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'1');



        // Get Sub Categories

        $sub_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'2');



        // Get Tags

        $tags_array = TagModel::get_all_tags();



        // Restaurant Details

        $restaurant_details = RestaurantModel::get_one_restaurant_details($restaurant_id);



        return view('user_app/sub_categories',['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'main_sub_categories' => $main_sub_categories, 'menu_items' => $menu_items, 'currency_icon' => $currency_icon, 'tags_array' => $tags_array, 'parent_category_id' => $parent_category, 'main_category_id' => $main_category ]);

    }



    // Menu Item list

    public function menu_items($sub_category)

    {

        $main_sub_categories = [];

        

        $sub_category_details = CategoryModel::get_one_category_row($sub_category);



        $restaurant_id   = $sub_category_details->restaurant_id;

        $parent_category = $sub_category_details->parent_category_id;

        $main_category   = $sub_category_details->main_category_id;



        // Get Menu Items

        $menu_items = MenuModel::get_menus_by_category($restaurant_id, $parent_category, $main_category, $sub_category);



        // Get Currency icon

        $currency_icon = CurrencyModel::get_restaurant_currency_icon($restaurant_id);

        

        // Get Parent Categories

        $parent_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'0');



        // Get Main Categories

        $main_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'1');



        // Get Sub Categories

        $sub_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'2');



        // Get Tags

        $tags_array = TagModel::get_all_tags();



        // Restaurant Details

        $restaurant_details = RestaurantModel::get_one_restaurant_details($restaurant_id);



        return view('user_app/sub_categories',['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'main_sub_categories' => $main_sub_categories, 'menu_items' => $menu_items, 'currency_icon' => $currency_icon, 'tags_array' => $tags_array, 'parent_category_id' => $parent_category, 'main_category_id' => $main_category ]);

    }



    // Menu details

    public function menu_details($menu_id)

    {

        $main_sub_categories = [];



        // Get Menu details

        $menu_details = MenuModel::get_one_menu_details($menu_id);



        $restaurant_id = $menu_details->restaurant_id;



        // Get Currency icon

        $currency_icon = CurrencyModel::get_restaurant_currency_icon($restaurant_id);



        // Get Chef questions

        $chef_questions_array = MenuModel::get_restaurant_menu_chef_questions($restaurant_id,$menu_id);

        

        // Get Parent Categories

        $parent_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'0');



        // Get Main Categories

        $main_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'1');



        // Get Sub Categories

        $sub_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'2');



        // Restaurant Details

        $restaurant_details = RestaurantModel::get_one_restaurant_details($restaurant_id);



        return view('user_app/menu_details',['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'menu_details' => $menu_details, 'currency_icon' => $currency_icon, 'chef_questions' => $chef_questions_array]);

    }



    // get Menus by tag

    public function get_menus_by_tag(Request $request)

    {

        $restaurant_id      = $request->restaurant_id;

        $tag_id             = $request->tag_id;

        $parent_category_id = $request->parent_category_id;

        $main_category_id   = $request->main_category_id;

        $sub_category_id    = $request->sub_category_id;



        // Get Menu Items

        $menu_details = MenuModel::get_menus_by_tag(

                                                        $restaurant_id, 

                                                        $tag_id,

                                                        $parent_category_id,

                                                        $main_category_id,

                                                        $sub_category_id

                                                    );



        if($menu_details)

        {   

            $return_array = [];



            if (count($menu_details) > '0') 

            {

                foreach ($menu_details as $key => $value) 

                {

                    $menu_like_icon = '<i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>';

                    $menu_unlike_icon = '<i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>';



                    if (Auth::user() !== NULL) 

                    {

                        $user_id = Auth::user()->id;



                        if ($user_id != "") 

                        {

                            $user_menu_votes = MenuModel::get_user_menu_vote(

                                                                    $user_id, 

                                                                    $restaurant_id, 

                                                                    $value->menu_id

                                                                );



                            if ($user_menu_votes) 

                            {

                                $user_menu_vote = $user_menu_votes->vote;



                                if ($user_menu_vote == "1") 

                                {

                                    $menu_like_icon = '<i class="fa fa-thumbs-up thumbs_icon" aria-hidden="true"></i>';

                                }

                                else if($user_menu_vote == "0")

                                {

                                    $menu_unlike_icon = '<i class="fa fa-thumbs-down thumbs_down_icon" aria-hidden="true"></i>';

                                }

                            }

                        }

                    } 



                    if ($value->tag_id != "") 

                    {

                        $tag_details = TagModel::get_multiple_tag_details($value->tag_id);



                        if ($tag_details) 

                        {

                            $tag_icons = [];



                            $tmp_tag_icons = [];

                            foreach ($tag_details as $key => $value1) 

                            {

                                if (!in_array($value1->tag_icon, $tmp_tag_icons)) 

                                {

                                    $tag_icons[] = $value1->tag_icon;

                                    $tmp_tag_icons[] = $value1->tag_icon;

                                }

                            }

                        }

                        else

                        {

                            $tag_icons = [];

                        }

                    }

                    else

                    {

                        $tag_icons = [];

                    }



                    $return_array[] = array(

                                            'menu_id'       => $value->menu_id,

                                            'menu_image'    => $value->menu_image,

                                            'name'          => $value->name,

                                            'menu_like_icon'   => $menu_like_icon,

                                            'menu_unlike_icon' => $menu_unlike_icon,

                                            'price'         => $value->price,

                                            'total_like'    => $value->total_like,

                                            'total_dislike' => $value->total_dislike,

                                            'tag_id'        => $tag_icons,

                                            'description'   => $value->description,

                                        );

                }

            }

            else

            {

                $return_array = [];

            }



            return response()->json(['success' => $return_array]);

        }

        else

        {

            return response()->json(['error' => 'No data found']);

        }

    }



    // Login Page

    public function showLogin($restaurant_id)

    {

        // Get Parent Categories

        $parent_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'0');



        // Get Main Categories

        $main_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'1');



        // Get Sub Categories

        $sub_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'2');



        // Restaurant Details

        $restaurant_details = RestaurantModel::get_one_restaurant_details($restaurant_id);



        return view('user_app/user_login',['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details]);

    }



    // Show Register Form

    public function showRegister($restaurant_id)

    {

        // Get Parent Categories

        $parent_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'0');



        // Get Main Categories

        $main_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'1');



        // Get Sub Categories

        $sub_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'2');



        // Restaurant Details

        $restaurant_details = RestaurantModel::get_one_restaurant_details($restaurant_id);



        return view('user_app/user_signup',['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details]);

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

                // 'min:6',

                'confirmed',

                // 'regex:/[a-z]/',

                // 'regex:/[A-Z]/',

                // 'regex:/[0-9]/',

                // 'regex:/[@$!%*#?&]/'

            ],

            'password_confirmation' => 'required',

        ]);

                

            if ($validator->passes()) 

        {

            // Create User

            $create_user = array(

                                    'first_name'      => $request->first_name,

                                    'last_name'       => $request->last_name,

                                    'email'           => $request->email,

                                    'gender'          => $request->gender,

                                    'date_of_birth'   => $request->date_of_birth,

                                    'password'        => Hash::make($request->password),

                                    'user_type'       => '2',

                                    'created_at'      => date('Y-m-d H:i:s')

                                );



            // Add user

            // $user_row_added = UserModel::create_user_details($create_user);

            $user = new UserModel();

            $user->first_name = $request->first_name;

            $user->last_name = $request->last_name;

            $user->email = $request->email;

            $user->gender = $request->gender;

            $user->date_of_birth = \Carbon\Carbon::parse($request->date_of_birth)->format('Y/m/d');

            $user->password = Hash::make($request->password);

            $user->user_type = '2';

            $user->created_at =  date('Y-m-d H:i:s');

            



            // Send mail to user

            $to_name  = $request->first_name." ".$request->last_name;

            $to_email = $request->email;



            $data = array(

                            'first_name' => $request->first_name,

                            'last_name'  => $request->last_name,

                        );



            // Send email to restaurant owner

            Mail::send('email.app_user_registartion', ["data"=>$data] , function($message) use ($to_name, $to_email){

                $message->to($to_email, $to_name)->subject('Mela Menus - User Created');

                $message->from('info@melamenus.com','Mela Menus');

            });

            $user->save();

            Auth::loginUsingId($user->id);



            if(!empty($user->id))

            {

                return response()->json(['success'=> 'User data added successfully']);

            }

            else

            {

                return response()->json(['errors'=>'Error while adding data']);

            }

        }

        //echo "<pre>"; print_r($validator->errors()); echo "<pre>"; 

        return response()->json(['error'=>$validator->errors()]);

    }



    // Like Menu item

    public function like_menu_item(Request $request)

    {

        $menu_id = $request->menu_id;



        $this->middleware('auth');



        if (Auth::user() === NULL) 

        {

            return response()->json(['login_error' => 'User Not logged in.']);

        }

        else

        {

            $row_updated = 0;

            $data_updated = 0;



            $user_id = Auth::user()->id;



            // Get Menu details

            $menu_details = MenuModel::get_one_menu_details($menu_id);



            $restaurant_id         = $menu_details->restaurant_id;

            $current_total_like    = $menu_details->total_like;

            $current_total_dislike = $menu_details->total_dislike;



            // Update menu like/unlike status

            $current_menu_vote = MenuModel::get_user_menu_vote($user_id, $restaurant_id, $menu_id);



            if ($current_menu_vote) 

            {

                $user_current_vote_id = $current_menu_vote->menu_vote_id;

                $user_current_vote = $current_menu_vote->vote;



                if ($user_current_vote != "1") 

                {

                    // Update Menu Vote details

                    $update_data = array(

                                            'vote'       => '1',

                                            'updated_at' => date('Y-m-d H:i:s')

                                        );



                    $where_condition = array(

                                                'menu_vote_id' => $user_current_vote_id

                                            );



                    $row_updated = MenuModel::update_menu_vote_details($where_condition, $update_data);

                }

            }

            else

            {

                // Add New Menu Vote

                $insert_data = array(

                                        'restaurant_id' => $restaurant_id,

                                        'menu_id'       => $menu_id,

                                        'user_id'       => $user_id,

                                        'vote'          => '1',

                                        'created_at'    => date('Y-m-d H:i:s')

                                    );



                $row_updated = MenuModel::create_menu_vote_details($insert_data);

            }



            if ($row_updated) 

            {

                // Update Menu total like/dislike

                if ($current_total_dislike > 0) 

                {

                    $current_total_dislike = $current_total_dislike - 1;

                }



                $menu_update_date = array(

                                            'total_like'    => $current_total_like + 1,

                                            'total_dislike' => $current_total_dislike,

                                            'updated_at'    => date('Y-m-d H:i:s')

                                        );



                $data_updated = MenuModel::update_menu_details($menu_id, $menu_update_date);

            }



            if ($data_updated) 

            {

                return response()->json(['success' => 'Data Updated successfully']);

            }

            else

            {

                return response()->json(['error' => 'Error While Updateing data.']);

            }

        }

    }



    // DisLike Menu item

    public function dislike_menu_item(Request $request)

    {

        $menu_id = $request->menu_id;



        $this->middleware('auth');



        if (Auth::user() === NULL) 

        {

            return response()->json(['login_error' => 'User Not logged in.']);

        }

        else

        {

            $row_updated = 0;

            $data_updated = 0;



            $user_id = Auth::user()->id;



            // Get Menu details

            $menu_details = MenuModel::get_one_menu_details($menu_id);



            $restaurant_id         = $menu_details->restaurant_id;

            $current_total_like    = $menu_details->total_like;

            $current_total_dislike = $menu_details->total_dislike;



            // Update menu like/unlike status

            $current_menu_vote = MenuModel::get_user_menu_vote($user_id, $restaurant_id, $menu_id);



            if ($current_menu_vote) 

            {

                $user_current_vote_id = $current_menu_vote->menu_vote_id;

                $user_current_vote = $current_menu_vote->vote;



                if ($user_current_vote != "0") 

                {

                    // Update Menu Vote details

                    $update_data = array(

                                            'vote'       => '0',

                                            'updated_at' => date('Y-m-d H:i:s')

                                        );



                    $where_condition = array(

                                                'menu_vote_id' => $user_current_vote_id

                                            );



                    $rows_updated = MenuModel::update_menu_vote_details($where_condition, $update_data);

                }

            }

            else

            {

                // Add New Menu Vote

                $insert_data = array(

                                        'restaurant_id' => $restaurant_id,

                                        'menu_id'       => $menu_id,

                                        'user_id'       => $user_id,

                                        'vote'          => '0',

                                        'created_at'    => date('Y-m-d H:i:s')

                                    );



                $rows_updated = MenuModel::create_menu_vote_details($insert_data);

            }



            if ($rows_updated) 

            {

                // Update Menu total like/dislike

                if ($current_total_like > 0) 

                {

                    $current_total_like = $current_total_like - 1;

                }



                $menu_update_date = array(

                                            'total_like'    => $current_total_like,

                                            'total_dislike' => $current_total_dislike + 1,

                                            'updated_at'    => date('Y-m-d H:i:s')

                                        );



                $data_updated = MenuModel::update_menu_details($menu_id, $menu_update_date);

            }



            if ($data_updated) 

            {

                return response()->json(['success' => 'Data Updated successfully']);

            }

            else

            {

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



        if (Auth::user() === NULL) 

        {

            return response()->json(['login_error' => 'User Not logged in.']);

        }

        else

        {

            $user_id = Auth::user()->id;



            $validator = Validator::make($request->all(), [

                                        'name'    => 'required',

                                        'email'   => 'required',

                                        'comment' => 'required',

                                    ]);



            if ($validator->passes()) 

            {

                // Update menu like/unlike status

                $current_user_menu_review = MenuModel::get_user_menu_vote($user_id, $restaurant_id, $menu_id);

                

                if ($current_user_menu_review) 

                {

                    $menu_review_id = $current_user_menu_review->menu_vote_id;



                    // Update Menu Review details

                    $update_data = array(

                                            'review' => $request->comment,

                                            'name'   => $request->name,

                                            'email'  => $request->email,

                                            'updated_at' => date('Y-m-d H:i:s')

                                        );



                    $where_condition = array(

                                                'menu_vote_id' => $menu_review_id

                                            );



                    $rows_updated = MenuModel::update_menu_vote_details($where_condition, $update_data);

                }

                else

                {

                    // Add New Menu Review

                    $insert_data = array(

                                            'restaurant_id' => $restaurant_id,

                                            'menu_id'       => $menu_id,

                                            'user_id'       => $user_id,

                                            'review'        => $request->comment,

                                            'name'          => $request->name,

                                            'email'         => $request->email,

                                            'created_at'    => date('Y-m-d H:i:s')

                                        );



                    $rows_updated = MenuModel::create_menu_vote_details($insert_data);

                }



                if ($rows_updated) 

                {

                    return response()->json(['success' => 'Data Added successfully']);

                }

                else

                {

                    return response()->json(['error' => 'Error While adding data.']);

                }

            }



            return response()->json(['error'=>$validator->errors()]);

        }

    }



    // get Menus by Parent Category

    public function get_menus_by_parent_category(Request $request)

    {

        $restaurant_id      = $request->restaurant_id;

        $parent_category_id = $request->parent_category_id;

        $main_category_id   = $request->main_category_id;



        // Get Menu Items

        $menu_details = MenuModel::get_menus_by_category(

                                                        $restaurant_id,

                                                        $parent_category_id,

                                                        $main_category_id

                                                    );



        if($menu_details)

        {   

            $return_array = [];



            if (count($menu_details) > '0') 

            {

                foreach ($menu_details as $key => $value) 

                {

                    $menu_like_icon = '<i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>';

                    $menu_unlike_icon = '<i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>';



                    if (Auth::user() !== NULL) 

                    {

                        $user_id = Auth::user()->id;



                        if ($user_id != "") 

                        {

                            $user_menu_votes = MenuModel::get_user_menu_vote(

                                                                    $user_id, 

                                                                    $restaurant_id, 

                                                                    $value->menu_id

                                                                );



                            if ($user_menu_votes) 

                            {

                                $user_menu_vote = $user_menu_votes->vote;



                                if ($user_menu_vote == "1") 

                                {

                                    $menu_like_icon = '<i class="fa fa-thumbs-up thumbs_icon" aria-hidden="true"></i>';

                                }

                                else if($user_menu_vote == "0")

                                {

                                    $menu_unlike_icon = '<i class="fa fa-thumbs-down thumbs_down_icon" aria-hidden="true"></i>';

                                }

                            }

                        }

                    } 



                    if ($value->tag_id != "") 

                    {

                        $tag_details = TagModel::get_multiple_tag_details($value->tag_id);



                        if ($tag_details) 

                        {

                            $tag_icons = [];



                            $tmp_tag_icons = [];

                            foreach ($tag_details as $key => $value1) 

                            {

                                if (!in_array($value1->tag_icon, $tmp_tag_icons)) 

                                {

                                    $tag_icons[] = $value1->tag_icon;

                                    $tmp_tag_icons[] = $value1->tag_icon;

                                }

                            }

                        }

                        else

                        {

                            $tag_icons = [];

                        }

                    }

                    else

                    {

                        $tag_icons = [];

                    }



                    $return_array[] = array(

                                            'menu_id'       => $value->menu_id,

                                            'menu_image'    => $value->menu_image,

                                            'name'          => $value->name,

                                            'menu_like_icon'   => $menu_like_icon,

                                            'menu_unlike_icon' => $menu_unlike_icon,

                                            'price'         => $value->price,

                                            'total_like'    => $value->total_like,

                                            'total_dislike' => $value->total_dislike,

                                            'tag_id'        => $tag_icons,

                                            'description'   => $value->description,

                                        );

                }

            }

            else

            {

                $return_array = [];

            }



            return response()->json(['success' => $return_array]);

        }

        else

        {

            return response()->json(['error' => 'No data found']);

        }

    }



    // get Top Rated Menus by Parent Category

    public function get_top_rated_menus_by_parent_category(Request $request)

    {

        $restaurant_id      = $request->restaurant_id;

        $parent_category_id = $request->parent_category_id;

        $main_category_id   = $request->main_category_id;



        // Get Menu Items

        $menu_details = MenuModel::get_menus_by_category(

                                                        $restaurant_id,

                                                        $parent_category_id,

                                                        $main_category_id, 

                                                        $sub_category_id = '', 

                                                        1 #top_rated

                                                    );



        if($menu_details)

        {   

            $return_array = [];



            if (count($menu_details) > '0') 

            {

                foreach ($menu_details as $key => $value) 

                {

                    if ($value->tag_id != "") 

                    {

                        $tag_details = TagModel::get_multiple_tag_details($value->tag_id);



                        if ($tag_details) 

                        {

                            $tag_icons = [];



                            $tmp_tag_icons = [];

                            foreach ($tag_details as $key => $value1) 

                            {

                                if (!in_array($value1->tag_icon, $tmp_tag_icons)) 

                                {

                                    $tag_icons[] = $value1->tag_icon;

                                    $tmp_tag_icons[] = $value1->tag_icon;

                                }

                            }

                        }

                        else

                        {

                            $tag_icons = [];

                        }

                    }

                    else

                    {

                        $tag_icons = [];

                    }



                    $return_array[] = array(

                                            'menu_id'       => $value->menu_id,

                                            'menu_image'    => $value->menu_image,

                                            'name'          => $value->name,

                                            'price'         => $value->price,

                                            'total_like'    => $value->total_like,

                                            'total_dislike' => $value->total_dislike,

                                            'tag_id'        => $tag_icons,

                                            'description'   => $value->description,

                                        );

                }

            }

            else

            {

                $return_array = [];

            }

            

            return response()->json(['success' => $return_array]);

        }

        else

        {

            return response()->json(['error' => 'No data found']);

        }

    }



    // get Menu tags

    public function get_multiple_tag_details(Request $request)

    {

        $tag_id = $request->tag_id;



        // Get Tag Items

        $tag_details = TagModel::get_multiple_tag_details($tag_id);



        if($tag_details)

        {   

            return response()->json(['success' => $tag_details]);

        }

        else

        {

            return response()->json(['error' => 'No data found']);

        }

    }

}

