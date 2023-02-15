<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Validator;

use File;

use Redirect;

use App\Models\MenuModel;

use App\Models\CurrencyModel;

use App\Models\RestaurantModel;

use App\Models\TagModel; 

use App\Models\CategoryModel;

use App\Models\ChefQuestion;

use App\Models\MenuVote;

use App\Models\AllergyModel;

use App\Models\MenuImage; 

use DB;

use Auth;

class MenuController extends Controller

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

    public function index($id) 

    {

       

        $restaurant_name=" ";

        $currency_icon=" ";

        $parent_categories=array();

        $restaurant_detail = RestaurantModel::where('restaurant_id',$id)->with('currency_detail','parent_category_detail')->first();

        if(!empty($restaurant_detail)){

            if(!empty($restaurant_detail->currency_detail)){ 

                $currency_icon=$restaurant_detail->currency_detail->currency_icon;

            }

            $restaurant_name=$restaurant_detail->restaurant_name;

            // Get Parent Categories

            if(!empty($restaurant_detail->parent_category_detail)){

                

                    $parent_categories = $restaurant_detail->parent_category_detail;

               

                

            }

            



        }  

        // Get Menus

        $menu_data = MenuModel::where('restaurant_id',$id)->count();

        if(!empty($menu_data)){ 

            $menu_data = MenuModel::where('restaurant_id',$id)->orderBy('order_display','ASC')->get();

            foreach($menu_data as $menu_value){

                if(!empty($menu_value->tag_id)){

                    $tag_detail_data = TagModel::whereIn('tag_id',explode(",",$menu_value->tag_id))->get();

                    if(!empty($tag_detail_data)){

                        $menu_value->tag_details=$tag_detail_data;

                    }else{

                        $menu_value->tag_details=array();

                    }  

                }

                $menu_array []= $menu_value;

            }

        }else{

            $menu_array=array();

        }

        return view('menu/index',['restaurant_id'=>$id,'restaurant_name' => $restaurant_name, 'menu_list' => $menu_array, 'currency_icon' => $currency_icon, 'parent_categories_array' => $parent_categories, 'main_categories_array' => array(), 'sub_categories_array' => array(), 'filter_parent_category' => '', 'filter_main_category' => '', 'filter_sub_category' => '']);

    }



    // Add menu form

    public function create($id)

    {

        $restaurant_name='';

        // Get restaurant name

        $restaurant_details = RestaurantModel::where('restaurant_id',$id)->with('parent_category_detail','main_category_detail','sub_category_detail','currency_detail')->first();

        $restaurant_name=$restaurant_details->restaurant_name;

        



        $parent_category_array=array();

        $main_category_array=array();

        $sub_category_array=array();



        // Get Parent Categories

        if(!empty($restaurant_details->parent_category_detail)){

            $parent_category_array=$restaurant_details->parent_category_detail;

        }



        // Get Main Categories

        if(!empty($restaurant_details->main_category_detail)){

            $main_category_array=$restaurant_details->main_category_detail;

        }



        // Get Sub Categories

        if(!empty($restaurant_details->sub_category_detail)){

            $sub_category_array=$restaurant_details->sub_category_detail;

        }



        // Get Tags



        $tags_array = TagModel::all();

        $allergies_array=array();

        $allergies_array = AllergyModel::all();

        



        return view('menu/create',['restaurant_id'=>$id,'restaurant_name' => $restaurant_name,'parent_categories' => $parent_category_array,'main_categories' => $main_category_array,'sub_categories' => $sub_category_array,'tag_list' => $tags_array,'allergies_list' =>$allergies_array]);

    }



    // Validate and Add menu

    public function create_restaurant_menu(Request $request){

         // echo "<pre>";print_r($request->all()); echo "</pre>"; exit();

        $price_array = array_filter($request->price, function($x) { return !empty($x); });

        $price_des_array =$request->price_des;

        $restaurant_id = $request->restaurant_id;



        // Get current restaurant row

        $restaurant_details = RestaurantModel::where('restaurant_id',$restaurant_id)->first();

        if (!empty($restaurant_details)) 

        {

            $validator = Validator::make($request->all(), [

                'name'            => 'required',

                'parent_category' => 'required',

                'main_category'   => 'required',

                'availiblity'     => 'required',

                'ingredients'     => 'required',

                'calories'        => 'required',

                'description'     => 'required',

                //'menu_image'      => 'mimes:jpeg,png', 

            ]);



            if ($validator->passes())  

            {

                $raise_option_error = 0;

                $option_ids = [];

                $other_option_ids = [];

                if(!empty($price_array)){

                    $price = implode(',', $price_array);

                    $price_des = implode(',', $price_des_array);

                }else{

                    return response()->json(['priceerror'=>'Atleast one menu price is required']);

                }

                if(!empty($request->link)){

                    $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 

                    $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 

                    $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 

                    $regex .= "(\:[0-9]{2,5})?"; // Port 

                    $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 

                    $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 

                    $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

                    if(preg_match("/^$regex$/i",$request->link)){ // `i` flag for case-insensitive

                        $menu_link = $request->link;

                    }else{

                        return response()->json(['link_error'=>'Link format is invalid']);

                    }

                }else{

                    $menu_link='';

                }



                // Add chef's question

                for ($i=0; $i <5; $i++) 

                { 

                    if(request('question'.$i) != "")

                    {

                        if (request('option_1'.$i) == "" && request('option_2'.$i) == "" && request('option_3'.$i) == "" && request('option_4'.$i) == "" && request('option_5'.$i) == ""  ) 

                        {

                            $raise_option_error = 1;

                            $option_ids[] = array('question'.$i => "Atleast one option is required");

                        }

                        else

                        {

                            $other_option_ids[] = array('question'.$i => "");

                        }

                    }

                }



                if ($raise_option_error){

                    $all_other_option_ids = [];$all_other_option_ids[] = array_merge($option_ids, $other_option_ids);

                    return response()->json(['option_error'=> $all_other_option_ids]);

                }

                if(empty($request->menu_image_id)){

                    return response()->json(['image_error'=> 'Menu Image is required']);

                }

                // $menu_other_image_name="";

                // if(!empty($request->file('menu_other_image'))){

                //     $other_image=$request->file('menu_other_image');

                //     $menuOtherImageName=array();

                //     foreach($other_image as $otherImage){

                //         $menuimage = explode(".",$otherImage->getClientOriginalName());

                //         $menu_image_name = $menuimage[0].'-'.time().".".$menuimage[1];

                //         array_push($menuOtherImageName,$menu_image_name);

                //         //Move Uploaded File

                //         $destinationPath = config('images.menu_url').$restaurant_id;

                //         $otherImage->move($destinationPath,$menu_image_name);

                //     }

                //     $menu_other_image_name=implode(",", $menuOtherImageName);





                // }

                // $menuImage=$request->file('files');

                // foreach ($menuImage as  $value_Image) {

                //     $menuimage = explode(".",$value_Image->getClientOriginalName());

                //     $menu_image_name = $menuimage[0].'-'.uniqid().".".$menuimage[1];

                //     $imageNameArray[] = $menu_image_name; 

                //     $destinationPath = config('images.menu_url').$restaurant_id;

                //     $value_Image->move($destinationPath,$menu_image_name);

                // }

                //$menu_image=implode(",", $imageNameArray);

                



                    // Add Data

                    $tag_ids = "";

                    if (!empty($request->tag_id)) 

                    {

                        $tag_ids_array = [];

                        foreach ($request->tag_id as $key => $value) 

                        {

                            if ($value != "") 

                            {

                                $tag_ids_array[] = $value; 

                            }

                        }

                        $tag_ids = implode(",", $tag_ids_array);

                    }

                    $allergies_ids = "";

                    if (!empty($request->allergies)) 

                    {

                        $allergies_ids_array = [];

                        foreach ($request->allergies as $alergies_key => $alergies_value) 

                        {

                            if ($alergies_value != "") 

                            {

                                $allergies_ids_array[] = $alergies_value; 

                            }

                        }

                        $allergies_ids = implode(",", $allergies_ids_array);

                    }

                    $menu_slugs=strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-',$request->name)));

                    $regex = "/\-+$/";

                    $menu_slug= preg_replace($regex, "", $menu_slugs);



                    $menuName_check = DB::table('menus')->where('slug',$menu_slug)->get()->count();

                    if($menuName_check > 0){

                    $menuSlug= $menu_slug.''.rand(pow(10, 2-1), pow(10, 2)-1);

                    }else{

                    $menuSlug= $menu_slug;

                    }

                    // Add row

                    $menu_create = new MenuModel ();

                    $menu_create->restaurant_id  = $restaurant_id;

                    $menu_create->name           = $request->name;

                    $menu_create->slug           = $menuSlug;

                    $menu_create->price         = $price;

                    $menu_create->price_description = $price_des;

                    $menu_create->parent_category = $request->parent_category;

                    $menu_create->main_category  = $request->main_category;

                    $menu_create->sub_category  = $request->sub_category;

                    $menu_create->availiblity    = $request->availiblity;

                    $menu_create->ingredients   = $request->ingredients;

                    $menu_create->allergies     = trim($allergies_ids);;

                    $menu_create->calories     = $request->calories;

                    $menu_create->link     = $menu_link;

                    $menu_create->tag_id       = trim($tag_ids);

                    $menu_create->description   = $request->description;

                    $menu_create->created_at     = date('Y-m-d H:i:s');

                    $last_order_menu = MenuModel::where('restaurant_id',$restaurant_id)->where('parent_category',$request->parent_category)->where('main_category',$request->main_category)->where('sub_category',$request->sub_category)->orderBy('order_display', 'desc')->first();

                        if(!empty($last_order_menu)){

                            $menu_create->order_display = $last_order_menu->order_display + 1;

                        }else{

                            $menu_create->order_display = 1;

                        }

                    $is_save=$menu_create->save();

                    if($is_save) 

                    {

                        $menu_id = $menu_create->menu_id;



                        // Add chef's question

                        for ($i=0; $i <5; $i++) 

                        { 

                            if(request('question'.$i) != "")

                            {

                                



                                $chef_question = new ChefQuestion();

                                $chef_question->menu_id= $menu_id;

                                $chef_question->restaurant_id = $restaurant_id;

                                $chef_question->question = request('question'.$i);

                                $chef_question->option_1 = request('option_1'.$i);

                                $chef_question->option_2 = request('option_2'.$i);

                                $chef_question->option_3 = request('option_3'.$i);

                                $chef_question->option_4 = request('option_4'.$i);

                                $chef_question->option_5 = request('option_5'.$i);

                                $chef_question->created_at = date('Y-m-d H:i:s');

                                $chef_question->save();



                            }

                        }

                        // menu id add in menu image table

                        if(!empty($request->menu_image_id)){

                            $i=0;

                                foreach ($request->menu_image_id as $menu_image_id) {

                                    $menu_item_image= MenuImage::find($menu_image_id);

                                    if($i == 0){

                                        if(!empty($menu_item_image)){

                                            $menu_create->menu_image = $menu_item_image->image_name;

                                            $menu_create->save();

                                            $menu_item_image->delete();

                                        }

                                    }else{

                                        $menu_item_image->menu_id= $menu_id;

                                        $menu_item_image->save();

                                    }

                                   $i = $i + 1;

                                }

                        } 





                        return response()->json(['success'=> 'Menu data added successfully']);

                    }

                    else

                    {

                        return response()->json(['errors'=>'Error while adding data']);

                    }

                

            }



            return response()->json(['error'=>$validator->errors()]);

        }

        else

        {

            return response()->json(['errors'=>'Incorrect restaurant details']);

        }

    }



    // View menu details

    public function view($id) 

    {

        $restaurant_id   = "";

        $restaurant_name = "";

        $tag_id = "";

        $parent_category_name = "";

        $main_category_name   = "";

        $sub_category_name    = "";

        $menu_reviews = []; 



        // Get menu details 

        $menu_details_array = MenuModel::where('menu_id',$id)->with('allergie_detail','menu_image_detail')->first();

        //echo "<pre>"; print_r($menu_details_array->menu_image_detail); echo "</pre>"; exit();

        if(!empty($menu_details_array))

        {   

            $tag_id             = $menu_details_array->tag_id;

            $allergy_id         = $menu_details_array->allergies;

            $parent_category_id = $menu_details_array->parent_category;

            $main_category_id   = $menu_details_array->main_category;

            $sub_category_id    = $menu_details_array->sub_category;



             // Get restaurant name

            $restaurant_id = $menu_details_array->restaurant_id;



            $restaurant_name=" ";

            $currency_icon=" ";

            $restaurant_detail = RestaurantModel::where('restaurant_id',$restaurant_id)->with('currency_detail')->first();

            if(!empty($restaurant_detail)){

                if(!empty($restaurant_detail->currency_detail)){

                    $currency_icon=$restaurant_detail->currency_detail->currency_icon;

                }

                $restaurant_name=$restaurant_detail->restaurant_name;



            }



            // Get Currency icon

            // Menu Ratings

             $menu_ratings = MenuVote::where('restaurant_id',$restaurant_id)->where('menu_id', $id)->with('user_detail')->get();

           // Get category Name

             $parent_category = CategoryModel::where('category_id',$parent_category_id)->first();

             $main_category   = CategoryModel::where('category_id',$main_category_id)->first();

             if(!empty($parent_category)){

                $parent_category_name=$parent_category->category_name;

             }

             if(!empty($main_category)){

                $main_category_name=$main_category->category_name;

             }

             



            if ($sub_category_id != "") 

            {

                $sub_category = CategoryModel::where('category_id',$sub_category_id)->first();

                if(!empty($sub_category)){

                    $sub_category_name    = $sub_category->category_name;

                 }

                



            }

        }

        else

        {

            $menu_details_array = [];

        }



        // Get Chef questions

        $chef_questions_array = ChefQuestion::where('restaurant_id',$restaurant_id)->where('menu_id',$id)->get();



        // get Menu Image



        // Get Tag icon

        $tag_name = "";

        if (!empty($tag_id)) 

        { 

            

            $tag_detail_data = TagModel::select('tag_name')->whereIn('tag_id',explode(",",$tag_id))->get();

            if(!empty($tag_detail_data)){

                $tagName =array();

                foreach($tag_detail_data as $tag){

                    $tagName []=$tag->tag_name;

                }

                $tag_name= implode(", ",$tagName);

            }

        }

        $allergy_name = "";

        if (!empty($allergy_id)) 

        { 

            

            $allergy_detail_data = AllergyModel::select('allergy_name')->whereIn('allergy_id',explode(",",$allergy_id))->get();

            if(!empty($allergy_detail_data)){

                $allergyName =array();

                foreach($allergy_detail_data as $allergy){

                    $allergyName []=$allergy->allergy_name;

                }

                $allergy_name= implode(", ",$allergyName);

            }

        } 

        return view('menu/view',['restaurant_name' => $restaurant_name, 'menu_detail' => $menu_details_array, 'chef_questions' => $chef_questions_array, 'currency_icon' => $currency_icon, 'tag_name' => $tag_name, 'parent_category_name' => $parent_category_name, 'main_category_name' => $main_category_name, 'sub_category_name' => $sub_category_name, 'menu_reviews' => $menu_reviews, 'menu_ratings' => $menu_ratings,'allergy_name'=>$allergy_name]);

    }



    // Edit menu form

    public function update($id)

    {



        $restaurant_name = "";

        $restaurant_id = '';

        $restaurant_details=array();

        // Get menu details

        $menu_details_array = MenuModel::where('menu_id',$id)->with('menu_image_detail')->first();

        if(!empty($menu_details_array))

        {   

            $parent_category = $menu_details_array->parent_category;

            $main_category   = $menu_details_array->main_category;



            // Get restaurant name

            $restaurant_details = RestaurantModel::where('restaurant_id',$menu_details_array->restaurant_id)->with('parent_category_detail')->first();

            $restaurant_name=$restaurant_details->restaurant_name;

            $restaurant_id= $restaurant_details->restaurant_id;

        }

        else

        {

            $menu_details_array = [];

        }

        $parent_category_array=array();

        // Get Parent Categories

        if(!empty($restaurant_details->parent_category_detail)){

            $parent_category_array = $restaurant_details->parent_category_detail;

        }



        // Get Main Categories

        $main_category_array=array();

        $main_categories = CategoryModel::where('restaurant_id',$restaurant_id)->where('parent_category_id',$parent_category)->where('category_type','1')->get();

        if(!empty($main_categories)){

            $main_category_array= $main_categories;

        }





        // Get Sub Categories

        $sub_category_array=array();

        $sub_categories = CategoryModel::where('restaurant_id',$restaurant_id)->where('parent_category_id',$parent_category)->where('main_category_id',$main_category)->where('category_type','2')->get();

        if(!empty($sub_categories)){

            $sub_category_array= $sub_categories; 

        }



        // Get Chef questions

        $chef_questions_array=array();

        $chef_questions_array = ChefQuestion::where('restaurant_id',$restaurant_id)->where('menu_id',$id)->get();

       // Get Tags

        $tags_array = TagModel::all();

        $allergies_array=array();

        $allergies_array = AllergyModel::all();



      //echo "<pre>"; print_r($menu_details_array); echo "</pre>"; exit();

        return view('menu/edit',['restaurant_name' => $restaurant_name, 'menu_detail' => $menu_details_array,'parent_categories' => $parent_category_array,'main_categories' => $main_category_array,'sub_categories' => $sub_category_array,'chef_questions' => $chef_questions_array, 'tag_list' => $tags_array,'allergies_list' =>$allergies_array]);

    }



    // Validate and Update menu Details

    public function update_restaurant_menu(Request $request)

    {

        $price_array = array_filter($request->price, function($x) { return !empty($x); });

        $price_des_array =$request->price_des;

        $restaurant_id = $request->restaurant_id;

        $restaurant_name='';

        // Get current restaurant row

        $restaurants = RestaurantModel::where('restaurant_id',$restaurant_id)->first();



        if (!empty($restaurants)) 

        {

            $restaurant_name=$restaurants->restaurant_name;

            $menu_id = $request->menu_id;



            // Get menu details

            $menu_details_array = MenuModel::find($menu_id);

            if(!empty($menu_details_array))

            {   

                // Get restaurant name

               $restaurant_id   = $menu_details_array->restaurant_id;



                $current_menu_image = $menu_details_array->menu_image;

                $current_menu_other_image = $menu_details_array->menu_other_image;



                if ($current_menu_image == "") 

                {

                    $validator = Validator::make($request->all(), [

                        'name'            => 'required',

                        'parent_category' => 'required',

                        'main_category'   => 'required',

                        'availiblity'     => 'required',

                        'ingredients'     => 'required',

                        'calories'        => 'required',

                        'description'     => 'required',

                        'menu_image'      => 'mimes:jpeg,png',

                    ]);

                }

                else

                {

                    $validator = Validator::make($request->all(), [

                        'name'            => 'required',

                        'parent_category' => 'required',

                        'main_category'   => 'required',

                        'availiblity'     => 'required',

                        'ingredients'     => 'required',

                        'calories'        => 'required',

                        'description'     => 'required',

                        'menu_image'      => 'mimes:jpeg,png',

                    ]);

                }



                if ($validator->passes()){

                    if(!empty($price_array)){

                        $price = implode(',', $price_array);

                        $price_des = implode(',', $price_des_array);

                    }else{

                        return response()->json(['priceerror'=>'Atleast one menu price is required']);

                        

                    }

                    if(!empty($request->link)){

                        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 

                        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 

                        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 

                        $regex .= "(\:[0-9]{2,5})?"; // Port 

                        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 

                        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 

                        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

                        if(preg_match("/^$regex$/i",$request->link)){ // `i` flag for case-insensitive

                            $menu_link = $request->link;

                        }else{

                            return response()->json(['link_error'=>'Link format is invalid']);

                        }

                    }else{

                        $menu_link='';

                    }



                    $raise_option_error = 0;

                    $option_ids = [];

                    $other_option_ids = [];



                    // Add chef's question

                    for ($i=0; $i <5; $i++) 

                    { 

                        if(request('question'.$i) != "")

                        {

                            if (request('option_1'.$i) == "" && request('option_2'.$i) == "" && request('option_3'.$i) == "" && request('option_4'.$i) == "" && request('option_5'.$i) == ""  ) 

                            {

                                $raise_option_error = 1;

                                $option_ids[] = array('question'.$i => "Atleast one option is required");

                            }

                            else

                            {

                                $other_option_ids[] = array('question'.$i => "");

                            }

                        }

                    }



                    if ($raise_option_error) 

                    {

                        $all_other_option_ids = [];



                        $all_other_option_ids[] = array_merge($option_ids, $other_option_ids);



                        return response()->json(['option_error'=> $all_other_option_ids]);

                    }

                    else

                    {

                        // Update Data

                        $tag_ids = "";

                        if (!empty($request->tag_id)){

                            $tag_ids_array = [];

                            foreach ($request->tag_id as $key => $value){

                                if ($value != "") 

                                {

                                    $tag_ids_array[] = $value;

                                }

                            }

                            $tag_ids = implode(",", $tag_ids_array);

                        }

                            $allergies_ids = "";

                        if (!empty($request->allergies)) 

                        {

                            $allergies_ids_array = [];

                            foreach ($request->allergies as $alergies_key => $alergies_value) 

                            {

                                if ($alergies_value != "") 

                                {

                                    $allergies_ids_array[] = $alergies_value; 

                                }

                            }

                            $allergies_ids = implode(",", $allergies_ids_array);

                        }

                        $menu_slugs=strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-',$request->name)));

                        $regex = "/\-+$/";

                        $menu_slug= preg_replace($regex, "", $menu_slugs);

                        $menuName_check = DB::table('menus')->whereNotIn('menu_id',[$menu_id])->where('slug',$menu_slug)->get()->count();

                        if($menuName_check > 0){

                            $menuSlug= $menu_slug.''.rand(pow(10, 2-1), pow(10, 2)-1);

                        }else{

                            $menuSlug= $menu_slug;

                        }

                        //echo $menuSlug;  exit();

                        

                        // Update row

                        $menu_item = MenuModel::where('menu_id',$menu_id)->first();

                        $menu_item->restaurant_id  = $restaurant_id;

                        $menu_item->name           = $request->name;

                        $menu_item->slug           = $menuSlug;

                        $menu_item->price         = $price;

                        $menu_item->price_description = $price_des;

                        $menu_item->parent_category= $request->parent_category;

                        $menu_item->main_category  = $request->main_category;

                        $menu_item->sub_category   = $request->sub_category;

                        $menu_item->availiblity    = $request->availiblity;

                        $menu_item->ingredients    = $request->ingredients;

                        $menu_item->allergies      = trim($allergies_ids);

                        $menu_item->calories       = $request->calories;

                        $menu_item->link     = $menu_link;

                        $menu_item->tag_id         = trim($tag_ids);

                        $menu_item->description    = $request->description;

                        $menu_item->updated_at     = date('Y-m-d H:i:s');

                        $row_updated=$menu_item->save();





                            



                        if($row_updated) 

                        {   

                            if(!empty($request->menu_image_id)){

                                $i=0;

                                foreach ($request->menu_image_id as $menu_image_id) {

                                    $menu_item_image= MenuImage::find($menu_image_id);

                                    if($i == 0){

                                        if(!empty($menu_item_image)){

                                            $menu_item->menu_image = $menu_item_image->image_name;

                                            $menu_item->save();

                                            $menu_item_image->delete();

                                        }

                                    }else{

                                        $menu_item_image->menu_id= $menu_id;

                                        $menu_item_image->save();

                                    }

                                   $i = $i + 1;

                                }

                               

                                $delete_menu_item_image= MenuImage::where('restaurant_id',$restaurant_id)->where('menu_id',$menu_id)->whereNotIn('id',$request->menu_image_id)->get();

                                

                                if(!empty($delete_menu_item_image)){   

                                    foreach ($delete_menu_item_image as  $delete_image){

                                        $destinationPath = config('images.menu_url').$restaurant_id;

                                        // Delete current file

                                        File::delete($destinationPath.'/'.$delete_image->image_name);

                                        $menu_item_image= MenuImage::find($delete_image->id)->delete();



                                    }

                                }

                            }





                            // Get Chef questions

                            $chef_questions_array = array();



                            $chef_questions = ChefQuestion::where('restaurant_id',$restaurant_id)->where('menu_id',$menu_id)->get();

                            if(!empty($chef_questions))

                            {   

                                foreach ($chef_questions as $key => $value) 

                                {

                                    

                                    $chef_questions_array[] = $value->chef_question_id;

                                }



                            }

                            else

                            {

                                $chef_questions_array = [];

                            }



                            // Add-edit chef's questions

                            $current_chef_questions_array = array();



                            for ($i=0; $i <5; $i++) 

                            { 

                                if(request('chef_question_id'.$i) != "")

                                {

                                    $chef_question_id = request('chef_question_id'.$i);



                                    $current_chef_questions_array[] = $chef_question_id;



                                    $chef_question_data = ChefQuestion::where('chef_question_id',$chef_question_id)->first();



                                    

                                    $chef_question_data->question = request('question'.$i);

                                    $chef_question_data->option_1 = request('option_1'.$i);

                                    $chef_question_data->option_2 = request('option_2'.$i);

                                    $chef_question_data->option_3 = request('option_3'.$i);

                                    $chef_question_data->option_4 = request('option_4'.$i);

                                    $chef_question_data->option_5 = request('option_5'.$i);

                                    $chef_question_data->updated_at = date('Y-m-d H:i:s');

                                    $chef_question_data->save();

                                }

                                else

                                {

                                    // Add new data

                                    if(request('question'.$i) != "")

                                    {

                                        $chef_question_data = new ChefQuestion();

                                        $chef_question_data->menu_id= $menu_id;

                                        $chef_question_data->restaurant_id = $restaurant_id;

                                        $chef_question_data->question = request('question'.$i);

                                        $chef_question_data->option_1 = request('option_1'.$i);

                                        $chef_question_data->option_2 = request('option_2'.$i);

                                        $chef_question_data->option_3 = request('option_3'.$i);

                                        $chef_question_data->option_4 = request('option_4'.$i);

                                        $chef_question_data->option_5 = request('option_5'.$i);

                                        $chef_question_data->created_at = date('Y-m-d H:i:s');

                                        $chef_question_data->save();

                                    }

                                }

                            }



                            // Remove elements from DB

                            $questions_array_to_remove = array_diff($chef_questions_array, $current_chef_questions_array);

                            



                            if (count($questions_array_to_remove) > '0') 

                            {

                                foreach ($questions_array_to_remove as $key => $value) 

                                {

                                    $delete_question = ChefQuestion::where('chef_question_id',$value)->first()->delete();

                                    //echo "<pre>"; print_r($delete_question); echo"</pre>"; exit();

                                }

                            }



                            return response()->json(['success'=>'Data updated successfully!']);

                        }

                        else

                        {

                            return response()->json(['errors'=>'Error while updating data']);

                        }

                    }

                }



                return response()->json(['error'=>$validator->errors()]);

            }

            else

            {

                return response()->json(['errors'=>'Incorrect Menu details']);

            }

        }

        else

        {

            return response()->json(['errors'=>'Incorrect restaurant details']);

        }

    }



    // Delete menu details

    public function delete($id)

    {

        $restaurant_id = "";



        // Get menu details

        $menu_details_array = MenuModel::find($id);

        if(!empty($menu_details_array)) 

        {   

            $restaurant_id = $menu_details_array->restaurant_id;



            $delete_chef_question =ChefQuestion::where('menu_id',$id)->get();

            if(!empty($delete_chef_question)){

                foreach ($delete_chef_question as $value){

                    $value->delete();

                    

                }



            }

            $delete_menu=$menu_details_array->delete(); 

            if ($delete_menu) 

            {

                // return $this->index($restaurant_id);

                return redirect()->route('menu',$restaurant_id);

            }

            else

            {

                return back()->with('error','Error while deleting menu details.');

            }

        }

        else

        {

            return back()->with('error','Incorrect Menu Details');

        }        

    }



    // Menu Filters 

    public function filters(Request $request){

        $restaurant_id = $request->restaurant_id;

        if ($restaurant_id != "") 

        {

            $parent_category_id = $request->filter_parent_category;

            $main_category_id   = $request->filter_main_category;

            $sub_category_id    = $request->filter_sub_category;



            $restaurant_details = RestaurantModel::where('restaurant_id',$restaurant_id)->with('currency_detail','parent_category_detail')->first();

            $restaurant_name=" ";

            $currency_icon=" ";

            $parent_categories=array();



            if (!empty($restaurant_details)) 

            {

                $restaurant_name = $restaurant_details->restaurant_name;



                // Get Currency icon

                if(!empty($restaurant_details->currency_detail)){

                    $currency_icon=$restaurant_details->currency_detail->currency_icon;

                }

                    

                // Get Parent Categories

                if(!empty($restaurant_details->parent_category_detail)){

                    $parent_categories =$restaurant_details->parent_category_detail;

                }

                $menu_detail= MenuModel::select('*');

                if(!empty($restaurant_id)){

                    $menu_detail->where('restaurant_id',$restaurant_id);

                }

                if(!empty($parent_category_id)){

                    $menu_detail->where('parent_category',$parent_category_id);

                }

                if(!empty($main_category_id)){$menu_detail->where('main_category',$main_category_id);}

                if(!empty($sub_category_id)){$menu_detail->where('sub_category',$sub_category_id);}

                 $menu_data=$menu_detail->orderBy('order_display','ASC')->get();

                 // echo "<pre>"; print_r($menu_data); echo "</pre>"; exit();

                $filters_array=array();

                 if(!empty($menu_data)){

                    foreach($menu_data as $menu_value){

                        if(!empty($menu_value->tag_id)){

                            $tag_detail_data = TagModel::whereIn('tag_id',explode(",",$menu_value->tag_id))->get();

                            if(!empty($tag_detail_data)){

                                $menu_value->tag_details=$tag_detail_data;

                            }else{

                                $menu_value->tag_details=array();

                            }  

                        }

                        $filters_array []= $menu_value;

                    }

                }else{

                    $filters_array=array();

                }

                // Get Main Categories

                $main_categories=array();

                $main_categories_all = CategoryModel::where('restaurant_id',$restaurant_id)->where('parent_category_id',$parent_category_id)->where('category_type','1')->get();

                if(!empty($main_categories_all)){

                    $main_categories= $main_categories_all;

                }



                // Get Sub Categories

                $sub_categories=array();

                $sub_categories_all = CategoryModel::where('restaurant_id',$restaurant_id)->where('parent_category_id',$parent_category_id)->where('main_category_id',$main_category_id)->where('category_type','2')->get();

                if(!empty($sub_categories_all)){

                    $sub_categories= $sub_categories_all;

                }





                return view('menu/index',['restaurant_id' => $restaurant_id,'restaurant_name' => $restaurant_name, 'menu_list' => $filters_array, 'currency_icon' => $currency_icon, 'parent_categories_array' => $parent_categories, 'main_categories_array' => $main_categories, 'sub_categories_array' => $sub_categories, 'filter_parent_category' => $parent_category_id, 'filter_main_category' => $main_category_id, 'filter_sub_category' => $sub_category_id]);

            }

            else

            {

                return $this->index($restaurant_id);

            }

        }

        else

        {

            return Redirect::to('home');

        }

    }

    // Add  menu Image 

    public function add_menu_image(Request $request){

            $menu_image =new MenuImage();

            $restaurant_id=$request->restaurant_id;

            $file = $request->file('filename'); 



            $image_name = explode(".", $file->getClientOriginalName());

            $menuImageName = $image_name[0].'-'.mt_rand(100000,999999).".".$image_name[1];

            //Move Uploaded File

            $destinationPath = config('images.menu_url').$restaurant_id;

            $file->move($destinationPath,$menuImageName);



            $menu_image->image_name=$menuImageName;

            $menu_image->restaurant_id=$restaurant_id;

            $is_save=$menu_image->save();

            if($is_save) 

            {

                return response()->json(['success'=>$menu_image]);

            }

            else

            {

                return response()->json(['error'=>'Error while deleting menu details.']);

            }

                

    }

    // Import menu Item

    // public function import_menu(Request $request){

    //     $current_restaurent_id = $request->restaurant_id;

    //     $validator = Validator::make($request->all(), [

    //         'csv_file' => 'required|mimes:csv,txt'

    //     ]);

    //     if ($validator->passes()){

    //         $filename=$request->file('csv_file');

    //         $delimiter = ',';

    //         $header='';

    //         $data = array();

    //         if (($handle = fopen($filename, 'r')) !== false){

    //             while (($row = fgetcsv($handle, 1000, $delimiter)) !== false){

    //                 if (!$header){

    //                     $header = $row;

    //                 }

    //                 else{

    //                     $data[] = array_combine($header, $row);

    //                 }

    //             } 

    //         } 



    //         foreach ($data as $menuData) {

    //             if($current_restaurent_id == $menuData['restaurant_id']){



    //                 $restaurant_id='';

    //                 if (!empty($request->restaurant_id)){

    //                     $restaurant_details = RestaurantModel::where('restaurant_id',$menuData['restaurant_id'])->first();

    //                     if(!empty($restaurant_details)){

    //                         $restaurant_id = $menuData['restaurant_id'];

    //                     }

    //                 }

    //                 $parent_category_id = '';

    //                 if(!empty($menuData['parent_catrgory'])){

    //                     $validate_parent_category = CategoryModel::where('category_id',$menuData['parent_catrgory'])->where('restaurant_id',$menuData['restaurant_id'])->count();

    //                     if($validate_parent_category !== 0)

    //                     {

    //                         $parent_category_id = $menuData['parent_catrgory']; 

    //                     }

    //                 }

    //                 $main_category_id = '';

    //                 if(!empty($menuData['main_category'])){

    //                     $validate_main_category = CategoryModel::where('category_id',$menuData['main_category'])->where('parent_category_id',$menuData['parent_catrgory'])->where('restaurant_id',$menuData['restaurant_id'])->count();



    //                     if($validate_main_category !== 0){

    //                         $main_category_id = $menuData['main_category'];

    //                     }

    //                 }

    //                 $sub_category_id = '';

    //                 if(!empty($menuData['sub_catrgory']) && !empty($menuData['parent_catrgory']) && !empty($menuData['restaurant_id']) && !empty($menuData['main_category'])){

    //                     $validate_sub_category = CategoryModel::where('category_id',$menuData['sub_catrgory'])->where('parent_category_id',$menuData['parent_catrgory'])->where('main_category_id',$menuData['main_category'])->where('restaurant_id',$menuData['restaurant_id'])->count();

    //                     if($validate_sub_category !== 0){

    //                         $sub_category_id = $menuData['sub_catrgory'];

    //                     }

    //                 }

    //                 $menu_name = '';

    //                 if(!empty($menuData['name'])){ 

    //                     $menu_name = $menuData['name'];

    //                 }

    //                 $menu_des = '';

    //                 if(!empty($menuData['description'])){

    //                     $menu_des = $menuData['description'];

    //                 }

    //                 $menu_price = '';

    //                 if(!empty($menuData['price'])){

    //                     $menu_price = $menuData['price'];

    //                 }

    //                 $menu_price_des = '';

    //                 if(!empty($menuData['price_description'])){

    //                     $menu_price_des = $menuData['price_description'];

    //                 }

    //                 $menu_availiblity='';

    //                 if($menuData['availiblity'] == 0 || $menuData['availiblity'] == 1 || $menuData['availiblity'] == 2 ){

    //                     $menu_availiblity = $menuData['availiblity'];

    //                 }

    //                 $menu_ingredients = '';

    //                 if(!empty($menuData['ingredients'])){

    //                     $menu_ingredients = $menuData['ingredients'];

    //                 }

    //                 if(!empty($menuData['allergies'])){

    //                     $validate_allergy_array = AllergyModel::whereIn('allergy_id',explode(",",$menuData['allergies']))->get();

    //                     $menu_allergy = array();

    //                     foreach($validate_allergy_array as $alleryData){

    //                         $menu_allergy[] = $alleryData['allergy_id'];

    //                     }

    //                     $avilible_allergy_id = implode(",",$menu_allergy);

    //                 }else{

    //                     $avilible_allergy_id = '';

    //                 }

    //                 if(!empty($menuData['tag_id'])){

    //                     $validate_tag_array = TagModel::whereIn('tag_id',explode(",",$menuData['tag_id']))->get();

    //                     $menu_tag = array();

    //                     foreach($validate_tag_array as $tagData){

    //                         $menu_tag[] = $tagData['tag_id'];

    //                     }

    //                     $avilible_tag_id = implode(",",$menu_tag);

    //                 }else{

    //                     $avilible_tag_id = '';

    //                 }

    //                 $menu_calories = '';

    //                 if(!empty($menuData['calories'])){

    //                     $menu_calories = $menuData['calories'];

    //                 }

    //                 $menu_link = '';

    //                 if(!empty($menuData['link'])){

    //                     $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 

    //                     $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 

    //                     $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 

    //                     $regex .= "(\:[0-9]{2,5})?"; // Port 

    //                     $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 

    //                     $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 

    //                     $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 

    //                     if(preg_match("/^$regex$/i",$menuData['link'])){ // `i` flag for case-insensitive

    //                         $menu_link = $menuData['link'];

    //                     } 

    //                 } 

    //                 if(!empty($restaurant_id) && !empty($menu_name) && !empty($menu_des) && !empty($menu_price) && !empty($menu_price_des) && !empty($parent_category_id) && !empty($main_category_id) && !empty($sub_category_id) && !empty($menu_availiblity) && !empty($menu_ingredients) && !empty($avilible_allergy_id) && !empty($menu_calories) && !empty($menu_link) && !empty($avilible_tag_id)){



    //                     $menu_slugs=strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-',$menu_name)));

    //                     $regex = "/\-+$/";

    //                     $menu_slug= preg_replace($regex, "", $menu_slugs);

    //                     $menuName_check = DB::table('menus')->where('slug',$menu_slug)->get()->count();

    //                     if($menuName_check > 0){

    //                         $menuSlug= $menu_slug.''.rand(pow(10, 2-1), pow(10, 2)-1);

    //                     }else{

    //                         $menuSlug= $menu_slug;  

    //                     }



                        

    //                          // Add row

    //                     $menu_create = new MenuModel ();

    //                     $menu_create->restaurant_id  = $restaurant_id;

                        

    //                     $menu_create->name           = $menu_name;

    //                     $menu_create->slug           = $menuSlug;

    //                     $menu_create->description    = $menu_des;

    //                     $menu_create->price         = $menu_price;

    //                     $menu_create->price_description = $menu_price_des;

    //                     $menu_create->parent_category = $parent_category_id;

    //                     $menu_create->main_category  = $main_category_id;

    //                     $menu_create->sub_category  =  $sub_category_id;

    //                     $menu_create->availiblity    = $menu_availiblity;

    //                     $menu_create->ingredients   = $menu_ingredients;

    //                     $menu_create->allergies     = $avilible_allergy_id;

    //                     $menu_create->calories     = $menu_calories;

    //                     $menu_create->link     = $menu_link;

    //                     $menu_create->tag_id       = $avilible_tag_id;

    //                     $menu_create->created_at     = date('Y-m-d H:i:s');



    //                     $last_order_menu = MenuModel::where('restaurant_id',$restaurant_id)->where('parent_category',$parent_category_id)->where('main_category',$main_category_id)->where('sub_category',$sub_category_id)->orderBy('order_display', 'desc')->first();

    //                     if(!empty($last_order_menu)){

    //                         $menu_create->order_display = $last_order_menu->order_display + 1;

    //                     }else{

    //                         $menu_create->order_display = 1;

    //                     }

    //                     $is_save=$menu_create->save();

    //                 }

    //             }

    //         }

    //         return response()->json(['success'=> 'Menu data added successfully']);

            

    //     }

    //     return response()->json(['error'=>$validator->errors()]);

        

    // }
    public function import_menu(Request $request){

        $current_restaurent_id = $request->restaurant_id;
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv,txt'
        ]);
        if ($validator->passes()){
            $filename=$request->file('csv_file');
            $delimiter = ',';
            $header='';
            $data = array();
            if (($handle = fopen($filename, 'r')) !== false){
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false){
                    if (!$header){
                        $header = $row;
                    }
                    else{
                        $data[] = array_combine($header, $row);
                    }
                } 
            } 

            if(!empty($data)){ 
                foreach ($data as $menuData) {
                    if(!empty($current_restaurent_id)){

                        $restaurant_id='';
                        if (!empty($request->restaurant_id)){
                            $restaurant_details = RestaurantModel::where('restaurant_id',$current_restaurent_id)->first();
                            if(!empty($restaurant_details)){
                                $restaurant_id = $current_restaurent_id;
                            }
                        }
                        $parent_category_id = '';
                        if(!empty($menuData['parent_catrgory'])){
                            $validate_parent_category = CategoryModel::where('category_id',$menuData['parent_catrgory'])->where('restaurant_id',$current_restaurent_id)->count();
                            if($validate_parent_category !== 0)
                            {
                                $parent_category_id = $menuData['parent_catrgory']; 
                            }
                        }
                        $main_category_id = '';
                        if(!empty($menuData['main_category'])){
                            $validate_main_category = CategoryModel::where('category_id',$menuData['main_category'])->where('parent_category_id',$menuData['parent_catrgory'])->where('restaurant_id',$current_restaurent_id)->count();

                            if($validate_main_category !== 0){
                                $main_category_id = $menuData['main_category'];
                            }
                        }
                        $sub_category_id = '';
                        if(!empty($menuData['sub_catrgory']) && !empty($menuData['parent_catrgory']) && !empty($current_restaurent_id) && !empty($menuData['main_category'])){
                           $validate_sub_category = CategoryModel::where('category_id',$menuData['sub_catrgory'])->where('parent_category_id',$menuData['parent_catrgory'])->where('main_category_id',$menuData['main_category'])->where('restaurant_id',$current_restaurent_id)->count();
                           if($validate_sub_category !== 0){
                                $sub_category_id = $menuData['sub_catrgory'];
                            }
                        }
                        $menu_name = '';
                        if(!empty($menuData['name'])){ 
                            $menu_name = $menuData['name'];
                        }
                        $menu_des = '';
                        if(!empty($menuData['description'])){
                            $menu_des = $menuData['description'];
                        }
                        $menu_price = '';
                        if(!empty($menuData['price'])){
                            $menu_price = $menuData['price'];
                        }
                        $menu_price_des = '';
                        if(!empty($menuData['price_description'])){
                            $menu_price_des = $menuData['price_description'];
                        }
                        $menu_availiblity='';
                        if($menuData['availiblity'] == 0 || $menuData['availiblity'] == 1 || $menuData['availiblity'] == 2 ){
                            $menu_availiblity = $menuData['availiblity'];
                        }
                        $menu_ingredients = '';
                        if(!empty($menuData['ingredients'])){
                            $menu_ingredients = $menuData['ingredients'];
                        }
                        if(!empty($menuData['allergies'])){
                            $validate_allergy_array = AllergyModel::whereIn('allergy_id',explode(",",$menuData['allergies']))->get();
                            $menu_allergy = array();
                            foreach($validate_allergy_array as $alleryData){
                                $menu_allergy[] = $alleryData['allergy_id'];
                            }
                            $avilible_allergy_id = implode(",",$menu_allergy);
                        }else{
                            $avilible_allergy_id = '';
                        }
                        if(!empty($menuData['tag_id'])){
                            $validate_tag_array = TagModel::whereIn('tag_id',explode(",",$menuData['tag_id']))->get();
                            $menu_tag = array();
                            foreach($validate_tag_array as $tagData){
                                $menu_tag[] = $tagData['tag_id'];
                            }
                            $avilible_tag_id = implode(",",$menu_tag);
                        }else{
                            $avilible_tag_id = '';
                        }
                        $menu_calories = '';
                        if(!empty($menuData['calories'])){
                            $menu_calories = $menuData['calories'];
                        }
                        $menu_link = '';
                        if(!empty($menuData['link'])){
                            $regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
                            $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
                            $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
                            $regex .= "(\:[0-9]{2,5})?"; // Port 
                            $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
                            $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
                            $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
                            if(preg_match("/^$regex$/i",$menuData['link'])){ // `i` flag for case-insensitive
                                $menu_link = $menuData['link'];
                            } 
                        } 
                        
                        if(!empty($restaurant_id) && !empty($menu_name) && !empty($menu_des) && !empty($menu_price) && !empty($menu_price_des) && !empty($parent_category_id) && !empty($main_category_id) && !empty($sub_category_id) && !empty($menu_availiblity) && !empty($menu_ingredients) && !empty($avilible_allergy_id) && !empty($menu_calories) && !empty($menu_link) && !empty($avilible_tag_id)){

                            $menu_slugs=strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-',$menu_name)));
                            $regex = "/\-+$/";
                            $menu_slug= preg_replace($regex, "", $menu_slugs);
                            $menuName_check = DB::table('menus')->where('slug',$menu_slug)->get()->count();
                            if($menuName_check > 0){
                                $menuSlug= $menu_slug.''.rand(pow(10, 2-1), pow(10, 2)-1);
                            }else{
                                $menuSlug= $menu_slug;  
                            }

                            
                                 // Add row
                            $menu_create = new MenuModel ();
                            $menu_create->restaurant_id  = $restaurant_id;
                            
                            $menu_create->name           = $menu_name;
                            $menu_create->slug           = $menuSlug;
                            $menu_create->description    = $menu_des;
                            $menu_create->price         = $menu_price;
                            $menu_create->price_description = $menu_price_des;
                            $menu_create->parent_category = $parent_category_id;
                            $menu_create->main_category  = $main_category_id;
                            $menu_create->sub_category  =  $sub_category_id;
                            $menu_create->availiblity    = $menu_availiblity;
                            $menu_create->ingredients   = $menu_ingredients;
                            $menu_create->allergies     = $avilible_allergy_id;
                            $menu_create->calories     = $menu_calories;
                            $menu_create->link     = $menu_link;
                            $menu_create->tag_id       = $avilible_tag_id;
                            $menu_create->created_at     = date('Y-m-d H:i:s');

                            $last_order_menu = MenuModel::where('restaurant_id',$restaurant_id)->where('parent_category',$parent_category_id)->where('main_category',$main_category_id)->where('sub_category',$sub_category_id)->orderBy('order_display', 'desc')->first();
                            if(!empty($last_order_menu)){
                                $menu_create->order_display = $last_order_menu->order_display + 1;
                            }else{
                                $menu_create->order_display = 1;
                            }
                            $is_save=$menu_create->save();
                            return response()->json(['success'=> 'Menu data added successfully']);
                        }else{
                            return response()->json(['errors'=> 'Something went wrong']);
                        }
                    }else{
                        return response()->json(['errors'=> 'Something went wrong']);
                    }
                }
            }else{
                return response()->json(['errors'=> 'Something went wrong']);
            }
            // return response()->json(['success'=> 'Menu data added successfully']);
            
        }
        return response()->json(['error'=>$validator->errors()]);
        
    }

     public function save_menu_order(Request $request){

        // echo "<pre>"; print_r($request->all()); echo "</pre>"; exit();

        $i=1;

        foreach($request->menu_id as $menu_id){

            $menu_details = MenuModel::where('restaurant_id',$request->restaurant_id)->where('menu_id',$menu_id)->where('parent_category',$request->parent_caregory_id)->where('main_category',$request->main_category_id)->where('sub_category',$request->sub_category_id)->first();

            $menu_details->order_display=$i;

            $menu_details->save();

            $i++;

        }

        return response()->json(['success'=>'success']);

    }   

}

