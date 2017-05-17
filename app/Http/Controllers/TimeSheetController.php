<?php

namespace App\Http\Controllers;

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


class TimeSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    	$user = Auth::user();


    	/**
    	 * user id, name and designation 
    	 */
    	$user_info = DB::table('user_designation_connection')
    	->join('designation','designation.id','=','user_designation_connection.designation_id')
    	->join('users','users.id','=','user_designation_connection.user_id')
    	->select('designation.position_name','users.name','users.id')->where('users.id',$user->id)->get();    

    	/**
    	 * list of the projects in which a user is connected along with their time sheet data
    	 */

    	$user_projects = DB::table('users_projects_connection')
    	->join('projects','projects.id', '=','users_projects_connection.project_id')
    	->select('projects.project_name','users_projects_connection.project_id','users_projects_connection.allocated_time',
    		'users_projects_connection.allocated_days')->where('users_projects_connection.user_id',$user->id)->where('users_projects_connection.valid',1)->get();

        // dd($user_projects);

        /**
         * use time sheet details
         */
        // $user_time_sheet = DB::table('time_sheet_user')
        // ->select('project_id','start_time','end_time')->where('user_id',$user->id)->where('valid',1)->get();

        $query_time_sheet = "
        SELECT project_id, TIME_TO_SEC(TIMEDIFF(end_time,start_time)) diff FROM time_sheet_user WHERE user_id='$user->id'";

        $user_time_sheet = DB::select($query_time_sheet);

        // dd($user_time_sheet);

        $not_exist = true;

        $array = array();

        foreach ($user_time_sheet as $time_sheet) {

            $not_exist = true;

            if(array_key_exists ( $time_sheet->project_id ,  $array )){

                $val = $array[$time_sheet->project_id];

                $val = $val + $time_sheet->diff;

                $array[$time_sheet->project_id] = $val ;

                $not_exist = false;

            }

            if($not_exist){
                $array[$time_sheet->project_id] = $time_sheet->diff ;
            }
        }


        $final_array = array();
        $counter = 0;

        foreach ($user_projects as $time_sheet) {

            if(array_key_exists ( $time_sheet->project_id , $array )){

                $user_seconds = $array[$time_sheet->project_id];

                $allocated_days = $time_sheet->allocated_days;

                $project_name = $time_sheet->project_name;

                $days = floatval($allocated_days);

                // start by converting to seconds
                
                $seconds = ($days * 8 * 3600);

                $deducted_seconds = $seconds - $user_seconds;


                //converting seconds into hour

                $seconds_to_hours = ($deducted_seconds / 3600);
                $hours = floor($seconds_to_hours);    
                $fraction_hour = $seconds_to_hours - $hours ;

                //converting fraction hours into minutes

                $fraction_minutes = ($fraction_hour * 60);

                $minutes = ceil($fraction_minutes);

                if($minutes == 60){

                    $hours ++;

                    $minutes = 0;

                }

                $final_deducted_time = $hours. ' hours ' . $minutes . ' mins';


                $final_array[$counter] = array(
                    'project_name'=> $project_name,
                    'allocated_days'=> $allocated_days,
                    'allocated_time'=> $time_sheet->allocated_time,
                    'final_deducted_time'=>$final_deducted_time,
                    'project_id'=>$time_sheet->project_id

                    );

                $counter++;


            }
            
        }

        

        

        foreach ($user_projects as $u_project) {

            $counter = 0;

            $missing_project_id = -1;

            foreach ($final_array as $array) {
                if($array['project_id'] == $u_project->project_id ){                   
                     $missing_project_id = -1;
                     break;
                }else{
                    $missing_project_id = $u_project->project_id;

                }
                $counter ++;
            }


            if($missing_project_id != -1){
                $counter++;
                $final_array[$counter] = array(
                    'project_name'=> $u_project->project_name,
                    'allocated_days'=> $u_project->allocated_days,
                    'allocated_time'=> $u_project->allocated_time,
                    'final_deducted_time'=>'-',
                    'project_id'=>$time_sheet->project_id

                    );
            }

        }





        // dd($final_array);
        if(count($final_array)>0) {
            return view('timesheet.timesheet_create')->with('user_projects',$user_projects)->with('user_info',$user_info[0])
            ->with('final_array',$final_array);

        }else{

            return view('timesheet.timesheet_create')->with('user_projects',$user_projects)->with('user_info',$user_info[0]);
        }

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $user_time_sheet = new UserTimeSheetModel;

        $user_time_sheet->project_id = $request->project_name_modal;
        $user_time_sheet->user_id = $request->user_id;
        $user_time_sheet->start_time = $request->start_time;
        $user_time_sheet->end_time = $request->end_time;
        $user_time_sheet->date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->entry_date)->toDateString();
        $user_time_sheet->activity = $request->activity;

        if(isset($request->remarks_modal)){
            $user_time_sheet->remarks = $request->remarks_modal;
        }

        $user_time_sheet->location = $request->location_modal;

        $user_time_sheet->save();

        dd("done");


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
