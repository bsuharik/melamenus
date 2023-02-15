<?php

use Illuminate\Database\Seeder;
use App\User;

class RestaurantsTableSeeder extends Seeder
{

	public function run()
	{
	    DB::table('restaurants')->delete();
	    User::create(array(
	        'restaurant_name' => 'Test Restaurant 1',
	        'contact_person'  => 'Restaurant Admin',
	        'email'    		  => 'restaurant@gmail.com',
	        'contact_number'  => '123456789',
	        'location'        => 'Ahmedabad',
	    ));
	}

}
