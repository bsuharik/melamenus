<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use File;
use App\Models\AllergyModel;

class AllergyController extends Controller
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
    public function index()
    {
        $allergies_array=array();
        $allergies_array = AllergyModel::all();

        return view('allergies/index',['allergy_list' => $allergies_array]);
    }

    // Create allergies
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
                                'allergy_name' => 'required',
                                'allergy_icon' => 'required|mimes:jpeg,png|max:1000',
                            ]);

        if ($validator->passes()) 
        {
            $file = $request->file('allergy_icon');

            $allergy_icon_name = explode(".", $file->getClientOriginalName());
            $allergy_icon = $allergy_icon_name[0].'-'.time().".".$allergy_icon_name[1];

            // File Path
            $destinationPath = config('images.allergy_url');
            // echo "<pre>"; print_r($destinationPath); echo "</pre>"; exit();
            $file->move($destinationPath, $allergy_icon);

            $add_data = array(   
                                'allergy_name' => $request->allergy_name,
                                'allergy_icon' => $allergy_icon,
                                'created_at'   => date('Y-m-d H:i:s')
                            );

            // Create allergy row
            $allergies = new AllergyModel();
            $allergies->allergy_name=$request->allergy_name;
            $allergies->allergy_icon=$allergy_icon;
            $allergies->created_at=date('Y-m-d H:i:s');
            $is_save=$allergies->save();


            if($is_save)
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

    // Update allergy
    public function update(Request $request)
    {
        $current_allergy_icon = $request->current_allergy_icon;

        if ($current_allergy_icon == "") 
        {
            $validator = Validator::make($request->all(), [
                                    'allergy_name' => 'required',
                                    'allergy_icon' => 'required|mimes:jpeg,png|max:100',
                                ]);
        }
        else
        {
            $validator = Validator::make($request->all(), [
                                    'allergy_name' => 'required',
                                    'allergy_icon' => 'mimes:jpeg,png|max:100',
                                ]);
        }

        if ($validator->passes()) 
        {

            $allergies = AllergyModel::find($request->allergy_id);
            $file = $request->file('allergy_icon');
            if (!empty($file)){
                $allergy_icon_name = explode(".", $file->getClientOriginalName());
                $allergy_icon = $allergy_icon_name[0].'-'.time().".".$allergy_icon_name[1];
                // File Path
                $destinationPath = config('images.allergy_url');
                // Delete current file
                File::delete($destinationPath.'/'.$current_allergy_icon);
                $file->move($destinationPath,$allergy_icon);
               $allergies->allergy_icon=$allergy_icon;
            } 

            $allergies->allergy_name=$request->allergy_name;
            $allergies->updated_at=date('Y-m-d H:i:s');
            $is_save=$allergies->save();
            if($is_save)
            {
                return response()->json(['success'=>'Data Updated successfully']);
            }
            else
            {
                return response()->json(['errors'=>'Error while adding data']);
            }
        }

        return response()->json(['error'=>$validator->errors()]);
    }

    // Delete allergy details
    public function delete($id)
    {
        // Get allergy details
        $allergy_array = AllergyModel::find($id);

        if(!empty($allergy_array))
        {
            $allergy_icon = $allergy_array->allergy_icon;

            // File Path
            $destinationPath = config('images.allergy_url');

            // Delete current file
            File::delete($destinationPath.'/'.$allergy_icon);

            // Delete allergy
            $delete_allergy = $allergy_array->delete();

            if ($delete_allergy) 
            {
                return redirect()->route('allergies');
            }
            else
            {
                return back()->with('error','Error while deleting allergy details.');
            }
        }
        else
        {
            return back()->with('error','Incorrect allergy Details');
        }        
    }
}
