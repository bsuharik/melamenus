<?php

namespace App\Providers; 

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; 
// use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Models\CountryModel;
use DB;

class AppServiceProvider extends ServiceProvider{
    /**
     * Bootstrap any application services. 
     *
     * @return void
     */
    public function boot()
    {
        //$translation_language = new GoogleTranslate();
        // $translation_language->setSource('en');
        // Language  List
            $language_list= array();
            $language_list = DB::table('list')->get();
        // Country  Detail
            $country_details= array();
           // $country_details=CountryModel::all(); 
           $country_details=DB::table('currency_country')->orderBy('country_name', 'asc')->get(); 

            //echo "<pre>"; print_r($country_details); echo "</pre>"; exit();
            view()->share(compact('country_details','language_list')); 
            Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
