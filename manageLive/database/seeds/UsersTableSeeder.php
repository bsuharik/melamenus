<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{

	public function run()
	{
	    DB::table('users')->delete();
	    User::create(array(
	        'restaurant_name' => '',
	        'first_name' 	  => 'Admin',
	        'last_name'    	  => 'User',
	        'email'    		  => 'admin@gmail.com',
	        'contact_number'  => '123456789',
	        'location'        => 'Ahmedabad',
	        'user_type'       => '0',
	        'password'        => Hash::make('123456'),
	    ));
	}

}
