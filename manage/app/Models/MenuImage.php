<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MenuImage extends Model
{ 
    protected $table="menu_image"; 
    protected $fillable = ['restaurant_id','image_name','menu_id'];
    
    public function __construct()
    {
    }
}
