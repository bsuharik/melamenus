<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CurrencyModel extends Model
{
    protected $table="currency"; 
    protected $fillable = ['currency_name','currency_icon','created_at','updated_at'];
    protected $primaryKey = 'currency_id';
    public function __construct()
    {
    }
}
