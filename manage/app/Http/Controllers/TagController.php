<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use File;

use App\Models\TagModel;

class TagController extends Controller
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
        $tags_array = TagModel::all();

        return view('tags/index',['tag_list' => $tags_array]);
    }

    // Create Tag
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'tag_name' => 'required',
        'tag_icon' => 'required|mimes:jpeg,png|max:1000',
        ]);

        if ($validator->passes()) 
        {
            $file = $request->file('tag_icon');
            $tag_icon_name = explode(".", $file->getClientOriginalName());
            $tag_icon = $tag_icon_name[0].'-'.time().".".$tag_icon_name[1];

            // File Path
            $destinationPath = config('images.tag_url');
            $file->move($destinationPath,$tag_icon);
            $add_data = array(   
                'tag_name'   => $request->tag_name,
                'tag_icon'   => $tag_icon,
                'created_at' => date('Y-m-d H:i:s')
            );

            // Create Tag new
            $tags = new TagModel();
            $tags->tag_name= $request->tag_name;
            $tags->tag_icon= $tag_icon;
            $tags->created_at=date('Y-m-d H:i:s');
            $is_saved = $tags->save();
            if ($is_saved) {
                return response()->json(['success'=>'Data Added successfully']);
            } else {
               return response()->json(['errors'=>'Error while adding data']);
            }
        }

        return response()->json(['error'=>$validator->errors()]);
    }

    // Update Tag
    public function update(Request $request)
    {

        $current_tag_icon = $request->current_tag_icon;

        if ($current_tag_icon == "") 
        {$validator = Validator::make($request->all(), [
                                    'tag_name' => 'required',
                                    'tag_icon' => 'required|mimes:jpeg,png|max:100',
                                ]);
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'tag_name' => 'required',
            ]);
        }

        if ($validator->passes()) 
        {
            
            $file = $request->file('tag_icon');
            $tags = TagModel::find($request->tag_id);
            if (!empty($file)) 
            {
                $tag_icon_name = explode(".", $file->getClientOriginalName());
                $tag_icon = $tag_icon_name[0].'-'.time().".".$tag_icon_name[1];
                // File Path
                $destinationPath = config('images.tag_url');
                // Delete current file
                File::delete($destinationPath.'/'.$current_tag_icon);
                $file->move($destinationPath,$tag_icon);
                
                $is_saved = $tags->update([
                    "tag_name" => $request->tag_name,
                    "tag_icon" => $tag_icon,
                    "updated_at"=> date('Y-m-d H:i:s'),
                ]);
            }else{
                $is_saved = $tags->update([
                    "tag_name" => $request->tag_name,
                    "updated_at" => date('Y-m-d H:i:s'),
                ]);
            } 
            

            // Update Tag row
            if($is_saved)
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

    // Delete Tag details
    public function delete($id)
    {
        // Get Tag details
        $tags_array = TagModel::find($id);
        
        if($tags_array)
        {
            $tag_icon = $tags_array->tag_icon;

            // File Path
            $destinationPath = config('images.tag_url');

            // Delete current file
            File::delete($destinationPath.'/'.$tag_icon);

            // Delete Tag
            $delete_tag = $tags_array->delete();

            if ($delete_tag) 
            {
                return redirect()->route('tags');
            }
            else
            {
                return back()->with('error','Error while deleting Tag details.');
            }
        }
        else
        {
            return back()->with('error','Incorrect Tag Details');
        }        
    }
}
