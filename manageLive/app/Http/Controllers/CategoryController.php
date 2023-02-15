<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;

use App\Models\RestaurantModel;
use App\Models\CategoryModel;

class CategoryController extends Controller
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
    public function index($restaurant_id)
    {
        $restaurant_details = RestaurantModel::get_one_restaurant_details($restaurant_id);

        if ($restaurant_details) 
        {
            $restaurant_name = $restaurant_details->restaurant_name;

            // Get Parent Categories
            $parent_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'0');

            // Get Main Categories
            $main_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'1');

            // Get Sub Categories
            $sub_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'2');

            return view('category/index',['restaurant_name' => $restaurant_name, 'parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_id' => $restaurant_id, 'parent_categories_array' => $parent_categories, 'main_categories_array' => array(), 'sub_categories_array' => array(), 'filter_parent_category' => '', 'filter_main_category' => '', 'filter_sub_category' => '']);
        }
        else
        {
            return route('home');
        }
    }

    // Edit menu form
    public function update($id)
    {
        // Get Category details
        $category_details_array = CategoryModel::get_one_category_row($id);

        return view('category/edit',['category_detail' => $category_details_array]);
    }

    // Validate and Update Category Details
    public function update_restaurant_category(Request $request)
    {
        $category_id = $request->category_id;

        // Get category details
        $category_details = CategoryModel::get_one_category_row($category_id);

        if($category_details)
        {   
            $validator = Validator::make($request->all(), [
                                    'category_name' => 'required',
                                ]);

            if ($validator->passes()) 
            {
                $update_data = array(
                                        'category_name' => $request->category_name,
                                        'updated_at'    => date('Y-m-d H:i:s')
                                    );

                // Update row
                $row_updated = CategoryModel::update_category_details($category_id, $update_data);

                if($row_updated)
                {
                    return response()->json(['success'=>'Data updated successfully!']);
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
            return response()->json(['errors'=>'Incorrect Category details']);
        }   
    }

    // Delete Category details
    public function delete($id)
    {
        // Get category detail
        $category_details = CategoryModel::get_one_category_row($id);

        if($category_details)
        {   
            $restaurant_id  = $category_details->restaurant_id;

            // Delete Category
            $delete_category = CategoryModel::delete_category_row($id);

            if ($delete_category) 
            {
                // return $this->index($restaurant_id);
                return redirect()->route('category',$restaurant_id);
            }
            else
            {
                return back()->with('error','Error while deleting category details.');
            }
        }
        else
        {
            return back()->with('error','Incorrect Category Details');
        }        
    }

    // Validate and Add Parent Category
    public function create_parent_category(Request $request)
    {
        $restaurant_id = $request->restaurant_id;

        if ($restaurant_id != "") 
        {
            $validator = Validator::make($request->all(), [
                                        'category_name' => 'required'
                                    ]);

            if ($validator->passes()) 
            {
                $create_data = array(   
                                        'restaurant_id' => $restaurant_id,
                                        'category_type' => '0',
                                        'category_name' => $request->category_name,
                                        'created_at'    => date('Y-m-d H:i:s')
                                    );

                // Add row
                $row_added = CategoryModel::create_category_details($create_data);

                if($row_added)
                {
                    $parent_categories = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'0');

                    return response()->json(['success'=>'Data Added successfully', 'parent_categories' => $parent_categories]);
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

    // Validate and Add Main Category
    public function create_main_category(Request $request)
    {
        $parent_category_id = $request->parent_category_id;
        $restaurant_id = $request->restaurant_id;
        $category_name = $request->category_name;

        if ($restaurant_id != "") 
        {
            if($parent_category_id == "")
            {
                return response()->json(['errors'=>'First Select Parent Category!']);
            }
            else
            {
                $validator = Validator::make($request->all(), [
                                            'category_name' => 'required'
                                        ]);

                if ($validator->passes()) 
                {
                    $create_data = array(   
                                            'restaurant_id' => $restaurant_id,
                                            'category_type' => '1',
                                            'parent_category_id' => $parent_category_id,
                                            'category_name' => $request->category_name,
                                            'created_at'    => date('Y-m-d H:i:s')
                                        );

                    // Add row
                    $row_added = CategoryModel::create_category_details($create_data);

                    if($row_added)
                    {
                        $main_categories = CategoryModel::get_restaurant_main_categories($restaurant_id,$parent_category_id);

                        return response()->json(['success'=>'Data Added successfully', 'main_categories' => $main_categories]);
                    }
                    else
                    {
                        return response()->json(['errors'=>'Error while adding data']);
                    }
                }

                return response()->json(['error'=>$validator->errors()]);
            }
        }
        else
        {
            return response()->json(['errors'=>'Incorrect restaurant details']);
        }
    }

    // Validate and Add Sub Category
    public function create_sub_category(Request $request)
    {
        $parent_category = $request->parent_category_id;
        $main_category = $request->main_category_id;
        $restaurant_id = $request->restaurant_id;
        $category_name = $request->category_name_2;

        if ($restaurant_id != "") 
        {
            if($parent_category == "")
            {
                return response()->json(['error'=>'First Select Parent Category!']);
            }
            else if ($main_category == "") 
            {
                return response()->json(['error'=>'First Select Main Category!']);
            }
            else
            {
                $validator = Validator::make($request->all(), [
                                            'category_name_2' => 'required'
                                        ]);

                if ($validator->passes()) 
                {
                    $create_data = array(   
                                            'restaurant_id'      => $restaurant_id,
                                            'category_type'      => '2',
                                            'parent_category_id' => $parent_category,
                                            'main_category_id'   => $main_category,
                                            'category_name'      => $category_name,
                                            'created_at'         => date('Y-m-d H:i:s')
                                        );

                    // Add row
                    $row_added = CategoryModel::create_category_details($create_data);

                    if($row_added)
                    {
                        // Get Sub Categories
                        $sub_categories = CategoryModel::get_restaurant_sub_categories(
                                                                                        $restaurant_id,
                                                                                        $parent_category, 
                                                                                        $main_category
                                                                                    );
                        return response()->json(['success'=>'Data Added successfully', 'sub_categories' => $sub_categories]);
                    }
                    else
                    {
                        return response()->json(['errors'=>'Error while adding data']);
                    }
                }

                return response()->json(['error'=>$validator->errors()]);
            }
        }
        else
        {
            return response()->json(['errors'=>'Incorrect restaurant details']);
        }
    }

    // Get parent's main categories
    public function get_main_categories(Request $request)
    {
        $restaurant_id = $request->restaurant_id;
        $parent_category_id = $request->id;

        // Get Main Categories
        $main_category_array = CategoryModel::get_restaurant_main_categories($restaurant_id,$parent_category_id);

        if($main_category_array)
        {   
            return response()->json(['success'=>$main_category_array]);
        }
        else
        {
            return response()->json(['error'=>'No data found']);
        }
    }

    // Get main's sub categories
    public function get_sub_categories(Request $request)
    {
        $restaurant_id      = $request->restaurant_id;
        $main_category_id   = $request->id;
        $parent_category_id = $request->parent_category;

        // Get Sub Categories
        $sub_category_array = CategoryModel::get_restaurant_sub_categories(
                                                                                $restaurant_id,
                                                                                $parent_category_id, 
                                                                                $main_category_id
                                                                            );

        if($sub_category_array)
        {   
            return response()->json(['success' => $sub_category_array]);
        }
        else
        {
            return response()->json(['error' => 'No data found']);
        }
    }

    // Validate and Add Category
    public function create(Request $request)
    {
        $restaurant_id = $request->restaurant_id;

        if ($restaurant_id != "") 
        {
            $category_type = $request->category_type;
            $parent_category = $request->parent_category;
            $main_category = $request->main_category;
            $category_name = $request->category_name;

            if ($category_type == "0") 
            {
                $validator = Validator::make($request->all(), [
                                        'category_name' => 'required'
                                    ]);
            }
            else if ($category_type == "1") 
            {
                $validator = Validator::make($request->all(), [
                                        'category_name' => 'required',
                                        'parent_category' => 'required',
                                    ]);
            }
            else if ($category_type == "2") 
            {
                $validator = Validator::make($request->all(), [
                                        'category_name' => 'required',
                                        'parent_category' => 'required',
                                        'main_category' => 'required',
                                    ]);
            }

            if ($validator->passes()) 
            {
                if ($category_type == "0") 
                {
                    $create_data = array(   
                                        'restaurant_id' => $restaurant_id,
                                        'category_type' => '0',
                                        'category_name' => $request->category_name,
                                        'created_at'    => date('Y-m-d H:i:s')
                                    );
                }
                else if ($category_type == "1") 
                {
                    $create_data = array(   
                                        'restaurant_id' => $restaurant_id,
                                        'parent_category_id' => $parent_category,
                                        'category_type' => '1',
                                        'category_name' => $request->category_name,
                                        'created_at'    => date('Y-m-d H:i:s')
                                    );
                }
                else if ($category_type == "2") 
                {
                    $create_data = array(   
                                        'restaurant_id' => $restaurant_id,
                                        'parent_category_id' => $parent_category,
                                        'main_category_id' => $main_category,
                                        'category_type' => '2',
                                        'category_name' => $request->category_name,
                                        'created_at'    => date('Y-m-d H:i:s')
                                    );
                }

                // Add row
                $row_added = CategoryModel::create_category_details($create_data);

                if($row_added)
                {
                    return response()->json(['success'=>'Data Added successfully']);
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

    // Category Filters
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

                $parent_categories = [];
                $main_categories   = [];
                $sub_categories    = [];

                $filters_array = CategoryModel::get_categories_by_id(
                                                                        $restaurant_id,
                                                                        $parent_category_id,
                                                                        $main_category_id, 
                                                                        $sub_category_id
                                                                    );

                // print_r($filters_array);die;

                foreach ($filters_array as $key => $value) 
                {
                    if ($value->category_type == "0") 
                    {
                        $parent_categories[] = $value;
                    }
                    else if ($value->category_type == "1") 
                    {
                        $main_categories[] = $value;
                    }
                    else if ($value->category_type == "2") 
                    {
                        $sub_categories[] = $value;
                    }
                }

                // Get All Parent categories
                $parent_categories_array = CategoryModel::get_restaurant_categories_by_type($restaurant_id,'0');

                // Get Main Categories
                $main_categories_all = CategoryModel::get_restaurant_main_categories($restaurant_id,$parent_category_id);

                // Get Sub Categories
                $sub_categories_all = CategoryModel::get_restaurant_sub_categories($restaurant_id,$parent_category_id,$main_category_id);

                return view('category/index',['restaurant_name' => $restaurant_name, 'parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_id' => $restaurant_id, 'parent_categories_array' => $parent_categories_array, 'main_categories_array' => $main_categories_all, 'sub_categories_array' => $sub_categories_all, 'filter_parent_category' => $parent_category_id, 'filter_main_category' => $main_category_id, 'filter_sub_category' => $sub_category_id]);
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
