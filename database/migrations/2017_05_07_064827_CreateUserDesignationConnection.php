<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDesignationConnection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_designation_connection', function (Blueprint $table) {
             
            $table->increments('id');
            $table->integer('designation_id')->unsigned();
            $table->integer('users_id')->unsigned();
            $table->tinyInteger('valid')->default(1); // 1 = valid, 0 = invalid (basically deleted or not)
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
        Schema::dropIfExists('user_designation_connection');
    }
}
