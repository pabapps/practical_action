<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddByPassLineManagerToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * this is a special column for specific users,
         * if the column is active ( value is 1), user can submit the timesheet directly 
         * to the accounts manager. Users does not require to be checked by his/her line manager.
         * However, if the column is inactive, user has to go through the normal process. That means,
         * his/her timesheet has to be checked by the respectable line manager.
         *  
         */
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('byPass_line_manger')->nullable(); // 0=inactive, 1=active
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('byPass_line_manger');
        });
    }
}
