<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('menu_id');
            $table->string('name');
            $table->string('description');
            $table->string('menu_image');
            $table->string('price');
            $table->integer('parent_category');
            $table->integer('main_category');
            $table->integer('sub_category');
            $table->enum('availiblity', ['0', '1'])->comment("0=Available,1=Not Available");
            $table->string('ingredients');
            $table->string('allergies');
            $table->string('calories');
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
        Schema::dropIfExists('menus');
    }
}
