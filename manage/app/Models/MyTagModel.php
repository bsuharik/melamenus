<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MyTagModel extends Model
{
    protected $table="my_tag"; 
    protected $fillable = ['tag_name','user_id','tag_id','created_at','updated_at'];
    public function __construct()
    {
    } 
    public function tag_detail(){ 
        return $this->hasOne('App\Models\TagModel','tag_id','tag_id');
    }
}
