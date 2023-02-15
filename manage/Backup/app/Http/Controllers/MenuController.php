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
                $parent_categories =$restaurant_detail->parent_category_detail;
            }
            

        }
        // Get Menus
        $menu_data = MenuModel::where('restaurant_id',$id)->count();
        
        if(!empty($menu_data)){
            $menu_data = MenuModel::where('restaurant_id',$id)->get();
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
        

        return view('menu/create',['restaurant_id'=>$id,'restaurant_name' => $restaurant_name,'parent_categories' => $parent_category_array,'main_categories' => $main_category_array,'sub_categories' => $sub_category_array,'tag_list' => $tags_array]);
    }

    // Validate and Add menu
    public function create_restaurant_menu(Request $request)
    {
        $restaurant_id = $request->restaurant_id;

        // Get current restaurant row
        $restaurant_details = RestaurantModel::where('restaurant_id',$restaurant_id)->first();
        if (!empty($restaurant_details)) 
        {
            $validator = Validator::make($request->all(), [
                'name'            => 'required',
                'price'           => 'required|numeric',
                'parent_category' => 'required',
                'main_category'   => 'required',
                'availiblity'     => 'required',
                'ingredients'     => 'required',
                'calories'        => 'required',
                'description'     => 'required',
                'menu_image'      => 'mimes:jpeg,png',
            ]);

            if ($validator->passes()) 
            {
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
                    $file = $request->file('menu_image');

                    if (!empty($file)) 
                    {
                        $image_name = explode(".", $file->getClientOriginalName());
                        $menu_image = $image_name[0].'-'.time().".".$image_name[1];

                        //Move Uploaded File
                        $destinationPath = config('images.menu_url').$restaurant_id;
                        
                        $file->move($destinationPath,$menu_image);
                    }
                    else
                    {
                        $menu_image = "";
                    }

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
                    // Add row
                    $menu_create = new MenuModel ();
                    $menu_create->restaurant_id  = $restaurant_id;
                    $menu_create->name           = $request->name;
                    $menu_create->price         = $request->price;
                    $menu_create->parent_category = $request->parent_category;
                    $menu_create->main_category  = $request->main_category;
                    $menu_create->sub_category  = $request->sub_category;
                    $menu_create->availiblity    = $request->availiblity;
                    $menu_create->ingredients   = $request->ingredients;
                    $menu_create->allergies     = $request->allergies;
                    $menu_create->calories     = $request->calories;
                    $menu_create->tag_id       = trim($tag_ids);
                    $menu_create->description   = $request->description;
                    $menu_create->menu_image     = $menu_image;
                    $menu_create->created_at     = date('Y-m-d H:i:s');
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

                        return response()->json(['success'=> 'Menu data added successfully']);
                    }
                    else
                    {
                        return response()->json(['errors'=>'Error while adding data']);
                    }
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
        $menu_details_array = MenuModel::find($id);
        if(!empty($menu_details_array))
        {   
            $tag_id             = $menu_details_array->tag_id;
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
                    $sub_category_name    = $main_category->category_name;
                 }
                

            }
        }
        else
        {
            $menu_details_array = [];
        }

        // Get Chef questions
        $chef_questions_array = ChefQuestion::where('restaurant_id',$restaurant_id)->where('menu_id',$id)->get();
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
        return view('menu/view',['restaurant_name' => $restaurant_name, 'menu_detail' => $menu_details_array, 'chef_questions' => $chef_questions_array, 'currency_icon' => $currency_icon, 'tag_name' => $tag_name, 'parent_category_name' => $parent_category_name, 'main_category_name' => $main_category_name, 'sub_category_name' => $sub_category_name, 'menu_reviews' => $menu_reviews, 'menu_ratings' => $menu_ratings ]);
    }

    // Edit menu form
    public function update($id)
    {

        $restaurant_name = "";
        $restaurant_id = '';
        $restaurant_details=array();
        // Get menu details
        $menu_details_array = MenuModel::find($id);
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
        if(!empty($restaurant_details->parent_category_detail)){
            // Get Parent Categories
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

        return view('menu/edit',['restaurant_name' => $restaurant_name, 'menu_detail' => $menu_details_array,'parent_categories' => $parent_category_array,'main_categories' => $main_category_array,'sub_categories' => $sub_category_array,'chef_questions' => $chef_questions_array, 'tag_list' => $tags_array]);
    }

    // Validate and Update menu Details
    public function update_restaurant_menu(Request $request)
    {
        //echo "<pre>"; print_r($request->all()); echo "</pre>"; exit();
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

                if ($current_menu_image == "") 
                {
                    $validator = Validator::make($request->all(), [
                        'name'            => 'required',
                        'price'           => 'required|numeric',
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
                        'price'           => 'required|numeric',
                        'parent_category' => 'required',
                        'main_category'   => 'required',
                        'availiblity'     => 'required',
                        'ingredients'     => 'required',
                        'calories'        => 'required',
                        'description'     => 'required',
                        'menu_image'      => 'mimes:jpeg,png',
                    ]);
                }

                if ($validator->passes()) 
                {
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
                        $file = $request->file('menu_image');

                        if (!empty($file)) 
                        {
                            $image_name = explode(".", $file->getClientOriginalName());
                            $menu_image = $image_name[0].'-'.time().".".$image_name[1];

                            // File Path
                            $destinationPath = config('images.menu_url').$restaurant_id;

                            // Delete current file
                            File::delete($destinationPath.'/'.$current_menu_image);

                            //Move Uploaded File                        
                            $file->move($destinationPath,$menu_image);
                        }
                        else
                        {
                            $menu_image = $current_menu_image;
                        }

                        // Update Data
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

                        


                        // Update row
                        $menu_item = MenuModel::where('menu_id',$menu_id)->first();
                        $menu_item->restaurant_id  = $restaurant_id;
                        $menu_item->name           = $request->name;
                        $menu_item->price         = $request->price;
                        $menu_item->parent_category= $request->parent_category;
                        $menu_item->main_category  = $request->main_category;
                        $menu_item->sub_category   = $request->sub_category;
                        $menu_item->availiblity    = $request->availiblity;
                        $menu_item->ingredients    = $request->ingredients;
                        $menu_item->allergies      = $request->allergies;
                        $menu_item->calories       = $request->calories;
                        $menu_item->tag_id         = trim($tag_ids);
                        $menu_item->description    = $request->description;
                        $menu_item->menu_image     = $menu_image;
                        $menu_item->updated_at     = date('Y-m-d H:i:s');
                         $row_updated=$menu_item->save();

                        if($row_updated)
                        {
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
    public function filters(Request $request)
    {
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
                if(!empty($restaurant_id)){$menu_detail->where('restaurant_id',$restaurant_id);}
                if(!empty($parent_category_id)){$menu_detail->where('parent_category',$parent_category_id);}
                if(!empty($main_category_id)){$menu_detail->where('main_category',$main_category_id);}
                if(!empty($sub_category_id)){$menu_detail->where('sub_category',$sub_category_id);}
                 $menu_data=$menu_detail->get(); 
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
}
