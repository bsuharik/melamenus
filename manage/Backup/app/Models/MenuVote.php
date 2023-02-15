<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class MenuVote extends Model
{ 
     protected $table="menu_votes"; 
    protected $fillable = ['restaurant_id','user_id','name','review','vote','created_at','updated_at'];
    protected $primaryKey = 'menu_vote_id';
    public function __construct()
    {
    }
    public function user_detail(){
        return $this->hasOne('App\User','id','user_id');
    }
}
