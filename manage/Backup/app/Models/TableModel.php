<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use File;
use QrCode;
class TableModel extends Model{
    protected $table="restaurant_tables"; 
    protected $fillable = ['restaurant_id','table_number','chairs','qr_code','created_at','updated_at'];
    protected $primaryKey = 'table_id';
    public function __construct()
    {
    }

    // Delete Qr code table
    public static function delete_table_qr_codes($restaurant_id,$qr_codes)
    {
        if ($qr_codes != ""){
            $qr_codes_array = explode(" ", $qr_codes);
            foreach ($qr_codes_array as $key => $value){
                // File Path
                $destinationPath = config('images.qr_code_url').$restaurant_id;
                // Delete current file
                File::delete($destinationPath.'/'.$value);
            }
            return 1;
        }
        else{
            return 0;
        }
    }

    // Generate QR code
    public static function generate_qr_code($qr_path, $restaurant_id,$table_number,$chair_number)
    {
    	$path = config('app.url')."/user_home/".$restaurant_id."?table_no=".$table_number."&chair_no=".$chair_number;
        $logo_url = config('images.site_logo_url');
        $qr_image = QrCode::format('png')->size(300)->errorCorrection('H')->merge($logo_url)
                    ->color(103,66,168)->generate($path,public_path($qr_path));
        return 1;
    }
    // Get restaturant Row
    // public static function get_one_table_row($table_id)
    // {
    //     $table_details = DB::select('select * from restaurant_tables where table_id='.$table_id);

    //     if ($table_details) 
    //     {
    //         $table_array = $table_details[0];
    //     }
    //     else
    //     {
    //         $table_array = array();
    //     }

    //     return $table_array;
    // }

    // Get restaturant Row
    // public static function get_all_tables()
    // {
    //     $tables = DB::select('select * from restaurant_tables order by table_number');

    //     if ($tables) 
    //     {
    //     	$table_array = $tables;
    //     }
    //     else
    //     {
    //     	$table_array = array();
    //     }

    //     return $table_array;
    // }

    // Get restaturant tables
    // public static function get_restaurant_tables($restaurant_id)
    // {
    //     $tables = DB::select('select * from restaurant_tables where restaurant_id = '.$restaurant_id);

    //     if ($tables) 
    //     {
    //         $table_array = $tables;
    //     }
    //     else
    //     {
    //         $table_array = array();
    //     }

    //     return $table_array;
    // }

    // create table
    // public static function create_table_details($create_data = array())
    // {
    //     $row_added = DB::table('restaurant_tables')->insert($create_data);

    //     if($row_added) 
    //     {
    //         return 1;
    //     }
    //     else
    //     {
    //         return 0;
    //     }
    // }

   
    // Delete table
    // public static function delete_table_details($table_id)
    // {
    //     $table_details = self::get_one_table_row($table_id);

    //     if ($table_details) 
    //     {
    //         $restaurant_id = $table_details->restaurant_id;
    //         $qr_codes      = $table_details->qr_code;
    //         // Delete QR codes
    //         self::delete_table_qr_codes($restaurant_id, $qr_codes);
    //         $delete_table = DB::table('restaurant_tables')->where('table_id', $table_id)->delete();
    //         if ($delete_table){
    //             return 1;
    //         }
    //         else{
    //             return 0;
    //         }
    //     }
    //     else
    //     {
    //         return 0;
    //     }
    // }


    // Get restaturant Row
    // public static function check_unique_table_number($table_number, $restaurant_id, $table_id="")
    // {
    //     if ($table_id != "") 
    //     {
    //         $table_details = DB::select('select table_number from restaurant_tables where (table_number ='.$table_number.' and table_id != '.$table_id.' and restaurant_id = '.$restaurant_id.')');
    //     }
    //     else
    //     {
    //         $table_details = DB::select('select table_number from restaurant_tables where (table_number ='.$table_number.' and restaurant_id = '.$restaurant_id.')');
    //     }

    //     if (count($table_details) == "0") 
    //     {
    //         return 1;
    //     }
    //     else
    //     {
    //         return 0;
    //     }
    // }
}
