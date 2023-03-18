<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
use Validator; 
use Hash;
use Mail;
use App\Models\UserModel;
use App\Models\CurrencyModel;
use App\Models\RestaurantModel;
use App\Models\CountryModel;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Session;
use App\Models\CountryCurrencyModel;
use App\Models\MenuModel;
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
			//echo '<pre>';
			//	print_r($default_font_type);
			//echo '</pre>';
			//exit();
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
                $add_rest->is_approved     = '1';
                $add_rest->app_theme_font_type_1 = $font_type_id;
                $add_rest->app_theme_font_type_2 = $font_type_id;
                $add_rest->app_theme_font_type_3 = $font_type_id;
                $add_rest->app_theme_font_type_4 = $font_type_id;
                $add_rest->created_at      = date('Y-m-d H:i:s');
                $row_added = $add_rest->save();
            if(!empty($row_added))
            {
                $restaurant_id = $add_rest->restaurant_id;
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
                $user_row_added= $user_add->save();
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
                    /*Mail::send('email.user_registartion', ["data"=>$data] , function($message) use ($to_name, $to_email){
                        $message->to($to_email, $to_name)->subject('Mela Menus - Restaurant Created');
                        $message->from('testcrestemail@gmail.com','Mela Menus');
                    });*/
                    return response()->json(['success'=> 'Your Restaurant - '.$request->restaurant_name.' is registered successfully. Wait for admin to approve your restaurant request']);
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
                Session::put('formatValue', $currencyRateArray->rates->$to_Currency->rate_for_amount);
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
                        Session::put('formatValue', $currencyRateArray->rates->$to_Currency->rate_for_amount);
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