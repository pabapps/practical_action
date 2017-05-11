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
            $table->integer('user_id')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->time('allocated_time');
            $table->tinyInteger('valid')->default(1); // 1 = valid, 0 = invalid (basically deleted or not)
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('project_id')->references('id')->on('projects')
                ->onUpdate('cascade')->onDelete('cascade');


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
