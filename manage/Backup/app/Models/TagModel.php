<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class TagModel extends Model{

    protected $table="tags"; 
    protected $fillable = ['tag_name','tag_icon'];
    protected $primaryKey = 'tag_id';
    public function __construct()   
    { 
    } 

}
