<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use Validator; 
use Hash;
use Mail;
use Auth;
use App\Models\CategoryModel; 
use App\Models\UserModel;
use App\Models\TableModel;
use App\Models\CurrencyModel;
use App\Models\RestaurantModel;
use App\Models\CountryModel;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Session;
use App\Models\CountryCurrencyModel;
use App\Models\MenuModel;
use Illuminate\Support\Facades\File;
use App\Models\FontModel;
class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // Show Register Form
    public function showRegister()
    {
        // Get Currency Array
        $currency_array = CurrencyModel::all();
        // Get Country Array
         $country_array =array();
         $country_array = CountryModel::all();
        return view('signup',['currency_list' => $currency_array, 'country_list' => $country_array]);
    }
    // Add User
    public function doRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'      => 'required',
            'last_name'       => 'required',
            'email'           => 'required|email|unique:users,email',
            'restaurant_name' => 'required',
            //'contact_person'  => 'required',
            //'contact_number'  => 'required|numeric',
            'location'        => 'required',
            'country_id'      => 'required',
            'currency'        => 'required',
            'password'        => [
                'required',
                'min:6',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                // 'regex:/[0-9]/',
                // 'regex:/[@$!%*#?&]/'
            ],
            'password_confirmation' => 'required|min:6',
        ]);
		
        if ($validator->passes()) 
        {
            $default_font_type = FontModel::where('is_default','1')->first();

            if(!empty($default_font_type->id)){
                $font_type_id= $default_font_type->id;
            }else{
                $font_type_id= '';
            }

	
            // Add Restaurant
            $add_rest= new RestaurantModel();
                $add_rest->restaurant_name = $request->restaurant_name;
                $add_rest->contact_person  = $request->contact_person;
                $add_rest->email           = $request->email;
                //$add_rest->contact_number  = $request->contact_number;
                $add_rest->location        = $request->location;
                $add_rest->country_id      = $request->country_id;
                $add_rest->time_zone_id      = $request->country_id;
                $add_rest->currency_id     = $request->currency;
                $add_rest->restaurant_logo     = 'logo-def.png';
                $add_rest->restaurant_cover_image     = 'cover.png';
                $add_rest->is_approved     = '1';
                $add_rest->app_theme_font_type_1 = 7;
                $add_rest->app_theme_font_type_2 = 7;
                $add_rest->app_theme_font_type_3 = 7;
                $add_rest->app_theme_font_type_4 = 7;
				
				
                $add_rest->app_theme_color_1 = '#2d5090';
                $add_rest->app_theme_color_2 = '#ffffff';
                $add_rest->app_theme_color_3 = '#2d5090';
                $add_rest->app_theme_color_4 = '#b1b4bd';
				
                $add_rest->app_theme_font_style_1 = 'bold';
                $add_rest->app_theme_font_style_2 = 'bold';
                $add_rest->app_theme_font_style_3 = 'bold';
                $add_rest->app_theme_font_style_4 = 'Standard';
				
                $add_rest->created_at      = date('Y-m-d H:i:s');
                $row_added = $add_rest->save();
				
			//echo '<pre>';
			//	print_r($row_added);
			///echo '</pre>';
			//exit();
			
			
            if(!empty($row_added))
            {
				
                $restaurant_id = $add_rest->restaurant_id;
				
					$full_qr_code_image_name = '';
                    $qr_code_image_name = '';

                        for ($i=1; $i <= 1; $i++) 
                        { 
                            $chair_number = $i;
                            $directory = config('images.qr_code_url').$restaurant_id;
                            if(!File::exists($directory)) 
                            {
                                File::makeDirectory($directory);
                            }
                            $qr_code_image_name = "qrcode_1_1.png";
                            $qr_path = $directory."/".$qr_code_image_name;
                           $qr_image = TableModel::generate_qr_code($qr_path, $restaurant_id,'1','1');
                            $full_qr_code_image_name .= $qr_code_image_name." ";
                        }
                    
                    // Add row
                    $table_data= new TableModel();
                    $table_data->restaurant_id = $restaurant_id;
                    $table_data->table_number =1;
                    $table_data->chairs      = 1;
                    $table_data->qr_code      = trim($full_qr_code_image_name);
                    $table_data->created_at    = date('Y-m-d H:i:s');
                    $row_added = $table_data->save();

				$new_restaurant_id = $restaurant_id;
				
				//make dir for def logo and cover
				File::makeDirectory('uploads/images/restaurant/'.$restaurant_id);
				
				//copy default logo
                File::copy('uploads/images/logo-def.png','uploads/images/restaurant/'.$restaurant_id.'/logo-def.png');
				//copy default cover
                File::copy('uploads/images/cover.png', 'uploads/images/restaurant/'.$restaurant_id.'/cover.png');
					
				//Add Demo Menu
					// Add Parent Caregrory  Start
						$parent_category = new CategoryModel();
                        $parent_category->restaurant_id = $restaurant_id;
                        $parent_category->category_name ='FOOD (demo)';
                        $parent_category->created_at = date('Y-m-d H:i:s');
                        $parent_category->category_type = "0";
                        $parent_category->order_display = 1;
                        $is_p_saved = $parent_category->save();
					 // Add Parent Caregrory  Start
					 
						
				
					 // Add Main Caregrory  Start
						$main_category =new CategoryModel();
                        $main_category->restaurant_id = $restaurant_id;
                        $main_category->category_name ='Steaks, Seafood, & Favorites (demo)';
                        $main_category->created_at = date('Y-m-d H:i:s');
                        $main_category->category_type = "1";
						$main_category->parent_category_id = $parent_category->category_id;
                        $main_category->order_display = 1;
                        $is_m_saved = $main_category->save();
					 // Add Main Caregrory  Start
						
					 //Add Menu Item
						$menu_details_get = MenuModel::where('menu_id', 15)->with('menu_image_detail')->first(); 
                        if(!empty($menu_details_get)){
                            // Add row
                            $menu_create = new MenuModel ();
                            $menu_create->restaurant_id  = $restaurant_id;
                            $menu_create->name           = $menu_details_get->name;
                            $menu_create->slug           = $menu_details_get->slug.'-'.rand(pow(10, 2-1), pow(10, 2)-1);
                            $menu_create->price         = $menu_details_get->price;
                            $menu_create->price_description =$menu_details_get->price_description;
							$menu_create->parent_category = $parent_category->category_id;
							$menu_create->main_category  = $main_category->category_id;

                            if(!empty($menu_details_get->sub_category)){
                                $menu_sub_category = CategoryModel::where('parent_res_cat_id',$menu_details_get->sub_category)->where('restaurant_id',$new_restaurant_id)->first();
                                if(!empty($menu_sub_category->category_id)){
                                    $menu_create->sub_category  = $menu_sub_category->category_id;
                                }
                            }
                            if (! File::exists(config('images.menu_url').$new_restaurant_id)) {
                                File::makeDirectory(config('images.menu_url').$new_restaurant_id);
                            }
                            if(!empty($menu_details_get->menu_image)){
                                $oldPath = config('images.menu_url').$menu_details_get->restaurant_id.'/'.$menu_details_get->menu_image;
                                $newPath = config('images.menu_url').$new_restaurant_id.'/'.$menu_details_get->menu_image;
                                File::copy($oldPath,$newPath);   
                            }
                            $destinationPath = config('images.menu_url').$menu_details_get->restaurant_id;
                            //$menu_create->menu_image     = $menu_details_get->menu_image;
                            $menu_create->availiblity    = $menu_details_get->availiblity;
                            $menu_create->ingredients   = $menu_details_get->ingredients;
                            $menu_create->allergies     = $menu_details_get->allergies;
                            $menu_create->calories     = $menu_details_get->calories;
                            $menu_create->link     = $menu_details_get->link;
                            $menu_create->tag_id       = $menu_details_get->tag_id;
                            $menu_create->description   = $menu_details_get->description;
                            $menu_create->created_at     = date('Y-m-d H:i:s');
                            if(empty($menu_details_get->order_display)){
                                $order_menu = MenuModel::where('restaurant_id',$new_restaurant_id)->where('parent_category',$parent_category->category_id)->where('main_category',$main_category->category_id);
                                if(!empty($main_category->category_id)){
                                   $order_menu->where('sub_category',$main_category->category_id); 
                                }
                                $last_order_menu = $order_menu->first();
                                if(!empty($last_order_menu)){
                                    $menu_create->order_display = $last_order_menu->order_display + 1;
                                }else{
                                    $menu_create->order_display = 1;
                                }
                            }else{
                              $menu_create->order_display   = $menu_details_get->order_display;  
                            }
                            $is_save=$menu_create->save();
                            if(!empty($menu_details_get->menu_image_detail)){
                                foreach($menu_details_get->menu_image_detail as $menu_image){
                                    $add_menu_image =new MenuImage();
                                    if (! File::exists(config('images.menu_url').$new_restaurant_id)) {
                                        File::makeDirectory(config('images.menu_url').$new_restaurant_id);
                                    }
                                    $oldPath = config('images.menu_url').$menu_image->restaurant_id.'/'.$menu_image->image_name;
                                    $newPath = config('images.menu_url').$new_restaurant_id.'/'.$menu_image->image_name;
                                    File::copy($oldPath,$newPath); 
                                    $add_menu_image->menu_id = $menu_create->menu_id;  
                                    $add_menu_image->image_name=$menu_image->image_name;
                                    $add_menu_image->restaurant_id=$new_restaurant_id;
                                    $is_save=$add_menu_image->save();
                                }
                            } 
                        }
					 //Add Menu Item
				//Add Demo Menu
				
                // Add user
                $user_add = new UserModel();
                $user_add->first_name    = $request->first_name;
                $user_add->last_name     = $request->last_name;
                $user_add->email         = $request->email;
                $user_add->gender        = $request->gender;
                //$user_add->date_of_birth = $request->date_of_birth;
                $user_add->password      = Hash::make($request->password);
                $user_add->user_type     = '1';
                $user_add->restaurant_id = $restaurant_id;
                $user_add->created_at    = date('Y-m-d H:i:s');
                $user_row_added = $user_add->save();
                if ($user_row_added) 
                {
                    // // Send mail to user
                    $to_name  = $request->first_name." ".$request->last_name;
                    $to_email = $request->email;
                    $data = array(
                                    'restaurant_name' => $request->restaurant_name,
                                    'email'           => $request->email,
                                    'first_name'      => $request->first_name,
                                    'last_name'       => $request->last_name,
                                );
                    // Send email to restaurant owner
                    Mail::send('email.user_registartion', ["data"=>$data] , function($message) use ($to_name, $to_email){
                        $message->to($to_email, $to_name)->subject('Mela Menus - Restaurant Created');
                        $message->from('info@melamenus.com','Mela Menus');
                    });
					// Send email to Admin
                    Mail::send('email.user_registartion', ["data"=>$data] , function($message) use ($to_name, $to_email){
                        $message->to('info@melamenus.com', $to_name)->subject('Mela Menus - New Restaurant Created');
                        $message->from('info@melamenus.com','Mela Menus');
                    });

					
					Auth::loginUsingId($user_add->id);
					
					
					
					
                    return response()->json(['success'=> 'Your Restaurant - '.$request->restaurant_name.' is registered successfully. Log in to continue working']);
                }
                else
                {
                    return response()->json(['errors'=>'Error while adding data']);
                }
            }
            else
            {
                return response()->json(['errors'=>'Error while adding data']);
            }
        }
        return response()->json(['error'=>$validator->errors()]);
    }
    public function change_currency(Request $request){
        try {
            $curl = curl_init();
            if ($request->restaurant_currency =='Euro'){
                $from_Currency = 'EUR';
            }
            else{
                $from_Currency =  'USD';
            }
            $to_Currency = $request->get('currency_code');
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://currency-converter5.p.rapidapi.com/currency/convert?format=json&from={$from_Currency}&to={$to_Currency}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "x-rapidapi-host: currency-converter5.p.rapidapi.com",
                    "x-rapidapi-key: 00dd69aeb8mshd365d91575e7095p160de1jsn9fd4989c760a"
                ),
            ));
            $response = curl_exec($curl);
            // echo "<pre>";  print_r($response);echo "</pre>"; exit();
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $currencyRateArray=json_decode($response);
                Session::put('country_name',$request->country_name);
                Session::put('currancy_symbol', $request->get('curency_symbol'));
               // Session::put('formatValue', $currencyRateArray->rates->$to_Currency->rate_for_amount);
                session()->save();
            }
            return response()->json(['sucess'=>'Convert success']);
        } catch (\Exception $e) {
            return response()->json(['errors'=>$e->getMessage()]);
        }
    }
    public function change_language(Request $request){
        try { 
            Session::put('lang_sort',$request->language);
            session()->save();
            return response()->json(['sucess'=>'Convert success']);
        } catch (\Exception $e) {
            return response()->json(['errors'=>$e->getMessage()]);
        }
    }
    public function change_langauge_currency(Request $request){
         // echo "<pre>"; print_r($request->all()); echo "</pre>"; exit();
        try {
            if(!empty($request->change_language)){
                Session::put('language_id',$request->change_language);
            }
            if(empty($request->default_click) && !isset($request->default_click)){
                if(empty($request->change_currency) && empty($request->change_language)){
                   return response()->json(['select_empty'=>"Atleast One Select"]); 
                }
                if(!empty($request->change_currency)){
                    $currency_detail=CountryCurrencyModel::where('country_id',$request->change_currency)->first();
                   $curl = curl_init();
                    if ($request->restaurant_currency =='Euro'){
                        $from_Currency = 'EUR';
                    }
                    else{
                        $from_Currency =  'USD';
                    }
                    $to_Currency = $currency_detail->code;
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://currency-converter5.p.rapidapi.com/currency/convert?format=json&from={$from_Currency}&to={$to_Currency}",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array(
                            "x-rapidapi-host: currency-converter5.p.rapidapi.com",
                            "x-rapidapi-key: 00dd69aeb8mshd365d91575e7095p160de1jsn9fd4989c760a"
                        ),
                    ));
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                    if ($err) {
                        echo "cURL Error #:" . $err;
                    } else {
                        $currencyRateArray=json_decode($response);
                        Session::put('country_name',$currency_detail->country_name);
                        Session::put('currancy_symbol',$currency_detail->symbol);
                    //    Session::put('formatValue', $currencyRateArray->rates->$to_Currency->rate_for_amount);
                        session()->save();
                    }
                }
                if(!empty($request->change_language)){
                    if($request->language_detail =='en'){
                       setcookie('googtrans', '/en/en'); 
                    }else{
                        setcookie('googtrans', '/en/'.$request->language_detail); 
                    }
                    Session::put('language_id',$request->change_language);
                    session()->save();
                }
            }else{
                setcookie('googtrans', '/en/en');
                Session::forget('country_name');
                Session::forget('currancy_symbol');
                Session::forget('formatValue');
                Session::forget('language_id');
                session()->save();
            }
            return response()->json(['sucess'=>"Data Updated"]);
        } catch (\Exception $e) {
            return response()->json(['errors'=>$e->getMessage()]);
        } 
    } 
    public  function countVisitingMenuItem(Request $request){
        $menu_detail = MenuModel::find($request->menu_id);
        $menu_detail->menu_click_count=$request->count_number;
        $is_save=$menu_detail->save();
        if($is_save){
            return response()->json(['success'=>'Data update']);
        }
        else{
            return response()->json(['error'=>'Error while deleting menu details.']);
        }
        echo "<pre>"; print_r($menu_detail); echo "</pre>"; exit();
    }
}