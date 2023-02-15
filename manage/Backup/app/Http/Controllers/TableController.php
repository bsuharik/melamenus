<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use File;
use Excel;
use App\Models\RestaurantModel;
use App\Models\TableModel; 
use DB;

class TableController extends Controller
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
        $restaurant_name='';
        $table_array=array();
        $restaurants = RestaurantModel::where('restaurant_id',$id)->with('table_detail')->first();
        if(!empty($restaurants)){
            if(!empty($restaurants->table_detail)){
                $table_array=$restaurants->table_detail;
            }
            $restaurant_name=$restaurants->restaurant_name;

        }
        return view('table/index',['restaurant_id'=>$id,'restaurant_name' => $restaurant_name, 'table_list' => $table_array]);
    } 
 
    // Validate and Add Table
    public function create(Request $request)
    {
        $restaurant_id = $request->restaurant_id;

        if ($restaurant_id != "") 
        {
            $validator = Validator::make($request->all(), [
                'table_number' => 'required',
                'chairs' => 'required',
            ]);

            if ($validator->passes()) 
            {
                // Validate Table Number
                $validate_table_number = TableModel::where('table_number',$request->table_number)->where('restaurant_id',$restaurant_id)->count();
                if (empty($validate_table_number)) 
                {
                    $full_qr_code_image_name = '';
                    $qr_code_image_name = '';

                    if ($request->chairs > '0') 
                    {
                        for ($i=1; $i <= $request->chairs; $i++) 
                        { 
                            $chair_number = $i;

                            $directory = config('images.qr_code_url').$restaurant_id;

                            if(!File::exists($directory)) 
                            {
                                File::makeDirectory($directory);
                            }

                            $qr_code_image_name = "qrcode_".$request->table_number."_".$chair_number.".png";

                            $qr_path = $directory."/".$qr_code_image_name;

                           $qr_image = TableModel::generate_qr_code($qr_path, $restaurant_id,$request->table_number,$chair_number);

                            $full_qr_code_image_name .= $qr_code_image_name." ";
                        }
                    }
                    // Add row
                    $table_data= new TableModel();
                    $table_data->restaurant_id = $restaurant_id;
                    $table_data->table_number = $request->table_number;
                    $table_data->chairs      = $request->chairs;
                    $table_data->qr_code      = trim($full_qr_code_image_name);
                    $table_data->created_at    = date('Y-m-d H:i:s');
                    $row_added = $table_data->save();
                    if($row_added)
                    {
                        return response()->json(['success'=>'Data Added successfully']);
                    }
                    else
                    {
                        return response()->json(['errors'=>'Error while adding data']);
                    }
                }
                else
                {
                    return response()->json(['table_number'=>'Table Number has already taken.']);
                }
            }

            return response()->json(['error'=>$validator->errors()]);
        }
        else
        {
            return response()->json(['errors'=>'Incorrect restaurant details']);
        }
    }

    // Validate and Update Table
    public function update(Request $request)
    {
        $logo_url = config('images.site_logo_url');

        $restaurant_id = $request->restaurant_id;

        if ($restaurant_id != "") 
        {
            $table_id = $request->table_id;

            // Get Table details
             $table_details = TableModel::find($table_id);
            if(!empty($table_details))
            {
                $current_table_chaires  = $table_details->chairs;
                $current_table_qr_codes = $table_details->qr_code;
                $current_table_number   = $table_details->table_number;

                $validator = Validator::make($request->all(), [
                    'table_number' => 'required',
                    'chairs'       => 'required',
                ]);

                if ($validator->passes()) 
                {
                    // Validate Table Number
                    
                    $validate_table_number = TableModel::where('table_number',$request->table_number)->where('restaurant_id',$restaurant_id)->where('table_id',$request->$table_id)->count();
                    
                    if(empty($validate_table_number))
                    {
                        $full_qr_codes_text = '';

                        if ($request->table_number == $current_table_number) 
                        {
                            if ($request->chairs == $current_table_chaires) 
                            {
                                $full_qr_codes_text = $current_table_qr_codes;
                            }
                            else
                            {

                                $current_qr_array = explode(" ", $current_table_qr_codes);
                                $current_qr_count = count($current_qr_array);

                                if ($request->chairs > $current_qr_count) 
                                {
                                    $full_qr_code_image_name = "";

                                    for ($i = $current_qr_count+1; $i <= $request->chairs; $i++) 
                                    { 
                                        $chair_number = $i;

                                        $directory = config('images.qr_code_url').$restaurant_id;

                                        if(!File::exists($directory)) 
                                        {
                                            File::makeDirectory($directory);
                                        }

                                        $qr_code_image_name = "qrcode_".$request->table_number."_".$chair_number.".png";

                                        $qr_path = $directory."/".$qr_code_image_name;

                                        // Generate QR code for each chair
                                        $qr_image = TableModel::generate_qr_code($qr_path, $restaurant_id,$request->table_number,$chair_number);


                                        $full_qr_code_image_name .= $qr_code_image_name." ";
                                    }

                                    $full_qr_codes_text = $current_table_qr_codes." ".trim($full_qr_code_image_name);
                                }
                                else if ($request->chairs < $current_qr_count) 
                                {
                                    for ($i = $current_qr_count; $i > $request->chairs; $i--) 
                                    { 
                                        $qr_file_name = $current_qr_array[$i-1];

                                        // File Path
                                        $destinationPath = config('images.qr_code_url').$restaurant_id;

                                        // Delete file
                                        File::delete($destinationPath.'/'.$qr_file_name);

                                        unset($current_qr_array[$i-1]);
                                    }

                                    $full_qr_codes_text = implode(" ", $current_qr_array);
                                }
                            }
                        }
                        else
                        {
                            // Delete current QR codes
                            $delete_qr_codes = TableModel::delete_table_qr_codes($restaurant_id, $current_table_qr_codes);

                            $qr_code_image_name = '';

                            if ($request->chairs > '0') 
                            {
                                for ($i=1; $i <= $request->chairs; $i++) 
                                { 
                                    $chair_number = $i;

                                    $directory = config('images.qr_code_url').$restaurant_id;

                                    if(!File::exists($directory)) 
                                    {
                                        File::makeDirectory($directory);
                                    }

                                    $qr_code_image_name = "qrcode_".$request->table_number."_".$chair_number.".png";

                                    $qr_path = $directory."/".$qr_code_image_name;

                                    // Generate QR code for each chair
                                    $qr_image = TableModel::generate_qr_code($qr_path, $restaurant_id,$request->table_number,$chair_number);


                                    $full_qr_codes_text .= $qr_code_image_name." ";
                                }
                            }
                        }

                        

                        $condition = array('table_id' => $table_id, 'restaurant_id' => $restaurant_id);

                        // Update row
                        $table_data = TableModel::where('table_id',$table_id)->where('restaurant_id',$restaurant_id)->first();
                       
                        $table_data->table_number = $request->table_number;
                        $table_data->chairs      = $request->chairs;
                        $table_data->qr_code      = trim($full_qr_codes_text);
                        $table_data->updated_at    = date('Y-m-d H:i:s');
                        $row_updated =$table_data->save();
                        if($row_updated)
                        {
                            return response()->json(['success'=>'Data Updated successfully']);
                        }
                        else
                        {
                            return response()->json(['errors'=>'Error while updating data']);
                        }
                    }
                    else
                    {
                        return response()->json(['table_number'=>'Table Number has already taken.']);
                    }
                }

                return response()->json(['error'=>$validator->errors()]);
            }
            else
            {
                return response()->json(['errors'=>'Incorrect Table details']);
            }
        }
        else
        {
            return response()->json(['errors'=>'Incorrect restaurant details']);
        }
    }

    // Delete Table details
    public function delete($id)
    {
        // Get Table details
        $table_details = TableModel::find($id);

        if(!empty($table_details)){   
            $restaurant_id = $table_details->restaurant_id;
            // Delete Table
            $qr_codes      = $table_details->qr_code;
            // Delete QR codes
            $delete_qr_code=TableModel::delete_table_qr_codes($restaurant_id, $qr_codes);
            $delete_table = DB::table('restaurant_tables')->where('table_id',$id)->delete();
            if ($delete_table){
                return redirect()->route('table',$restaurant_id);
            }
            else{
                return back()->with('error','Error while deleting table details.');
            }
        }
        else{
            return back()->with('error','Incorrect Table Details');
        }        
    }

    // Get table qr code list
    public function get(Request $request){
        $table_id = $request->table_id;
        if($table_id != ""){
            $table_data = TableModel::find($table_id);
            if(!empty($table_data)){ 
                return response()->json(['success'=>'Data Get successfully', 'table_data'=> $table_data]);
            }
            else{
                return response()->json(['errors'=>'Error while adding data']);
            }
        }
        else{
            return response()->json(['errors'=>'Incorrect table details']);
        }
    }
}
