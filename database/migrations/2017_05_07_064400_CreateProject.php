<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
             

            $table->increments('id');
            $table->string('project_name');
            $table->integer('swif_code');
            $table->tinyInteger('valid')->default(1); // 1 = valid, 0 = invalid (basically deleted or not)
            $table->tinyInteger('completion_status')->default(1); //0 =postpone, 1 = onging, 2 = done (basically deleted or not)
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
        Schema::drop('projects');
    }
}
