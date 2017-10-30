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
use App\Designation;
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

		// dd($user_designation);

		$designation_id = 0;

		foreach ($user_designation as $designation) {

			$old_designation_start_date = date_create($designation->start_date);

			$old_designation_start_date = date_format($old_designation_start_date, "d-m-Y");

			$old_designation_end_date = date_create($designation->end_date);

			$old_designation_end_date = date_format($old_designation_end_date, "d-m-Y");

			if($designation->valid == 0){
				if(strtotime($start_date)>= strtotime($old_designation_start_date) && strtotime($start_date)<strtotime($old_designation_end_date)){
						
					if(strtotime($end_date)>strtotime($old_designation_start_date) && strtotime($end_date)<=strtotime($old_designation_end_date)){
						
						$designation_id = $designation->designation_id;
						break;
					}
				}

			}else{
				
				if(strtotime($start_date)>= strtotime($old_designation_start_date)){
					$designation_id = $designation->designation_id;
					break;
				}
			}


		}

		$designation = Designation::where("id",$designation_id)->first();
		return $designation;


	}

}