<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class TextureModel extends Model{

    protected $table="texures"; 
    protected $fillable = ['id','image'];
    public function __construct()   
    { 
    } 

}
