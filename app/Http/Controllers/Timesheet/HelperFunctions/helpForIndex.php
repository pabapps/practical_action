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

class helpForIndex{

 	 //selecting the projects that this user has been assigned
	public static function help_index(){

		$user = Auth::user();
		
		$project_list = DB::table('users_projects_connection')
		->join('projects','projects.id','=','users_projects_connection.project_id')
		->select('users_projects_connection.project_id','projects.project_name')
		->where('users_projects_connection.user_id',$user->id)
		->where('users_projects_connection.valid',1)
		->get();

		return $project_list;

	}



	public static function help_project_details_for_timesheet($request){
		$user = AUTH::user();

		$id = $request->project_id;

		$start_date = $request->start_date;

		$end_date = $request->end_date;

		$time_sheet_log = "";

		$start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $start_date)->toDateString();
		$end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $end_date)->toDateString();

		if($id=="all"){

			$time_sheet_log = DB::table('time_sheet_user')
			->join('projects','projects.id','=','time_sheet_user.project_id')
			->select('time_sheet_user.id','projects.project_name','time_sheet_user.date','time_sheet_user.activity','time_sheet_user.time_spent')
			->where('time_sheet_user.user_id',$user->id)
			->where('time_sheet_user.sent_to_manager',0)
			->whereBetween('time_sheet_user.date',[$start_date,$end_date])->get();            

		}else{

			$time_sheet_log = DB::table('time_sheet_user')
			->join('projects','projects.id','=','time_sheet_user.project_id')
			->select('time_sheet_user.id','projects.project_name','time_sheet_user.date','time_sheet_user.activity','time_sheet_user.time_spent')
			->where('time_sheet_user.user_id',$user->id)
			->where('time_sheet_user.project_id',$id)
			->where('time_sheet_user.sent_to_manager',0)
			->whereBetween('time_sheet_user.date',[$start_date,$end_date])
			->get();

		}

		return $time_sheet_log; 		
	}


}