<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designation', function (Blueprint $table) {


            $table->increments('id');
            $table->string('position_name');
            $table->integer('department_id')->unsigned();
            $table->smallInteger('valid')->default(1); // 1 = valid , 0 = invalid 
            $table->timestamps();


            $table->foreign('department_id')->references('id')->on('department')
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
        Schema::dropIfExists('designation');
    }
}
