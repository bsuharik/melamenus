<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CountryCurrencyModel extends Model
{
    protected $table="currency_country"; 
    protected $primaryKey = 'country_id';
    public function __construct()
    {
    }
}
