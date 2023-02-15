<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AllergyModel extends Model
{
    protected $table="allergies"; 
    protected $fillable = ['allergy_name','allergy_icon','created_at','updated_at'];
    protected $primaryKey = 'allergy_id';
    public function __construct()
    {
    }
}
