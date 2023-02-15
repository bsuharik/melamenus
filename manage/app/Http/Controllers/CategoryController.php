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
use App\Models\MenuModel;
use File;
use Auth;

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
        $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('parent_category_detail', 'main_category_detail', 'sub_category_detail')->first();
        if (!empty($restaurant_details)) {
            $restaurant_name = $restaurant_details->restaurant_name;
            // Get Parent Categories
            $parent_categories = array();
            if (!empty($restaurant_details->parent_category_detail)) {
                $parent_categories = $restaurant_details->parent_category_detail;
            }

            // Get Main Categories
            $main_categories = array();
            $menu_items_main_category = array();
            $menu_items_sub_category = array();
            if (!empty($restaurant_details->main_category_detail)) {
                $main_categories = $restaurant_details->main_category_detail;
                if (!empty($main_categories)) {
                    foreach ($main_categories as  $main_category) {
                        $menu_item_array = MenuModel::where('main_category', $main_category->category_id)->orderBy('order_display', 'ASC')->get();
                        if (!empty($menu_item_array)) {
                            foreach ($menu_item_array as  $menu_item) {
                                $menu_items_main_category[] = $menu_item;
                            }
                        }
                        $menu_item_array = MenuModel::where('parent_category', $main_category->parent_category_id)->orderBy('order_display', 'ASC')->get();
                        if (!empty($menu_item_array)) {
                            foreach ($menu_item_array as  $menu_item) {
                                $menu_items_sub_category[] = $menu_item;
                            }
                        }
                    }
                }
            }

            // Get Sub Categories
            $sub_categories = array();
            $menu_items_sub_category = array();
            if (!empty($restaurant_details->sub_category_detail)) {
                $sub_categories = $restaurant_details->sub_category_detail;

                foreach ($sub_categories as  $main_category) {
                    $menu_item_array = MenuModel::where('main_category', $main_category->category_id)->orderBy('order_display', 'ASC')->get();
                    if (!empty($menu_item_array)) {
                        foreach ($menu_item_array as  $menu_item) {
                            $menu_items_sub_category[] = $menu_item;
                        }
                    }
                }
            }
            // get Menu Item 
            $menu_items = array();
            if (!empty($sub_categories)) {
                foreach ($sub_categories as  $sub_category) {
                    $menu_item_array = MenuModel::where('sub_category', $sub_category->category_id)->orderBy('order_display', 'ASC')->get();
                    if (!empty($menu_item_array)) {
                        foreach ($menu_item_array as  $menu_item) {
                            $menu_items[] = $menu_item;
                        }
                    }
                }
            }
            return view('category/index', ['menu_items_main_category' => $menu_items_main_category, 'menu_items_sub_category' => $menu_items_sub_category, 'menu_items' => $menu_items, 'restaurant_name' => $restaurant_name, 'parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_id' => $restaurant_id, 'parent_categories_array' => $parent_categories, 'main_categories_array' => array(), 'sub_categories_array' => array(), 'filter_parent_category' => '', 'filter_main_category' => '', 'filter_sub_category' => '']);
        } else {
            return route('home');
        }
    }
    // Edit menu form
    public function update($id)
    {
        // Get Category details
        $category_details_array = array();
        $category_details_array = CategoryModel::where('category_id', $id)->first();
        return view('category/edit', ['category_detail' => $category_details_array]);
    }
    public function update_restaurant_category(Request $request)
    {
        // echo "<pre>";print_r($request->all()); echo "</pre>"; exit();
        $category_id = $request->category_id;
        $main_category  = $request->main_category;
        $display_type  = $request->display_type;
        $category_details = CategoryModel::where('category_id', $category_id)->first();
        $restaurant_id  = $category_details->restaurant_id;
        if (!empty($category_details)) {
            $current_category_icon = $category_details->category_icon;
            if (!empty($main_category) && $main_category == 1) {
                if ($display_type == "2") {
                    if (empty($current_category_icon)) {
                        $validator = Validator::make($request->all(), [
                            'category_name' => 'required',
                            'category_icon' => 'mimes:jpeg,png|max:2048',
                            'display_type' => 'required',
                            // 'display_days'=> 'required',
                            'start_time' => 'required',
                            'end_time' => 'required',
                        ]);
                    } else {
                        $validator = Validator::make($request->all(), [
                            'category_name' => 'required',
                            'display_type' => 'required',
                            // 'display_days'=> 'required',
                            'start_time' => 'required',
                            'end_time' => 'required',
                        ]);
                    }
                } else {
                    if (empty($current_category_icon)) {
                        $validator = Validator::make($request->all(), [
                            'category_name' => 'required',
                            'category_icon' => 'mimes:jpeg,png|max:2048',
                            'display_type' => 'required',
                        ]);
                    } else {
                        $validator = Validator::make($request->all(), [
                            'category_name' => 'required',
                            'display_type' => 'required',
                        ]);
                    }
                }
            } else {
                if (empty($current_category_icon)) {
                    $validator = Validator::make($request->all(), [
                        'category_name' => 'required',
                        'category_icon' => 'mimes:jpeg,png',
                    ]);
                } else {
                    $validator = Validator::make($request->all(), [
                        'category_name' => 'required',
                    ]);
                }
            }
            if ($validator->passes()) {
                if ($display_type == "2") {
                    if (empty($request->display_days)) {
                        return response()->json(['days_required' => 'Atleast one Display day is required']);
                    }
                }
                $file = $request->file('category_icon');
                if (!empty($file)) {
                    $category_icon_name = explode(".", $file->getClientOriginalName());
                    $category_icon = $category_icon_name[0] . '-' . time() . "." . $category_icon_name[1];
                    $destinationPath = config('images.category_url') . $restaurant_id;
                    // Delete current file
                    File::delete($destinationPath . '/' . $current_category_icon);
                    $file->move($destinationPath, $category_icon);
                } else {
                    $category_icon = '';
                }
                if ($display_type == "2") {
                    $category_details->day = implode(",", $request->display_days);
                    $category_details->start_time = $request->start_time;
                    $category_details->end_time = $request->end_time;
                } else {
                    $category_details->day = '';
                    $category_details->start_time = '';
                    $category_details->end_time = '';
                }
                if (!empty($request->display_type)) {
                    $category_details->display_type = $request->display_type;
                } else {
                    $category_details->display_type = 1;
                }
                $category_details->category_name = $request->category_name;
                // echo "current_category_icon =>".$request->current_category_icon;
                // echo "  current_category_icon =>".$current_category_icon;
                // echo "  category_icon =>".$category_icon;
                if (empty($request->current_category_icon) && !empty($current_category_icon) && empty($category_icon)) {
                    $destinationPath = config('images.category_url') . $restaurant_id;
                    File::delete($destinationPath . '/' . $current_category_icon);
                    $category_details->category_icon = '';
                } else {
                    $category_details->category_icon = $category_icon;
                }
                // echo "<pre>"; print_r($category_details); echo "</pre>"; exit();
                $category_details->updated_at = date('Y-m-d H:i:s');
                $saveData = $category_details->save();
                // Update row
                if ($saveData) {
                    return response()->json(['success' => 'Data updated successfully!']);
                } else {
                    return response()->json(['errors' => 'Error while updating data']);
                }
            }
            return response()->json(['error' => $validator->errors()]);
        } else {
            return response()->json(['errors' => 'Incorrect Category details']);
        }
    }
    // Delete Category details
    public function delete($id)
    {
        // Get category detail
        $category_details = CategoryModel::where('category_id', $id)->first();
        // echo "<pre>"; print_r($category_details); echo "</pre>"; exit();
        if (!empty($category_details)) {
            $restaurant_id  = $category_details->restaurant_id;
            $destinationPath = config('images.category_url') . $restaurant_id;
            if ($category_details->category_type == '0') {
                $parent_category_data = CategoryModel::where('parent_category_id', $id)->get();
                if (!empty($parent_category_data)) {
                    foreach ($parent_category_data as $parent_data) {
                        File::delete($destinationPath . '/' . $parent_data->category_icon);
                        $parent_data->delete();
                    }
                }
                File::delete($destinationPath . '/' . $category_details->category_icon);
                $delete_category = $category_details->delete();
            }
            if ($category_details->category_type == '1') {
                $main_category_data = CategoryModel::where('main_category_id', $id)->get();
                if (!empty($main_category_data)) {
                    foreach ($main_category_data as $main_category) {
                        File::delete($destinationPath . '/' . $main_category->category_icon);
                        $main_category->delete();
                    }
                }
                File::delete($destinationPath . '/' . $category_details->category_icon);
                $delete_category = $category_details->delete();
            }
            if ($category_details->category_type == '2') {
                $destinationPath = config('images.category_url') . $restaurant_id;
                File::delete($destinationPath . '/' . $category_details->category_icon);
                $delete_category = $category_details->delete();
            }
            if ($delete_category) {
                return redirect()->route('category', $restaurant_id);
            } else {
                return back()->with('error', 'Error while deleting category details.');
            }
        } else {
            return back()->with('error', 'Incorrect Category Details');
        }
    }
    // Validate and Add Parent Category
    public function create_parent_category(Request $request)
    {
        $restaurant_id = $request->restaurant_id;
        if ($restaurant_id != "") {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required',
                'category_icon' => 'mimes:jpeg,png|max:2048',
            ]);
            if ($validator->passes()) {
                // Add new 
                $category = new CategoryModel();
                $categoryicon = $request->file('category_icon');
                if (!empty($categoryicon)) {
                    $category_icon_name = explode(".", $categoryicon->getClientOriginalName());
                    $category_icon = $category_icon_name[0] . '-' . time() . "." . $category_icon_name[1];
                    // File Path
                    $destinationPath = config('images.category_url') . $restaurant_id;
                    $categoryicon->move($destinationPath, $category_icon);
                    $category->category_icon = $category_icon;
                }
                $category->restaurant_id = $restaurant_id;
                $category->category_type = '0';
                $category->category_name = $request->category_name;
                $category->created_at = date('Y-m-d H:i:s');
                $last_order_category = CategoryModel::where('restaurant_id', $restaurant_id)->where('category_type', '0')->orderBy('order_display', 'desc')->first();
                if (!empty($last_order_category)) {
                    $category->order_display = $last_order_category->order_display + 1;
                } else {
                    $category->order_display = 1;
                }
                $is_saved = $category->save();
                if ($is_saved) {
                    $parent_categories = array();
                    $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('parent_category_detail')->first();
                    if (!empty($restaurant_details->parent_category_detail)) {
                        $parent_categories = $restaurant_details->parent_category_detail;
                    }
                    return response()->json(['success' => 'Data Added successfully', 'parent_categories' => $parent_categories]);
                } else {
                    return response()->json(['errors' => 'Error while adding data']);
                }
            }
            return response()->json(['error' => $validator->errors()]);
        } else {
            return response()->json(['errors' => 'Incorrect restaurant details']);
        }
    }
    // Validate and Add Main Category
    public function create_main_category(Request $request)
    {
        $parent_category_id = $request->parent_category_id;
        $restaurant_id = $request->restaurant_id;
        $category_name = $request->category_name;
        $display_type = $request->display_type;
        if ($restaurant_id != "") {
            if ($parent_category_id == "") {
                return response()->json(['errors' => 'First Select Parent Category!']);
            } else {
                if ($display_type == "2") {
                    $validator = Validator::make($request->all(), [
                        'category_name' => 'required',
                        'category_icon' => 'mimes:jpeg,png|max:2048',
                        'display_type' => 'required',
                        // 'display_days'=> 'required',
                        'start_time' => 'required',
                        'end_time' => 'required',
                    ]);
                } else {
                    $validator = Validator::make($request->all(), [
                        'category_name' => 'required',
                        'category_icon' => 'mimes:jpeg,png|max:2048',
                        'display_type' => 'required',
                    ]);
                }
                if ($validator->passes()) {
                    $category = new CategoryModel();
                    if ($display_type == "2") {
                        if (empty($request->display_days)) {
                            return response()->json(['days_required' => 'Atleast one Display day is required']);
                        }
                    }
                    $categoryicon = $request->file('category_icon');
                    if (!empty($categoryicon)) {
                        $category_icon_name = explode(".", $categoryicon->getClientOriginalName());
                        $category_icon = $category_icon_name[0] . '-' . time() . "." . $category_icon_name[1];
                        // File Path
                        $destinationPath = config('images.category_url') . $restaurant_id;
                        $categoryicon->move($destinationPath, $category_icon);
                        $category->category_icon = $category_icon;
                    }
                    if ($display_type == "2") {
                        $category->display_type =  $display_type;
                        $category->day = implode(",", $request->display_days);
                        $category->start_time =  $request->start_time;
                        $category->end_time =  $request->end_time;
                    } else {
                        $category->display_type =  $display_type;
                    }
                    $category->restaurant_id = $restaurant_id;
                    $category->category_type = '1';
                    $category->parent_category_id = $parent_category_id;
                    $category->category_name = $request->category_name;
                    $category->created_at = date('Y-m-d H:i:s');
                    $last_order_category = CategoryModel::where('restaurant_id', $restaurant_id)->where('category_type', '1')->orderBy('order_display', 'desc')->first();
                    if (!empty($last_order_category)) {
                        $category->order_display = $last_order_category->order_display + 1;
                    } else {
                        $category->order_display = 1;
                    }
                    $is_saved = $category->save();
                    // Add row
                    if ($is_saved) {
                        $main_categories = array();
                        $main_categories_all = CategoryModel::where('restaurant_id', $restaurant_id)->where('parent_category_id', $parent_category_id)->where('category_type', '1')->orderBy('order_display', 'ASC')->get();
                        if (!empty($main_categories_all)) {
                            $main_categories = $main_categories_all;
                        }
                        return response()->json(['success' => 'Data Added successfully', 'main_categories' => $main_categories]);
                    } else {
                        return response()->json(['errors' => 'Error while adding data']);
                    }
                }
                return response()->json(['error' => $validator->errors()]);
            }
        } else {
            return response()->json(['errors' => 'Incorrect restaurant details']);
        }
    }
    // Validate and Add Sub Category
    public function create_sub_category(Request $request)
    {
        $parent_category = $request->parent_category_id;
        $main_category = $request->main_category_id;
        $restaurant_id = $request->restaurant_id;
        $category_name = $request->category_name;
        $sub_categories = array();
        if ($restaurant_id != "") {
            if ($parent_category == "") {
                return response()->json(['error' => 'First Select Parent Category!']);
            } else if ($main_category == "") {
                return response()->json(['error' => 'First Select Main Category!']);
            } else {
                $validator = Validator::make($request->all(), [
                    'category_name' => 'required',
                    'category_icon' => 'mimes:jpeg,png|max:2048',
                ]);
                if ($validator->passes()) {
                    // Add row
                    $category = new CategoryModel();
                    $categoryicon = $request->file('category_icon');
                    if (!empty($categoryicon)) {
                        $category_icon_name = explode(".", $categoryicon->getClientOriginalName());
                        $category_icon = $category_icon_name[0] . '-' . time() . "." . $category_icon_name[1];
                        // File Path
                        $destinationPath = config('images.category_url') . $restaurant_id;
                        $categoryicon->move($destinationPath, $category_icon);
                        $category->category_icon = $category_icon;
                    }
                    $category->restaurant_id = $restaurant_id;
                    $category->category_type = '2';
                    $category->parent_category_id = $parent_category;
                    $category->main_category_id = $main_category;
                    $category->category_name = $category_name;
                    $category->created_at = date('Y-m-d H:i:s');
                    $last_order_category = CategoryModel::where('restaurant_id', $restaurant_id)->where('category_type', '2')->orderBy('order_display', 'desc')->first();
                    if (!empty($last_order_category)) {
                        $category->order_display = $last_order_category->order_display + 1;
                    } else {
                        $category->order_display = 1;
                    }
                    $is_saved = $category->save();
                    if ($is_saved) {
                        $sub_categories_data = CategoryModel::where('restaurant_id', $restaurant_id)->where('parent_category_id', $parent_category)->where('main_category_id', $main_category)->where('category_type', '2')->orderBy('order_display', 'ASC')->get();
                        if (!empty($sub_categories_data)) {
                            $sub_categories = $sub_categories_data;
                        }
                        return response()->json(['success' => 'Data Added successfully', 'sub_categories' => $sub_categories]);
                    } else {
                        return response()->json(['errors' => 'Error while adding data']);
                    }
                }
                return response()->json(['error' => $validator->errors()]);
            }
        } else {
            return response()->json(['errors' => 'Incorrect restaurant details']);
        }
    }
    // Get parent's main categories
    public function get_main_categories(Request $request)
    {
        $restaurant_id = $request->restaurant_id;
        $parent_category_id = $request->id;
        // Get Main Categories
        $main_categories_array = array();
        $main_categories = CategoryModel::where('restaurant_id', $restaurant_id)->where('parent_category_id', $parent_category_id)->where('category_type', '1')->orderBy('order_display', 'ASC')->get();
        if (!empty($main_categories)) {
            $main_categories_array = $main_categories;
            return response()->json(['success' => $main_categories_array]);
        } else {
            return response()->json(['error' => 'No data found']);
        }
    }
    // Get main's sub categories
    public function get_sub_categories(Request $request)
    {
        $restaurant_id      = $request->restaurant_id;
        $main_category_id   = $request->id;
        $parent_category_id = $request->parent_category;
        $sub_category_array = array();
        $sub_categories = CategoryModel::where('restaurant_id', $restaurant_id)->where('parent_category_id', $parent_category_id)->where('main_category_id', $main_category_id)->where('category_type', '2')->orderBy('order_display', 'ASC')->get();
        if (!empty($sub_categories)) {
            $sub_category_array = $sub_categories;
            return response()->json(['success' => $sub_category_array]);
        } else {
            return response()->json(['error' => 'No data found']);
        }
    }
    // Validate and Add Category
    public function create(Request $request)
    {
        // echo "<pre>" ; print_r($request->all()); echo "</pre>"; exit();
        $restaurant_id = $request->restaurant_id;
        if ($restaurant_id != "") {
            $category_type = $request->category_type;
            $parent_category = $request->parent_category;
            $main_category = $request->main_category;
            $category_name = $request->category_name;
            $display_type = $request->display_type;
            if ($category_type == "0") {
                $validator = Validator::make($request->all(), [
                    'category_name' => 'required',
                    'category_icon' => 'mimes:jpeg,png|max:2048',
                ]);
            } else if ($category_type == "1") {
                if ($display_type == "2") {
                    $validator = Validator::make($request->all(), [
                        'category_name' => 'required',
                        'parent_category' => 'required',
                        'category_icon' => 'mimes:jpeg,png|max:2048',
                        'display_type' => 'required',
                        // 'display_days'=> 'required',
                        'start_time' => 'required',
                        'end_time' => 'required',
                    ]);
                } else {
                    $validator = Validator::make($request->all(), [
                        'category_name' => 'required',
                        'parent_category' => 'required',
                        'category_icon' => 'mimes:jpeg,png|max:2048',
                        'display_type' => 'required',
                    ]);
                }
            } else if ($category_type == "2") {
                $validator = Validator::make($request->all(), [
                    'category_name' => 'required',
                    'parent_category' => 'required',
                    'main_category' => 'required',
                    'category_icon' => 'mimes:jpeg,png|max:2048',
                ]);
            }
            if ($validator->passes()) {
                if ($display_type == "2") {
                    if (empty($request->display_days)) {
                        return response()->json(['days_required' => 'Atleast one Display day is required']);
                    }
                }
                $category = new CategoryModel();
                if ($category_type == "0") {
                    $category->category_type = '0';
                } else if ($category_type == "1") {
                    if ($display_type == "2") {
                        $category->category_type = '1';
                        $category->parent_category_id =  $parent_category;
                        $category->display_type =  $display_type;
                        $category->day =  implode(",", $request->display_days);
                        $category->start_time =  $request->start_time;
                        $category->end_time =  $request->end_time;
                    } else {
                        $category->category_type = '1';
                        $category->parent_category_id =  $parent_category;
                        $category->display_type =  $display_type;
                    }
                } else if ($category_type == "2") {
                    $category->category_type = '2';
                    $category->parent_category_id =  $parent_category;
                    $category->main_category_id = $main_category;
                }
                $categoryicon = $request->file('category_icon');
                if (!empty($categoryicon)) {
                    $category_icon_name = explode(".", $categoryicon->getClientOriginalName());
                    $category_icon = $category_icon_name[0] . '-' . time() . "." . $category_icon_name[1];
                    // File Path
                    $destinationPath = config('images.category_url') . $restaurant_id;
                    $categoryicon->move($destinationPath, $category_icon);
                    $category->category_icon = $category_icon;
                }
                $category->restaurant_id = $restaurant_id;
                $category->category_name = $request->category_name;
                $category->created_at = date('Y-m-d H:i:s');
                $last_order_category = CategoryModel::where('restaurant_id', $restaurant_id)->where('category_type', $category_type)->orderBy('order_display', 'desc')->first();
                if (!empty($last_order_category)) {
                    $category->order_display = $last_order_category->order_display + 1;
                } else {
                    $category->order_display = 1;
                }
                $is_saved = $category->save();
                // Add row 
                if ($is_saved) {
                    return response()->json(['success' => 'Data Added successfully']);
                } else {
                    return response()->json(['errors' => 'Error while adding data']);
                }
            }
            return response()->json(['error' => $validator->errors()]);
        } else {
            return response()->json(['errors' => 'Incorrect restaurant details']);
        }
    }
    // Category Filters
    public function filters(Request $request)
    {
        $restaurant_id = $request->restaurant_id;
        if ($restaurant_id != "") {
            $parent_category_id = $request->filter_parent_category;
            $main_category_id   = $request->filter_main_category;
            $sub_category_id    = $request->filter_sub_category;
            $restaurant_details = RestaurantModel::where('restaurant_id', $restaurant_id)->with('parent_category_detail')->first();
            if (!empty($restaurant_details)) {
                $restaurant_name = $restaurant_details->restaurant_name;
                $parent_categories = [];
                $main_categories   = [];
                $sub_categories    = [];
                $all_category = CategoryModel::where('restaurant_id', $restaurant_id)->orderBy('order_display', 'ASC');
                if (!empty($parent_category_id)) {
                    $all_category = $all_category->where('parent_category_id', $parent_category_id)->orwhere('category_id', $parent_category_id);
                }
                if (!empty($main_category_id)) {
                    $all_category = $all_category->where('main_category_id', $main_category_id)->orwhereIn('category_id', [$parent_category_id, $main_category_id]);
                }
                if (!empty($sub_category_id)) {
                    $all_category = $all_category->whereIn('category_id', [$sub_category_id, $parent_category_id, $main_category_id]);
                }
                $filters_array = $all_category->get();
                foreach ($filters_array as $key => $value) {
                    if ($value->category_type == "0") {
                        $parent_categories[] = $value;
                    } else if ($value->category_type == "1") {
                        $main_categories[] = $value;
                    } else if ($value->category_type == "2") {
                        $sub_categories[] = $value;
                    }
                }
                // Get All Parent categories
                $parent_categories_array = array();
                if (!empty($restaurant_details->parent_category_detail)) {
                    $parent_categories_array = $restaurant_details->parent_category_detail;
                }
                // Get Main Categories
                $main_categories_all = array();
                $main_categories = CategoryModel::where('restaurant_id', $restaurant_id)->where('parent_category_id', $parent_category_id)->where('category_type', '1')->orderBy('order_display', 'ASC')->get();
                if (!empty($main_categories)) {
                    $main_categories_all = $main_categories;
                }
                $sub_categories_all = array();
                $sub_categories = CategoryModel::where('restaurant_id', $restaurant_id)->where('parent_category_id', $parent_category_id)->where('main_category_id', $main_category_id)->where('category_type', '2')->orderBy('order_display', 'ASC')->get();
                if (!empty($sub_categories)) {
                    $sub_categories_all = $sub_categories;
                }
                // get Menu Item 
                $menu_items = array();
                if (!empty($sub_categories_all)) {
                    foreach ($sub_categories_all as  $sub_category_all) {
                        $menu_item_array = MenuModel::where('sub_category', $sub_category_all->category_id)->orderBy('order_display', 'ASC')->get();
                        if (!empty($menu_item_array)) {
                            foreach ($menu_item_array as  $menu_item) {
                                $menu_items[] = $menu_item;
                            }
                        }
                    }
                }
                return view('category/index', ['restaurant_name' => $restaurant_name, 'menu_items' => $menu_items, 'parent_categories' => $parent_categories, 'main_categories' => $main_categories, 'sub_categories' => $sub_categories, 'restaurant_id' => $restaurant_id, 'parent_categories_array' => $parent_categories_array, 'main_categories_array' => $main_categories_all, 'sub_categories_array' => $sub_categories_all, 'filter_parent_category' => $parent_category_id, 'filter_main_category' => $main_category_id, 'filter_sub_category' => $sub_category_id]);
            } else {
                return $this->index($restaurant_id);
            }
        } else {
            return Redirect::to('home');
        }
    }
    // save category order 
    public function save_category_order(Request $request)
    {
        //echo "<pre>"; print_r($request->all()); echo "</pre>"; exit(); 
        if ($request->category_type == '0') {
            $i = 1;
            foreach ($request->category_id as $category_id) {
                $category_details = CategoryModel::where('restaurant_id', $request->restaurant_id)->where('category_id', $category_id)->first();
                $category_details->order_display = $i;
                $category_details->save();
                $i++;
            }
            return response()->json(['success' => 'success']);
        }
        if ($request->category_type == '1') {
            $i = 1;
            foreach ($request->category_id as $category_id) {
                $category_details = CategoryModel::where('restaurant_id', $request->restaurant_id)->where('category_id', $category_id)->where('parent_category_id', $request->parent_caregory_id)->first();
                $category_details->order_display = $i;
                $category_details->save();
                $i++;
            }
            return response()->json(['success' => 'success']);
        }
        if ($request->category_type == '2') {
            $i = 1;
            foreach ($request->category_id as $category_id) {
                $category_details = CategoryModel::where('restaurant_id', $request->restaurant_id)->where('category_id', $category_id)->where('parent_category_id', $request->parent_caregory_id)->where('main_category_id', $request->main_category_id)->first();
                $category_details->order_display = $i;
                $category_details->save();
                $i++;
            }
            return response()->json(['success' => 'success']);
        }
    }
    // update menu name Start 
    public function update_menu(Request $request)
    {
        $menu_id = $request->menu_id;
        $menu_details = MenuModel::where('menu_id', $menu_id)->first();
        $validator = Validator::make($request->all(), [
            'menu_name' => 'required',
        ]);
        if (!empty($menu_details)) {
            if ($validator->passes()) {
                $menu_slugs = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->menu_name)));
                $regex = "/\-+$/";
                $menu_slug = preg_replace($regex, "", $menu_slugs);
                $menuName_check = DB::table('menus')->whereNotIn('menu_id', [$menu_id])->where('slug', $menu_slug)->get()->count();
                if ($menuName_check > 0) {
                    $menuSlug = $menu_slug . '' . rand(pow(10, 2 - 1), pow(10, 2) - 1);
                } else {
                    $menuSlug = $menu_slug;
                }
                $menu_details->name = $request->menu_name;
                $menu_details->slug = $menuSlug;
                $saveData = $menu_details->save();
                // Update row
                if ($saveData) {
                    return response()->json(['success' => 'Menu name updated successfully!']);
                } else {
                    return response()->json(['errors' => 'Error while updating data']);
                }
            }
            return response()->json(['error' => $validator->errors()]);
        } else {
            return response()->json(['errors' => 'Incorrect Category details']);
        }
    }
    // update Menu name End
}
