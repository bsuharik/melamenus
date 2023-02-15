<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MyAllergyModel extends Model
{
    protected $table="my_allergy"; 
    protected $fillable = ['allergy_name','user_id','allergy_id','created_at','updated_at'];
    
    public function __construct()
    {
    }
    public function allergy_detail(){ 
        return $this->hasOne('App\Models\AllergyModel','allergy_id','allergy_id');
    }

}
