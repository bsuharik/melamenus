<?php

/*



|--------------------------------------------------------------------------



| Web Routes 



|--------------------------------------------------------------------------



|



| Here is where you can register web routes for your application. These



| routes are loaded by the RouteServiceProvider within a group which



| contains the "web" middleware group. Now create something great!



|



*/


Route::get('auth/{driver}', 'SocialLoginController@redirectToProvider')->name('social.oauth');



Route::get('auth/{driver}/callback', 'SocialLoginController@handleProviderCallback')->name('social.callback'); 


// route to show the login form



Route::get('/signup', 'RegisterController@showRegister'); 



Route::post('register_user', 'RegisterController@doRegister');

// change language


Route::post('change_currency','RegisterController@change_currency');



Route::post('change_language','RegisterController@change_language');



Route::post('change_language_currency','RegisterController@change_langauge_currency');


Route::post('visit_menu_item_count', 'RegisterController@countVisitingMenuItem');


// route to show the login form



Route::get('/', 'LoginController@showLogin');


Route::get('login', array('uses' => 'LoginController@showLogin'));


// route to process the form



Route::post('login', array('uses' => 'LoginController@doLogin'));



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
 



// Route::get('logout', array(['as' => 'logout', 'uses' => 'HomeController@doLogout'])); #logout

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// Restaurant Listing 



use App\Http\Middleware\CheckUserAccess;



Route::get('/restaurant', 'HomeController@restaurant')->name('restaurant')->middleware(CheckUserAccess::class);

// Restaurant Details 



use App\Http\Middleware\CheckValidRestaurant;



Route::get('/restaurant-detail/{id}', 'RestaurantController@restaurant_details')->name('restaurant-detail')->middleware(CheckValidRestaurant::class);

// Update Restaurant Details 



Route::get('/restaurant_profile/{id}', 'RestaurantController@update_restaurant_details')->middleware(CheckValidRestaurant::class);



Route::post('restaurant_profile', 'RestaurantController@update_restaurant');

// Menu Details

Route::get('/menu/{id}', 'MenuController@index')->name('menu')->middleware(CheckValidRestaurant::class); #list



Route::get('/new_menu/{id}', 'MenuController@create')->name('new_menu'); #add menu form



Route::post('add_restaurant_menu', 'MenuController@create_restaurant_menu'); #insert menu



Route::get('/menu-detail/{id}', 'MenuController@view')->name('menu-detail'); 



Route::get('/menu-update/{id}', 'MenuController@update')->name('menu-update'); #update menu form



Route::post('update_restaurant_menu', 'MenuController@update_restaurant_menu'); #update menu



Route::get('/menu-delete/{id}', 'MenuController@delete')->name('menu-delete'); #delete menu







Route::post('add_menu_image', 'MenuController@add_menu_image'); #insert menu image



Route::post('/import_menu_item', 'MenuController@import_menu');#import menu item



   



Route::get('/filter_menu/{id}', 'MenuController@filters'); #Category filters



Route::post('/filter_menu/{id}', 'MenuController@filters'); #Category filters

	

Route::post('save_menu_order','MenuController@save_menu_order'); #save_menu_order





// Category Details  



Route::get('/category/{id}', 'CategoryController@index')->name('category')->middleware(CheckValidRestaurant::class); #list



Route::post('update_restaurant_category', 'CategoryController@update_restaurant_category'); #update category



Route::get('/category-delete/{id}', 'CategoryController@delete')->name('category-delete'); #delete category   



Route::post('add_category', 'CategoryController@create'); #add category







Route::post('add_parent_category', 'CategoryController@create_parent_category');



Route::post('add_main_category', 'CategoryController@create_main_category');



Route::post('add_sub_category', 'CategoryController@create_sub_category');







Route::post('select_main_category', 'CategoryController@get_main_categories');



Route::post('select_sub_category', 'CategoryController@get_sub_categories');







Route::get('/filter_category/{id}', 'CategoryController@filters'); #Category filters



Route::post('/filter_category/{id}', 'CategoryController@filters'); #Category filters







Route::post('save_category_order', 'CategoryController@save_category_order'); #save_category_order



Route::post('update_menu', 'CategoryController@update_menu'); #update menu name 







// Table Details



Route::get('/table/{id}', 'TableController@index')->name('table')->middleware(CheckValidRestaurant::class);



Route::post('add_table', 'TableController@create'); #add



Route::post('import_table', 'TableController@import'); #import csv



Route::post('update_table', 'TableController@update'); #update



Route::get('/table-delete/{id}', 'TableController@delete')->name('table-delete'); #delete



Route::post('get_table_qr_codes', 'TableController@get'); #get QR codes



// Font Details







Route::post('add_font', 'FontController@add_font'); #add







// Approve Restaurant



Route::get('/approve_restaurant/{id}', 'HomeController@approve_restaurant_request')->middleware(CheckUserAccess::class);







// Reject Restaurant



Route::get('/reject_restaurant/{id}', 'HomeController@reject_restaurant_request')->middleware(CheckUserAccess::class);







// Tags



Route::get('/tags', 'TagController@index')->name('tags')->middleware(CheckUserAccess::class);



Route::post('add_tag', 'TagController@create')->middleware(CheckUserAccess::class); #add



Route::post('update_tag', 'TagController@update')->middleware(CheckUserAccess::class); #update



Route::get('/tag-delete/{id}', 'TagController@delete')->name('tag-delete')->middleware(CheckUserAccess::class); #delete







// Allergies



Route::get('/allergies', 'AllergyController@index')->name('allergies')->middleware(CheckUserAccess::class);



Route::post('add_allergy', 'AllergyController@create')->middleware(CheckUserAccess::class); #add



Route::post('update_allergy', 'AllergyController@update')->middleware(CheckUserAccess::class); #update



Route::get('/allergy-delete/{id}', 'AllergyController@delete')->name('allergy-delete')->middleware(CheckUserAccess::class); #delete







// Textures



Route::get('/textures', 'HomeController@texture_list')->name('textures')->middleware(CheckUserAccess::class);



Route::post('add_texture', 'HomeController@create_texture')->middleware(CheckUserAccess::class); #add



Route::post('update_texture', 'HomeController@update_texture')->middleware(CheckUserAccess::class); #update



Route::get('/texture-delete/{id}', 'HomeController@delete_texture')->name('texture-delete')->middleware(CheckUserAccess::class); #delete 







//Users



Route::get('/users', 'HomeController@get_app_users')->name('users');



Route::post('create_user', 'HomeController@create_user'); #create restaurant user 







// User APP routes



use App\Http\Middleware\CheckAppUserAccess; 



Route::get('/user_signup/{id}', 'UserController@showRegister')->middleware(CheckAppUserAccess::class);



Route::post('user_register', 'UserController@doRegister')->middleware(CheckAppUserAccess::class);



Route::get('user_login/{id}', array('uses' => 'UserController@showLogin'))->middleware(CheckAppUserAccess::class);



 



//Route::get('/user_home/{id}', 'UserController@index')->name('user_home')->middleware(CheckAppUserAccess::class);
Route::get('/user_home/{id}', 'UserController@index')->name('user_home');



//Route::get('/main_categories/{parent_category}', 'UserController@main_categories')->name('main_categories')->middleware(CheckAppUserAccess::class);
Route::get('/main_categories/{parent_category}', 'UserController@main_categories')->name('main_categories');



//Route::get('/sub_categories/{main_category}', 'UserController@sub_categories')->name('sub_categories')->middleware(CheckAppUserAccess::class);
Route::get('/sub_categories/{main_category}', 'UserController@sub_categories')->name('sub_categories');



//Route::get('/menu_items/{sub_category}', 'UserController@menu_items')->name('menu_items')->middleware(CheckAppUserAccess::class);
Route::get('/menu_items/{sub_category}', 'UserController@menu_items')->name('menu_items');



//Route::get('/menu-details/{menu_id}', 'UserController@menu_details')->name('menu-details')->middleware(CheckAppUserAccess::class);
Route::get('/menu-details/{menu_id}', 'UserController@menu_details')->name('menu-details');



Route::post('select_tag_menus', 'UserController@get_menus_by_tag')->middleware(CheckAppUserAccess::class);



Route::post('get_menu_tags', 'UserController@get_multiple_tag_details')->middleware(CheckAppUserAccess::class);



Route::post('like_menu_item', 'UserController@like_menu_item')->middleware(CheckAppUserAccess::class);



Route::post('unlike_menu_item', 'UserController@dislike_menu_item')->middleware(CheckAppUserAccess::class);



Route::post('add_menu_review', 'UserController@review_menu_item')->middleware(CheckAppUserAccess::class);



// fav and unFav menu



Route::post('fav_menu_item', 'UserController@fav_menu_item')->middleware(CheckAppUserAccess::class);



// fav and unFav Restaurant



Route::post('fav_restaurant', 'UserController@fav_restaurant')->middleware(CheckAppUserAccess::class);







Route::post('select_parent_category_menus', 'UserController@get_menus_by_parent_category')->middleware(CheckAppUserAccess::class);



Route::post('select_top_rated_menus', 'UserController@get_top_rated_menus_by_parent_category')->middleware(CheckAppUserAccess::class);







Route::get('profile/{id}', array('uses' => 'UserController@profile'))->middleware(CheckAppUserAccess::class);



Route::get('my_profile/{id}', array('uses' => 'UserController@user_profile'))->middleware(CheckAppUserAccess::class);



Route::get('allergies/{id}', array('uses' => 'UserController@user_profile'))->middleware(CheckAppUserAccess::class);



Route::get('tags/{id}', array('uses' => 'UserController@user_profile'))->middleware(CheckAppUserAccess::class);



Route::get('favourite/{id}', array('uses' => 'UserController@user_profile'))->middleware(CheckAppUserAccess::class);



Route::post('update_allergy_and_tag', 'UserController@update_allergy_and_tag');



Route::post('update_user_profile', 'UserController@update_user_profile');



Route::match(['GET', 'POST'],'/search/{id}', 'UserController@get_search')->middleware(CheckAppUserAccess::class);



// Route::post('search/{id}', 'UserController@get_search')->middleware(CheckAppUserAccess::class);



Route::post('serch_menu_item', 'UserController@serch_menu_item');