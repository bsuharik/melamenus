<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ViewsModel extends Model{

    protected $table="restaurant_view"; 
    protected $fillable = ['restaurant_id'];
    public function __construct()   
    { 
    } 

}
