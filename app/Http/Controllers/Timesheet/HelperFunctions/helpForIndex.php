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


 }