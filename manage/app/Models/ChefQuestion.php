<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ChefQuestion extends Model{ 
    protected $table="chef_questions"; 
    protected $fillable = ['menu_id','restaurant_id','question','option_1','option_2','option_2','option_4','option_5','created_at','updated_at'];
    protected $primaryKey = 'chef_question_id';
    public function __construct()
    {
    }

}
