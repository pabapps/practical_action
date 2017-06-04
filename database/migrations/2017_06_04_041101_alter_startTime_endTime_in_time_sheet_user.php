<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStartTimeEndTimeInTimeSheetUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_sheet_user', function (Blueprint $table) {
             $table->dropColumn(['start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('time_sheet_user', function (Blueprint $table) {
            $table->date('start_time');
            $table->date('end_time');
        });
    }
}
