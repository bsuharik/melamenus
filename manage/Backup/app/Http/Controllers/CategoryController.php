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
        $restaurant_details = RestaurantModel::where('restaurant_id',$restaurant_id)->with('parent_category_detail','main_category_detail','sub_category_detail')->first();
        

        if (!empty($restaurant_details)) 
        {
            $restaurant_name = $restaurant_details->restaurant_name;

            // Get Parent Categories
            $parent_categories=array();
            if(!empty($restaurant_details->parent_category_detail)){
                $parent_categories=$restaurant_details->parent_category_detail;
            }

            // Get Main Categories
            $main_categories=array();
            if(!empty($restaurant_details->main_category_detail)){
                $main_categories=$restaurant_details->main_category_detail;
            }

            // Get Sub Categories
            $sub_categories=array();
            if(!empty($restaurant_details->sub_category_detail)){
                $sub_categories=$restaurant_details->sub_category_detail;
            }
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
        $category_details_array=array();
        $category_details_array = CategoryModel::where('category_id',$id)->first();

        return view('category/edit',['category_detail' => $category_details_array]);
    }

    // Validate and Update Category Details
    public function update_restaurant_category(Request $request)
    {
        $category_id = $request->category_id;

        // Get category details
        $category_details = CategoryModel::where('category_id',$category_id)->first();
         if(!empty($category_details))
        {   
            $validator = Validator::make($request->all(), [
                'category_name' => 'required',
            ]);

            if ($validator->passes()) 
            {
                $category_details->category_name = $request->category_name;
                $category_details->updated_at = date('Y-m-d H:i:s');
                $saveData = $category_details->save();
                // Update row
                if($saveData)
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
        $category_details = CategoryModel::where('category_id',$id)->first();
        if(!empty($category_details))
        {   
            $restaurant_id  = $category_details->restaurant_id;
            if($category_details->category_type =='0'){
                $delete_category=CategoryModel::where('category_id',$id)->first()->delete();
                $parent_category_data = CategoryModel::where('parent_category_id',$id)->get();
                foreach($parent_category_data as $parent_data){
                    $parent_data->delete();
                }
                
            }
            if($category_details->category_type == '1'){
                $delete_category=CategoryModel::where('category_id',$id)->first()->delete();
                $main_category_data=CategoryModel::where('main_category_id',$id)->get();
                foreach($main_category_data as $main_category){
                    $main_category->delete();
                }
            }
            if($category_details->category_type == '2'){
                $delete_category=CategoryModel::where('category_id',$id)->first()->delete();
                
            }
            if ($delete_category) 
            {
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
                

                // Add new 
                $category = new CategoryModel();
                    $category->restaurant_id=$restaurant_id;
                    $category->category_type='0';
                    $category->category_name =$request->category_name;
                    $category->created_at = date('Y-m-d H:i:s');
                    $is_saved = $category->save();

                    if($is_saved){
                        $parent_categories =array();
                            $restaurant_details=RestaurantModel::where('restaurant_id',$restaurant_id)->with('parent_category_detail')->first();
                            if(!empty($restaurant_details->parent_category_detail)){
                                $parent_categories= $restaurant_details->parent_category_detail;
                            }


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
                    $category = new CategoryModel();
                $category->restaurant_id=$restaurant_id;
                $category->category_type='1';
                $category->parent_category_id = $parent_category_id;
                $category->category_name =$request->category_name;
                $category->created_at = date('Y-m-d H:i:s');
                $is_saved = $category->save();

                    // Add row
                    if($is_saved)
                    {
                        $main_categories=array();
                        $main_categories_all = CategoryModel::where('restaurant_id',$restaurant_id)->where('parent_category_id',$parent_category_id)->where('category_type','1')->get();
                        if(!empty($main_categories_all)){
                            $main_categories= $main_categories_all;
                        }



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
        $sub_categories=array();

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
                    

                    // Add row
                    $category = new CategoryModel();
                    $category->restaurant_id=$restaurant_id;
                    $category->category_type='2';
                    $category->parent_category_id = $parent_category;
                    $category->main_category_id = $main_category;
                    $category->category_name =$category_name;
                    $category->created_at = date('Y-m-d H:i:s');
                    $is_saved = $category->save();

                    if($is_saved){
                        
                        
                        $sub_categories_data = CategoryModel::where('restaurant_id',$restaurant_id)->where('parent_category_id',$parent_category)->where('main_category_id',$main_category)->where('category_type','2')->get();
                        if(!empty($sub_categories_data)){
                            $sub_categories= $sub_categories_data;
                        }
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
        $main_categories_array=array();
        $main_categories = CategoryModel::where('restaurant_id',$restaurant_id)->where('parent_category_id',$parent_category_id)->where('category_type','1')->get();
        if(!empty($main_categories)){
            $main_categories_array= $main_categories;
            return response()->json(['success'=>$main_categories_array]);
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

        $sub_category_array=array();
        $sub_categories = CategoryModel::where('restaurant_id',$restaurant_id)->where('parent_category_id',$parent_category_id)->where('main_category_id',$main_category_id)->where('category_type','2')->get();
        if(!empty($sub_categories)){
            $sub_category_array= $sub_categories;
            return response()->json(['success' => $sub_category_array]);
        }
        else
        {
            return response()->json(['error' => 'No data found']);
        }
    }

    // Validate and Add Category
    public function create(Request $request){

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
                $category = new CategoryModel();
                if ($category_type == "0") 
                {
                    $category->category_type='0';
                }
                else if ($category_type == "1") 
                {
                    $category->category_type='1';
                    $category->parent_category_id =  $parent_category;
                   
                }
                else if ($category_type == "2") 
                {
                    $category->category_type='2';
                    $category->parent_category_id =  $parent_category;
                    $category->main_category_id = $main_category;
                    
                }
                $category->restaurant_id=$restaurant_id;
                $category->category_name =$request->category_name;
                $category->created_at = date('Y-m-d H:i:s');
                 $is_saved = $category->save(); 
                // Add row 
                if($is_saved)
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

            $restaurant_details = RestaurantModel::where('restaurant_id',$restaurant_id)->with('parent_category_detail')->first();

            if (!empty($restaurant_details)) 
            {
                $restaurant_name = $restaurant_details->restaurant_name;

                $parent_categories = [];
                $main_categories   = [];
                $sub_categories    = [];
                $all_category = CategoryModel::where('restaurant_id',$restaurant_id);
                if(!empty($parent_category_id)){
                     $all_category = $all_category->where('parent_category_id',$parent_category_id)->orwhere('category_id',$parent_category_id);
                }
                if(!empty($main_category_id)){
                    $all_category = $all_category->where('main_category_id',$main_category_id)->orwhereIn('category_id',[$parent_category_id,$main_category_id]);
                }
                if(!empty($sub_category_id)){
                    $all_category = $all_category->whereIn('category_id',[$sub_category_id,$parent_category_id,$main_category_id]);
                }
                $filters_array = $all_category->get();


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
               $parent_categories_array=array();
                if(!empty($restaurant_details->parent_category_detail)){
                    $parent_categories_array=$restaurant_details->parent_category_detail;
                }

                // Get Main Categories
               $main_categories_all=array();
                $main_categories = CategoryModel::where('restaurant_id',$restaurant_id)->where('parent_category_id',$parent_category_id)->where('category_type','1')->get();
                if(!empty($main_categories)){
                    $main_categories_all= $main_categories;
                }
                $sub_categories_all=array();
                $sub_categories = CategoryModel::where('restaurant_id',$restaurant_id)->where('parent_category_id',$parent_category_id)->where('main_category_id',$main_category_id)->where('category_type','2')->get();
                if(!empty($sub_categories)){
                    $sub_categories_all= $sub_categories;
                }
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
