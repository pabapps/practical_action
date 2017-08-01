<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatTimeSheetUserModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_sheet_user', function (Blueprint $table) {
             
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->time('start_time');
            $table->time('end_time');
            $table->date('date');
            $table->string('activity');
            $table->string('remarks')->nullable();
            $table->string('location');
            $table->tinyInteger('valid')->default(1); // 1 = valid, 0 = invalid (basically deleted or not)
            $table->tinyInteger('sent_to_manager')->default(0); // 0 = data can de edited by the user, anyother numbers mean the id of the linemanager, -1 = means that use has the permission to skip line manager when submmitting the time sheet and goes directly to the account manager 
            $table->tinyInteger('sent_to_accounts')->default(0); // 0 = data can de edited by the line manager, 1 = data sent to the accounts, 2 = data has been approved by the accounts department now being pushed forward for reporting 
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
        Schema::dropIfExists('time_sheet_user');
    }
}
