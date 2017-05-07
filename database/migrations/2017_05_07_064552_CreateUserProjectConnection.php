<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProjectConnection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_projects_connection', function (Blueprint $table) {


            $table->increments('id');
            $table->integer('users_id')->unsigned();
            $table->integer('project_id')->unsigned();
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
        Schema::drop('users_projects_connection');
    }
}
