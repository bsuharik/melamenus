<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('restaurant_id');
            $table->integer('user_id');
            $table->string('restaurant_name');
            $table->string('contact_person');
            $table->string('email')->unique();
            $table->string('contact_number');
            $table->string('restaurant_logo');
            $table->enum('is_approved', ['0', '1','2']);
            $table->string('location');
            $table->string('app_theme_color');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
