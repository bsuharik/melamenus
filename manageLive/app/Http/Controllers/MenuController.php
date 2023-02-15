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
        $restaurant_name = RestaurantModel::get_restaurant_name($id);

        // Get Menus
        $menu_array = MenuModel::get_restaurant_menus($id);

        // Get Currency icon
        $currency_icon = CurrencyModel::get_restaurant_currency_icon($id);

        // Get Parent Categories
        $parent_categories = CategoryModel::get_restaurant_categories_by_type($id,'0');

        return view('menu/index',['restaurant_id'=>$id,'restaurant_name' => $restaurant_name, 'menu_list' => $menu_array, 'currency_icon' => $currency_icon, 'parent_categories_array' => $parent_categories, 'main_categories_array' => array(), 'sub_categories_array' => array(), 'filter_parent_category' => '', 'filter_main_category' => '', 'filter_sub_category' => '']);
    }

    // Add menu form
    public function create($id)
    {
        // Get restaurant name
        $restaurant_name = RestaurantModel::get_restaurant_name($id);

        // Get Parent Categories
        $parent_category_array = CategoryModel::get_restaurant_categories_by_type($id,'0');

        // Get Main Categories
        $main_category_array = CategoryModel::get_restaurant_categories_by_type($id,'1');

        // Get Sub Categories
        $sub_category_array = CategoryModel::get_restaurant_categories_by_type($id,'2');

        // Get Tags
        $tags_array = TagModel::get_all_tags();

        return view('menu/create',['restaurant_id'=>$id,'restaurant_name' => $restaurant_name,'parent_categories' => $parent_category_array,'main_categories' => $main_category_array,'sub_categories' => $sub_category_array,'tag_list' => $tags_array]);
    }

    // Validate and Add menu
    public function create_restaurant_menu(Request $request)
    {
        $restaurant_id = $request->restaurant_id;

        // Get current restaurant row
        $restaurant_name = RestaurantModel::get_restaurant_name($restaurant_id);

        if ($restaurant_name) 
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

                    $create_data = array(   
                                            'restaurant_id'   => $restaurant_id,
                                            'name'            => $request->name,
                                            'price'           => $request->price,
                                            'parent_category' => $request->parent_category,
                                            'main_category'   => $request->main_category,
                                            'sub_category'    => $request->sub_category,
                                            'availiblity'     => $request->availiblity,
                                            'ingredients'     => $request->ingredients,
                                            'allergies'       => $request->allergies,
                                            'calories'        => $request->calories,
                                            'tag_id'          => trim($tag_ids),
                                            'description'     => $request->description,
                                            'menu_image'      => $menu_image,
                                            'created_at'      => date('Y-m-d H:i:s')
                                        );

                    // Add row
                    $row_added = MenuModel::create_menu_details($create_data);

                    if($row_added)
                    {
                        $menu_id = $row_added;

                        // Add chef's question
                        for ($i=0; $i <5; $i++) 
                        { 
                            if(request('question'.$i) != "")
                            {
                                $question_data = array(
                                                        'menu_id'       => $menu_id,
                                                        'restaurant_id' => $restaurant_id,
                                                        'question'      => request('question'.$i),
                                                        'option_1'      => request('option_1'.$i),
                                                        'option_2'      => request('option_2'.$i),
                                                        'option_3'      => request('option_3'.$i),
                                                        'option_4'      => request('option_4'.$i),
                                                        'option_5'      => request('option_5'.$i),
                                                        'created_at'    => date('Y-m-d H:i:s')
                                                    );

                                $create_question = MenuModel::create_menu_chef_question_details($question_data);
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
        $menu_details_array = MenuModel::get_one_menu_details($id);

        if($menu_details_array)
        {   
            $tag_id             = $menu_details_array->tag_id;
            $parent_category_id = $menu_details_array->parent_category;
            $main_category_id   = $menu_details_array->main_category;
            $sub_category_id    = $menu_details_array->sub_category;

            // Get restaurant name
            $restaurant_name = RestaurantModel::get_restaurant_name($menu_details_array->restaurant_id);
            $restaurant_id = $menu_details_array->restaurant_id;

            // Get category Name
            $parent_category_name = CategoryModel::get_category_name($parent_category_id);
            $main_category_name   = CategoryModel::get_category_name($main_category_id);

            if ($sub_category_id != "") 
            {
                $sub_category_name    = CategoryModel::get_category_name($sub_category_id);
            }

            // Menu Ratings
            $menu_ratings = MenuModel::get_all_menu_votes($restaurant_id, $id);
        }
        else
        {
            $menu_details_array = [];
        }

        // Get Chef questions
        $chef_questions_array = MenuModel::get_restaurant_menu_chef_questions($restaurant_id,$id);

        // Get Currency icon
        $currency_icon = CurrencyModel::get_restaurant_currency_icon($id);

        // Get Tag icon
        $tag_name = "";
        if ($tag_id != "") 
        {
            $tag_name = TagModel::get_tag_names($tag_id);
        }

        return view('menu/view',['restaurant_name' => $restaurant_name, 'menu_detail' => $menu_details_array, 'chef_questions' => $chef_questions_array, 'currency_icon' => $currency_icon, 'tag_name' => $tag_name, 'parent_category_name' => $parent_category_name, 'main_category_name' => $main_category_name, 'sub_category_name' => $sub_category_name, 'menu_reviews' => $menu_reviews, 'menu_ratings' => $menu_ratings ]);
    }

    // Edit menu form
    public function update($id)
    {
        $restaurant_name = "";
        $restaurant_id = '';

        // Get menu details
        $menu_details_array = MenuModel::get_one_menu_details($id);

        if($menu_details_array)
        {   
            $parent_category = $menu_details_array->parent_category;
            $main_category   = $menu_details_array->main_category;

            // Get restaurant name
            $restaurant_name = RestaurantModel::get_restaurant_name($menu_details_array->restaurant_id);
            $restaurant_id   = $menu_details_array->restaurant_id;
        }
        else
        {
            $menu_details_array = [];
        }

        // Get Parent Categories
        $parent_category_array = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'0');

        // Get Main Categories
        $main_category_array = CategoryModel::get_restaurant_main_categories($restaurant_id,$parent_category);

        // Get Sub Categories
        $sub_category_array = CategoryModel::get_restaurant_sub_categories($restaurant_id,$parent_category,$main_category);

        // Get Chef questions
        $chef_questions_array = MenuModel::get_restaurant_menu_chef_questions($restaurant_id,$id);

        // Get Tags
        $tags_array = TagModel::get_all_tags();

        return view('menu/edit',['restaurant_name' => $restaurant_name, 'menu_detail' => $menu_details_array,'parent_categories' => $parent_category_array,'main_categories' => $main_category_array,'sub_categories' => $sub_category_array,'chef_questions' => $chef_questions_array, 'tag_list' => $tags_array]);
    }

    // Validate and Update menu Details
    public function update_restaurant_menu(Request $request)
    {
        $restaurant_id = $request->restaurant_id;

        // Get current restaurant row
        $restaurant_name = RestaurantModel::get_restaurant_name($restaurant_id);

        if ($restaurant_name) 
        {
            $menu_id = $request->menu_id;

            // Get menu details
            $menu_details_array = MenuModel::get_one_menu_details($menu_id);

            if($menu_details_array)
            {   
                // Get restaurant name
                $restaurant_name = RestaurantModel::get_restaurant_name($menu_details_array->restaurant_id);
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

                        $update_data = array(   
                                                'restaurant_id'   => $restaurant_id,
                                                'name'            => $request->name,
                                                'price'           => $request->price,
                                                'parent_category' => $request->parent_category,
                                                'main_category'   => $request->main_category,
                                                'sub_category'    => $request->sub_category,
                                                'availiblity'     => $request->availiblity,
                                                'ingredients'     => $request->ingredients,
                                                'allergies'       => $request->allergies,
                                                'calories'        => $request->calories,
                                                'tag_id'          => trim($tag_ids),
                                                'description'     => $request->description,
                                                'menu_image'      => $menu_image,
                                                'updated_at'      => date('Y-m-d H:i:s')
                                            );

                        // Update row
                        $row_updated = MenuModel::update_menu_details($menu_id,$update_data);

                        if($row_updated)
                        {
                            // Get Chef questions
                            $chef_questions_array = array();

                            $chef_questions = MenuModel::get_restaurant_menu_chef_questions($restaurant_id,$menu_id);

                            if($chef_questions)
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

                                    // Update current data
                                    $question_data = array(
                                                            'question'   => request('question'.$i),
                                                            'option_1'   => request('option_1'.$i),
                                                            'option_2'   => request('option_2'.$i),
                                                            'option_3'   => request('option_3'.$i),
                                                            'option_4'   => request('option_4'.$i),
                                                            'option_5'   => request('option_5'.$i),
                                                            'updated_at' => date('Y-m-d H:i:s')
                                                        );

                                    $update_question = MenuModel::update_menu_chef_question_details($chef_question_id,$question_data);
                                }
                                else
                                {
                                    // Add new data
                                    if(request('question'.$i) != "")
                                    {
                                        $add_question_data = array(
                                                                'menu_id'       => $menu_id,
                                                                'restaurant_id' => $restaurant_id,
                                                                'question'      => request('question'.$i),
                                                                'option_1'      => request('option_1'.$i),
                                                                'option_2'      => request('option_2'.$i),
                                                                'option_3'      => request('option_3'.$i),
                                                                'option_4'      => request('option_4'.$i),
                                                                'option_5'      => request('option_5'.$i),
                                                                'created_at'    => date('Y-m-d H:i:s')
                                                            );

                                        $create_question = MenuModel::create_menu_chef_question_details($add_question_data);
                                    }
                                }
                            }

                            // Remove elements from DB
                            $questions_array_to_remove = array_diff($chef_questions_array, $current_chef_questions_array);

                            if (count($questions_array_to_remove) > '0') 
                            {
                                foreach ($questions_array_to_remove as $key => $value) 
                                {
                                    $delete_question = MenuModel::delete_menu_chef_question_details($value);
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
        $menu_details_array = MenuModel::get_one_menu_details($id);

        if($menu_details_array)
        {   
            $restaurant_id = $menu_details_array->restaurant_id;

            $delete_menu = MenuModel::delete_menu_details($id);

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

            $restaurant_details = RestaurantModel::get_one_restaurant_details($restaurant_id);

            if ($restaurant_details) 
            {
                $restaurant_name = $restaurant_details->restaurant_name;

                // Get Menus
                $filters_array = MenuModel::get_menus_by_category(
                                                                    $restaurant_id,
                                                                    $parent_category_id,
                                                                    $main_category_id, 
                                                                    $sub_category_id
                                                                );

                // Get Currency icon
                $currency_icon = CurrencyModel::get_restaurant_currency_icon($restaurant_id);

                // Get Parent Categories
                $parent_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'0');

                // Get Main Categories
                $main_categories = CategoryModel::get_restaurant_main_categories($restaurant_id,$parent_category_id);

                // Get Sub Categories
                $sub_categories = CategoryModel::get_restaurant_sub_categories($restaurant_id,$parent_category_id,$main_category_id);

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
