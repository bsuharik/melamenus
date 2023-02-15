<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CategoryModel extends Model
{
    protected $table="category"; 
    protected $fillable = ['restaurant_id','parent_category_id','main_category_id','category_type','category_name','created_at','updated_at'];
    protected $primaryKey = 'category_id';
    public function __construct()
    {
    }
}
