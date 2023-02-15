<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FontModel extends Model{

    protected $table="font_type_style"; 

    protected $fillable = ['restaurant_id','name','created_at','updated_at','is_default'];

    public function __construct()

    {

    }

}

