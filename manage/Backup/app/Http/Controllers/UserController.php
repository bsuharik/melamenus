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
use App\Models\ChefQuestion;
use App\Models\MenuVote;
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
        
        
        
        
        $parent_categories=array();
        $main_categories=array();
        $sub_categories=array();
        $restaurant_details=array();
        if ($restaurant_id != "") 
        {
            session()->put('restaurant_id',$restaurant_id);
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
                
                
                
            }
            session()->save();
            // Restaurant Details
            $restaurant_details=RestaurantModel::where('restaurant_id',$restaurant_id)->with('parent_category_detail','main_category_detail','sub_category_detail')->first();            
           // Get Parent Categories
            if(!empty($restaurant_details->parent_category_detail)){
                $parent_categories=$restaurant_details->parent_category_detail;
            }

            // Get Main Categories
            if(!empty($restaurant_details->main_category_detail)){
                $main_categories=$restaurant_details->main_category_detail;
            }

            // Get Sub Categories
            if(!empty($restaurant_details->sub_category_detail)){
                $sub_categories=$restaurant_details->sub_category_detail;
            }
        

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
        $parent_category_details = CategoryModel::where('category_id',$parent_category)->first();
        

        $restaurant_id = $parent_category_details->restaurant_id;

        $currency_icon=" ";
        $restaurant_details=array();
        $parent_categories=array();
        $main_categories=array();
        $sub_categories=array();

        $parent_main_categories =array();
         $restaurant_details = RestaurantModel::where('restaurant_id',$restaurant_id)->with('currency_detail','parent_category_detail','main_category_detail','sub_category_detail')->first();
        
        // Restaurant Details
        if(!empty($restaurant_details)){
            // Get Currency icon
            if(!empty($restaurant_details->currency_detail)){
                $currency_icon=$restaurant_details->currency_detail->currency_icon;
            }

            // Get Parent Categories
            if(!empty($restaurant_details->parent_category_detail)){
                $parent_categories=$restaurant_details->parent_category_detail;
            }

            // Get Main Categories
            if(!empty($restaurant_details->main_category_detail)){
                $main_categories=$restaurant_details->main_category_detail;
            }

            // Get Sub Categories
            if(!empty($restaurant_details->sub_category_detail)){
                $sub_categories=$restaurant_details->sub_category_detail;
            }
            $parent_main_categories_all = CategoryModel::where('restaurant_id',$restaurant_id)->where('parent_category_id',$parent_category)->where('category_type','1')->get();
            if(!empty($main_categories)){
                $parent_main_categories= $parent_main_categories_all;
            }
        }



        // // Get Main Categories
         

        return view('user_app/main_categories',['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'parent_main_categories' => $parent_main_categories, 'parent_category_id' => $parent_category, 'currency_icon' => $currency_icon]);
    }

    // Sub Categories list
    public static function sub_categories($main_category)
    {
        $main_category_details = CategoryModel::where('category_id',$main_category)->first();
        $restaurant_id   = $main_category_details->restaurant_id;
        $parent_category = $main_category_details->parent_category_id;
        $sub_category    = '';
        $menu_detail= MenuModel::select('*');
        if(!empty($restaurant_id)){$menu_detail->where('restaurant_id',$restaurant_id);}
        if(!empty($parent_category_id)){$menu_detail->where('parent_category',$parent_category_id);}
        if(!empty($main_category)){$menu_detail->where('main_category',$main_category);}
        // if(!empty($sub_category)){$menu_detail->where('sub_category',$sub_category);}
        $menu_item_data=$menu_detail->get();
        $menu_items=array();
        if(!empty($menu_item_data)){
            foreach($menu_item_data as $menu_value){
                $tag_detail_data = TagModel::whereIn('tag_id',explode(',',$menu_value->tag_id))->get();
                if(!empty($tag_detail_data)){
                    $menu_value->tag_detail=$tag_detail_data;
                }else{
                    $menu_value->tag_detail=array();
                }
                $user_menu_votes='';
                if(!empty(Auth::user()->id)){
                    $user_id = Auth::user()->id;
                   $user_menu_votes = MenuVote::where('menu_id',$menu_value->menu_id)->where('restaurant_id',$menu_value->restaurant_id)->where('user_id',$user_id)->first(); 
                }
                if(!empty($user_menu_votes)){
                    $menu_value->user_menu_votes=$user_menu_votes;
                }
                $menu_items[]=$menu_value;

            }
        } 
        // echo "<pre>here"; print_r($menu_items); echo "</pre>"; exit();



        // Get sub Categories
        $main_sub_categories=array();
        $sub_categories = CategoryModel::where('restaurant_id',$restaurant_id)->where('parent_category_id',$parent_category)->where('main_category_id',$main_category)->where('category_type','2')->get();
        if(!empty($sub_categories)){
            $main_sub_categories= $sub_categories;
            
        }

        // Get Tags
        $tags_array = TagModel::all();

        // Restaurant Details
        $currency_icon=" ";
         $restaurant_details=array();
         $restaurant_details = RestaurantModel::where('restaurant_id',$restaurant_id)->with('parent_category_detail','main_category_detail','sub_category_detail','currency_detail')->first();
         $parent_categories=array();
         $main_categories=array();
         $sub_categories=array();
        if(!empty($restaurant_details)){
            // Get Currency icon
            if(!empty($restaurant_details->currency_detail)){
                $currency_icon=$restaurant_details->currency_detail->currency_icon;
            }
            // Get Parent Categories
            if(!empty($restaurant_details->parent_category_detail)){
                $parent_categories=$restaurant_details->parent_category_detail;
            }

            // Get Main Categories
            if(!empty($restaurant_details->main_category_detail)){
                $main_categories=$restaurant_details->main_category_detail;
            }

            // Get Sub Categories
            if(!empty($restaurant_details->sub_category_detail)){
                $sub_categories=$restaurant_details->sub_category_detail;
            }
        }
        

        return view('user_app/sub_categories',['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'main_sub_categories' => $main_sub_categories, 'menu_items' => $menu_items, 'currency_icon' => $currency_icon, 'tags_array' => $tags_array, 'parent_category_id' => $parent_category, 'main_category_id' => $main_category ]);
    }

    // Menu Item list
    public function menu_items($sub_category)
    {
        $main_sub_categories = [];
        $sub_category_details = CategoryModel::where('category_id',$sub_category)->first();

        $restaurant_id   = $sub_category_details->restaurant_id;
        $parent_category = $sub_category_details->parent_category_id;
        $main_category   = $sub_category_details->main_category_id;

        
        // echo "<pre>"; print_r($restaurant_id); echo "</pre>"; exit();

        
        // Restaurant Details
        $currency_icon=" ";
        $restaurant_details=array();
        $parent_categories=array();
        $main_categories=array();
        $sub_categories=array();

        $restaurant_details = RestaurantModel::where('restaurant_id',$restaurant_id)->with('parent_category_detail','main_category_detail','sub_category_detail','currency_detail')->first();
        if(!empty($restaurant_details)){
            // Get Currency icon
            if(!empty($restaurant_details->currency_detail)){
                $currency_icon=$restaurant_details->currency_detail->currency_icon;
            }

            // Get Parent Categories
            if(!empty($restaurant_details->parent_category_detail)){
                $parent_categories=$restaurant_details->parent_category_detail;
            }

            // Get Main Categories
            if(!empty($restaurant_details->main_category_detail)){
                $main_categories=$restaurant_details->main_category_detail;
            }

            // Get Sub Categories
            if(!empty($restaurant_details->sub_category_detail)){
                $sub_categories=$restaurant_details->sub_category_detail;
            }

        }
        
        

        // Get Tags
        $tags_array = TagModel::all();


        // Get Menu Items
        $menu_item_detail = MenuModel::where('restaurant_id',$restaurant_id)->where('parent_category',$parent_category)->where('main_category',$main_category)->where('sub_category',$sub_category)->get(); 
        $menu_items=array();

        if(!empty($menu_item_detail)){
            foreach($menu_item_detail as $menu_item_value){
                if(!empty($menu_item_value)){
                    
                    $tag_detail_data = TagModel::whereIn('tag_id',explode(',', $menu_item_value->tag_id))->get();
                    if(!empty($tag_detail_data)){
                        $menu_item_value->tag_detail=$tag_detail_data;
                    }else{
                        $menu_item_value->tag_detail=array();
                    }  
                }
                $user_menu_votes='';
                if(!empty(Auth::user()->id)){
                    $user_id = Auth::user()->id;
                    $user_menu_votes = MenuVote::where('menu_id',$menu_item_value->menu_id)->where('restaurant_id',$menu_item_value->restaurant_id)->where('user_id',$user_id)->first();
                }
                if(!empty($user_menu_votes)){
                    $menu_item_value->user_menu_votes=$user_menu_votes;
                }


                $menu_items[]= $menu_item_value;
            }
        }
        // echo "<pre>"; print_r($menu_items); echo "</pre>"; exit();
        return view('user_app/sub_categories',['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'main_sub_categories' => $main_sub_categories, 'menu_items' => $menu_items, 'currency_icon' => $currency_icon, 'tags_array' => $tags_array, 'parent_category_id' => $parent_category, 'main_category_id' => $main_category ]);
    }

    // Menu details
    public function menu_details($menu_id)
    {

        $main_sub_categories = [];
        // Get Menu details

        $menu_details = MenuModel::find($menu_id);
        $tag_details=array();
        if (!empty($menu_details->tag_id)){
            $tag_details = TagModel::whereIn('tag_id',explode(',', $menu_details->tag_id))->get();
        } 
        $restaurant_id = $menu_details->restaurant_id;
        $user_menu_votes=array();
        if(!empty(Auth::user()->id)){
            $user_id = Auth::user()->id;
            $user_menu_votes=array();
            $user_menu_votes = MenuVote::where('menu_id',$menu_id)->where('restaurant_id',$restaurant_id)->where('user_id',$user_id)->first();

             
        }
        // Get Chef questionsuser
        $chef_questions_array = ChefQuestion::where('restaurant_id',$restaurant_id)->where('menu_id',$menu_id)->get();
        $currency_icon=" ";
        $restaurant_details=array();
        $parent_categories=array();
        $main_categories=array();
        $sub_categories=array();
         $restaurant_details=RestaurantModel::where('restaurant_id',$restaurant_id)->with('parent_category_detail','main_category_detail','sub_category_detail')->first();
            // Restaurant Details
        if(!empty($restaurant_details)){
            // Get Parent Categories
            if(!empty($restaurant_details->parent_category_detail)){
                $parent_categories=$restaurant_details->parent_category_detail;
            }

            // Get Main Categories
            if(!empty($restaurant_details->main_category_detail)){
                $main_categories=$restaurant_details->main_category_detail;
            }

            // Get Sub Categories
            if(!empty($restaurant_details->sub_category_detail)){
                $sub_categories=$restaurant_details->sub_category_detail;
            }

        }
        

        return view('user_app/menu_details',['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details, 'menu_details' => $menu_details, 'currency_icon' => $currency_icon, 'chef_questions' => $chef_questions_array,'tag_details'=>$tag_details,'user_menu_votes'=>$user_menu_votes]);
    }

    // get Menus by tag
    public function get_menus_by_tag(Request $request)
    {
        $restaurant_id      = $request->restaurant_id;
        $tag_id             = $request->tag_id;
        $parent_category_id = $request->parent_category_id;
        $main_category_id   = $request->main_category_id;
        $sub_category_id    = $request->sub_category_id;
        //Get Menu Items
        $menu_detail= MenuModel::select('*');
        if(!empty($restaurant_id)){$menu_detail->where('restaurant_id',$restaurant_id);}
        if(!empty($parent_category_id)){$menu_detail->where('parent_category',$parent_category_id);}
        if(!empty($main_category_id)){$menu_detail->where('main_category',$main_category_id);}
        if(!empty($sub_category_id)){$menu_detail->where('sub_category',$sub_category_id);}

        $tag_ids = [];
        if (!empty($tag_id) && $tag_id != "0"){
            $tag_ids = explode(",", $tag_id);
            $i=0;
            foreach ($tag_ids as $key => $value) 
            {
                if ($value != "0"){
                    if($i == 0){
                       $menu_detail->whereRaw("find_in_set('".$value."',tag_id)");
                       $i=1;
                    }
                    if($i==1){
                       $menu_detail->orwhereRaw("find_in_set('".$value."',tag_id)");
                    }
                    
                }
            }
        }
        if(in_array("0", $tag_ids) || $tag_id == "0"){
           $menu_detail->orderBy('total_like','desc');
        }
        $menu_details=$menu_detail->get();
        if($menu_details)
        {   
            $return_array = [];

            if (count($menu_details) > '0') 
            {
                foreach ($menu_details as $key => $value) 
                {
                    if($value->main_category == $main_category_id){
                   
                        $menu_like_icon = '<i class="fa fa-thumbs-o-up thumbs_icon" aria-hidden="true"></i>';
                        $menu_unlike_icon = '<i class="fa fa-thumbs-o-down thumbs_down_icon" aria-hidden="true"></i>';

                        if (Auth::user() !== NULL) 
                        {
                            $user_id = Auth::user()->id;

                            if ($user_id != "") 
                            {
                                $user_menu_votes = MenuVote::where('menu_id',$value->menu_id)->where('restaurant_id',$restaurant_id)->where('user_id',$user_id)->first();

                                if (!empty($user_menu_votes)) 
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
                            $tag_details = TagModel::whereIn('tag_id',explode(',', $value->tag_id))->get();
                            if (!empty($tag_details)) 
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
            
        
        $restaurant_details=array();
        $restaurant_details=array();
        $parent_categories=array();
        $main_categories=array();
        $sub_categories=array();
         // Restaurant Details
         $restaurant_details=RestaurantModel::where('restaurant_id',$restaurant_id)->with('parent_category_detail','main_category_detail','sub_category_detail')->first();
        if(!empty($restaurant_details)){
            session()->put('restaurant_id',$restaurant_id);
            session()->save();
            // Get Parent Categories
            if(!empty($restaurant_details->parent_category_detail)){
                $parent_categories=$restaurant_details->parent_category_detail;
            }

            // Get Main Categories
            if(!empty($restaurant_details->main_category_detail)){
                $main_categories=$restaurant_details->main_category_detail;
            }

            // Get Sub Categories
            if(!empty($restaurant_details->sub_category_detail)){
                $sub_categories=$restaurant_details->sub_category_detail;
            }

        }


        
       



        return view('user_app/user_login',['parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_details' => $restaurant_details]);
    } 

    // Show Register Form
    public function showRegister($restaurant_id)
    {
        
        $restaurant_details=array();
        $parent_categories=array();
        $main_categories=array();
        $sub_categories=array();
         $restaurant_details=RestaurantModel::where('restaurant_id',$restaurant_id)->with('parent_category_detail','main_category_detail','sub_category_detail')->first();
       if(!empty($restaurant_details)){
            // Get Parent Categories
            if(!empty($restaurant_details->parent_category_detail)){
                $parent_categories=$restaurant_details->parent_category_detail;
            }

            // Get Main Categories
            if(!empty($restaurant_details->main_category_detail)){
                $main_categories=$restaurant_details->main_category_detail;
            }

            // Get Sub Categories
            if(!empty($restaurant_details->sub_category_detail)){
                $sub_categories=$restaurant_details->sub_category_detail;
            }

        }
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
            $to_name  = $request->first_name." ".$request->last_name;
            $to_email = $request->email;

            $data = array(
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
            ); 

            //Send email to restaurant owner
            Mail::send('email.app_user_registartion', ["data"=>$data] , function($message) use ($to_name, $to_email){
                $message->to($to_email, $to_name)->subject('Mela Menus - User Created');
                $message->from('testcrestemail@gmail.com','Mela Menus');
            });

            $user_row_added=1;
            if($user_row_added)
            {
                return response()->json(['success'=> 'User data added successfully']);
            }
            else
            {
                return response()->json(['errors'=>'Error while adding data']);
            }
        }
        
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
            $menu_details = MenuModel::find($menu_id);
            $restaurant_id         = $menu_details->restaurant_id;
            $current_total_like    = $menu_details->total_like;
            $current_total_dislike = $menu_details->total_dislike;

            // Update menu like/unlike status
            $current_menu_vote = MenuVote::where('restaurant_id',$restaurant_id)->where('user_id',$user_id)->where('menu_id',$menu_id)->first();
                
            if (!empty($current_menu_vote)) 
            {

                $user_current_vote_id = $current_menu_vote->menu_vote_id;
                $user_current_vote = $current_menu_vote->vote;
                if ($user_current_vote != "1") 
                {
                    $menu_vote =MenuVote::where('menu_vote_id',$user_current_vote_id)->first();
                   
                   $menu_vote->vote='1';
                   $menu_vote->updated_at=date('Y-m-d H:i:s');
                   $row_updated=$menu_vote->save();
                   
                }else{

                }
            }
            else
            {
                $menu_vote =new MenuVote();
                $menu_vote->restaurant_id = $restaurant_id;
                $menu_vote->menu_id = $menu_id;
                $menu_vote->user_id       = $user_id;
                $menu_vote->vote        = '1';
                $menu_vote->created_at   = date('Y-m-d H:i:s');
                $row_updated = $menu_vote->save();
               
            }
            // echo "<pre>"; print_r($row_updated); echo "</pre>"; exit();
            if ($row_updated) 
            {
                // Update Menu total like/dislike
                if ($current_total_dislike > 0) 
                {
                    $current_total_dislike = $current_total_dislike - 1;
                }
                $menu_update = MenuModel::where('menu_id',$menu_id)->first();
                $menu_update->total_like   = $current_total_like + 1;
                $menu_update->total_dislike = $current_total_dislike;
                $menu_update->updated_at    = date('Y-m-d H:i:s');
                $data_updated = $menu_update->save();
                 
                

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
            $rows_updated = 0;
            $data_updated = 0;

            $user_id = Auth::user()->id;

            // Get Menu details
            $menu_details = MenuModel::find($menu_id);
            $restaurant_id         = $menu_details->restaurant_id;
            $current_total_like    = $menu_details->total_like;
            $current_total_dislike = $menu_details->total_dislike;

            // Update menu like/unlike status
            $current_menu_vote = MenuVote::where('restaurant_id',$restaurant_id)->where('user_id',$user_id)->where('menu_id',$menu_id)->first();

            if (!empty($current_menu_vote)) 
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
                    $menu_vote = MenuVote::where('menu_vote_id',$user_current_vote_id)->first();
                    $menu_vote->vote='0';
                    $menu_vote->updated_at=date('Y-m-d H:i:s');
                    $rows_updated=$menu_vote->save();

                }
            }
            else
            {
                // Add New Menu Vote
                // $insert_data = array(
                //     'restaurant_id' => $restaurant_id,
                //     'menu_id'       => $menu_id,
                //     'user_id'       => $user_id,
                //     'vote'          => '0',
                //     'created_at'    => date('Y-m-d H:i:s')
                // );
                $menu_vote =new MenuVote();
                $menu_vote->restaurant_id = $restaurant_id;
                $menu_vote->menu_id = $menu_id;
                $menu_vote->user_id       = $user_id;
                $menu_vote->vote        = '0';
                $menu_vote->created_at   = date('Y-m-d H:i:s');
                $rows_updated = $menu_vote->save();
            }

            if ($rows_updated) 
            {
                // Update Menu total like/dislike
                if ($current_total_like > 0) 
                {
                    $current_total_like = $current_total_like - 1;
                }

                // $menu_update_date = array(
                //     'total_like'    => $current_total_like,
                //     'total_dislike' => $current_total_dislike + 1,
                //     'updated_at'    => date('Y-m-d H:i:s')
                // );
                $menu_update = MenuModel::where('menu_id',$menu_id)->first();
                $menu_update->total_like   = $current_total_like;
                $menu_update->total_dislike = $current_total_dislike + 1;
                $menu_update->updated_at    = date('Y-m-d H:i:s');
                $data_updated = $menu_update->save();
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
                $current_user_menu_review = MenuVote::where('restaurant_id',$restaurant_id)->where('user_id',$user_id)->where('menu_id',$menu_id)->first();
                if (!empty($current_user_menu_review)) 
                {
                    $menu_review_id = $current_user_menu_review->menu_vote_id;

                    // Update Menu Review details
                    $menu_vote =MenuVote::where('menu_vote_id',$menu_review_id)->first();
                   $menu_vote->review = $request->comment;
                   $menu_vote->name   = $request->name;
                   $menu_vote->email  = $request->email;
                   $menu_vote->updated_at=date('Y-m-d H:i:s');
                   $rows_updated=$menu_vote->save();
                   
                }
                else
                {
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
                    $menu_vote =new MenuVote();
                    $menu_vote->restaurant_id = $restaurant_id;
                    $menu_vote->menu_id = $menu_id;
                    $menu_vote->user_id       = $user_id;
                    $menu_vote->name        = $request->name;
                    $menu_vote->email        = $request->email;
                    $menu_vote->created_at   = date('Y-m-d H:i:s');
                    $rows_updated = $menu_vote->save();
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
        $menu_detail= MenuModel::select('*');
        if(!empty($restaurant_id)){$menu_detail->where('restaurant_id',$restaurant_id);}
        if(!empty($parent_category_id)){$menu_detail->where('parent_category',$parent_category_id);}
        if(!empty($main_category_id)){$menu_detail->where('main_category',$main_category_id);}
        $menu_details=$menu_detail->get(); 
        // echo "<pre>"; print_r($menu_details); echo "</pre>"; exit();

        if(!empty($menu_details))
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
                            

                            $user_menu_votes = MenuVote::where('restaurant_id',$restaurant_id)->where('user_id',$user_id)->where('menu_id',$value->menu_id)->first();

                            if (!empty($user_menu_votes)) 
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
                        $tag_details = TagModel::whereIn('tag_id',explode(',', $value->tag_id))->get();
                        if (!empty($tag_details)) 
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
        $menu_detail= MenuModel::select('*');
        if(!empty($restaurant_id)){$menu_detail->where('restaurant_id',$restaurant_id);}
        if(!empty($parent_category_id)){$menu_detail->where('parent_category',$parent_category_id);}
        if(!empty($main_category_id)){$menu_detail->where('main_category',$main_category_id);}
        $menu_details=$menu_detail->orderBy('total_like', 'desc')->get(); 

        if(!empty($menu_details))
        {   
            $return_array = [];

            if (count($menu_details) > '0') 
            {
                foreach ($menu_details as $key => $value) 
                {
                    if ($value->tag_id != "") 
                    {
                        $tag_details = TagModel::whereIn('tag_id',explode(',', $value->tag_id))->get();
                        if (!empty($tag_details)) 
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
        $tag_details = TagModel::whereIn('tag_id',explode(',', $tag_id))->get();
        if(!empty($tag_details))
        {   
            return response()->json(['success' => $tag_details]);
        }
        else
        {
            return response()->json(['error' => 'No data found']);
        }
    }
}
