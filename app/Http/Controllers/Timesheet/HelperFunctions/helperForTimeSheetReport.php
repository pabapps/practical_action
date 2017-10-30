<?php

namespace App\Http\Controllers\Timesheet\HelperFunctions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Datatables;
use Crypt;
use Auth;
use App\User;
use App\UserDesignationModel;
use App\UserProjectModel;
use App\UserTimeSheetModel;
use App\Projects;
use Entrust;
use App\Mail\Welcome;
use App\Mail\WelcomeAgain;
use PDF;
use App\Jobs\SendEmail;
use Carbon\Carbon;
use Log;



class helperForTimeSheetReport {
	

	public static function get_designation_for_report($user_id, $start_date, $end_date){
		
		$user_designation = UserDesignationModel::where('user_id',$user_id)->get();

		dd($user_designation);



	}

}