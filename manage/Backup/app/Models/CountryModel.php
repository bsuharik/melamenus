<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CountryModel extends Model
{
    protected $table="countries"; 
    protected $fillable = ['phone_code','country_code','country_name'];
    protected $primaryKey = 'country_id';
    public function __construct()
    {
    }
}
