<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\FontModel;
use File;

class FontController extends Controller
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
    // Create Font
    // Validate and Add Main Category
    public function add_font(Request $request)
    {        
        $restaurant_id = $request->restaurant_id;
        $font_name = $request->name;
        if ($restaurant_id != "") {   

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                //'font_file' => 'required|mimes:ttf,eot,eoff,woff2,svg'
                'font_file' => 'required'
            ]);
            if ($validator->passes()) {
                $validate_font_name = FontModel::where('restaurant_id', $restaurant_id)->where('name', $font_name)->count();
                if (empty($validate_font_name)) {

                    $file = $request->file('font_file');
                    if (!empty($file)) {
                        $font_file_name = explode(".", $file->getClientOriginalName());
                        $font_file = $font_file_name[0] . '-' . $restaurant_id . '-' . time() . "." . $font_file_name[1];
                        $destination_path = config('images.font_file_url');
                        //File::delete($destination_path . '/' . $current_category_icon);
                        $file->move($destination_path, $font_file);
                    } else {
                        $font_file = '';
                    }

                    $font = new FontModel();
                    $font->restaurant_id = $restaurant_id;
                    $font->name = $font_name;
                    $font->font_file = $font_file;
                    $is_saved = $font->save();
                    if ($is_saved) {
                        $font_list = array();
                        $font_list = FontModel::where('restaurant_id', $restaurant_id)->orderBy('name', 'ASC')->get();
                        return response()->json(['success' => 'Font Added successfully', 'font_list' => $font_list]);
                    } else {
                        return response()->json(['errors' => 'Error while adding data']);
                    }
                } else {
                    return response()->json(['already_exist' => 'Font name has already taken.']);
                }
            }
            return response()->json(['error' => $validator->errors()]);
        } else {
            return response()->json(['errors' => 'Incorrect restaurant details']);
        }
    }
}
