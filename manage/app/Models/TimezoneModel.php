<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use DB;



class CountryModel extends Model

{

    protected $table="timezone"; 

    protected $primaryKey = 'id';

    public function __construct()

    {

    }

}
