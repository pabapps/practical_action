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
use App\Projects;
use Entrust;
use App\Mail\Welcome;
use App\Mail\WelcomeAgain;
use PDF;


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

        //user info
        $user = Auth::user();

        //selecting the projects that this user has been assigned
        $project_list = DB::table('users_projects_connection')
        ->join('projects','projects.id','=','users_projects_connection.project_id')
        ->select('users_projects_connection.project_id','projects.project_name')
        ->where('users_projects_connection.user_id',$user->id)
        ->where('users_projects_connection.valid',1)
        ->get();


        //checking if the are any projects that has been assigned to this user or not
        //if not then just show the page

        if(count($project_list)>0){
            return view('timesheet.timesheet_index')->with('project_list',$project_list);
        }else{
            return view('timesheet.timesheet_index');    
        }                

        
    }


    /**
     * fetching all the relavent timesheet info/log that the user had entered for this project but didnot submit
     * the data to the manager
     */

    public function project_details_for_timesheet(Request $request,$id,$start_date,$end_date){

        $user = AUTH::user();

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

        // dd($time_sheet_log);

        $time_collection = collect($time_sheet_log);
    // dd($reservation_collection);
        return Datatables::of($time_collection)
        ->addColumn('action', function ($time_collection) {
            return 

            ' <a href="'. url('/timesheet') . '/' . 
            Crypt::encrypt($time_collection->id) . 
            '/edit' .'"' . 
            'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Details</a>';
        })
        ->editColumn('id', '{{$id}}')
        ->setRowId('id')
        ->make(true);



    }

    function sum_the_time($time1, $time2) {
      $times = array($time1, $time2);
      $seconds = 0;
      foreach ($times as $time)
      {
        list($hour,$minute,$second) = explode(':', $time);
        $seconds += $hour*3600;
        $seconds += $minute*60;
        $seconds += $second;
    }
    $hours = floor($seconds/3600);
    $seconds -= $hours*3600;
    $minutes  = floor($seconds/60);
    $seconds -= $minutes*60;
    return "{$hours}:{$minutes}:{$seconds}";
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    	$user = Auth::user();

        // dd("working");


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

        if(count($user_info)==0){


            $request->session()->flash('alert-danger', 'This user designation has not been assigned yet. Please do that first!');

            return redirect()->back();

        }

        $user_projects = DB::table('users_projects_connection')
        ->join('projects','projects.id', '=','users_projects_connection.project_id')
        ->select('projects.project_name','users_projects_connection.project_id','users_projects_connection.allocated_time',
          'users_projects_connection.allocated_days')
        ->where('users_projects_connection.user_id',$user->id)
        ->where('users_projects_connection.valid',1)->get();

        // dd($user_projects);

        /**
         * use time sheet details
         */

        $query_time_sheet = "
        SELECT project_id, time_spent FROM time_sheet_user WHERE user_id='$user->id' AND valid=1";

        $user_time_sheet = DB::select($query_time_sheet);

        // dd($user_time_sheet);

        $not_exist = true;

        $array = array();

        /**
         * If the project_id already exist, we are just adding the new time value with the existing 
         * time value to get an updated time value which is again is being saved in the array with the same
         * project_id key.
         *
         * However, if the project_id doesnot exist then we are creating a new array with the project_id
         * as key.
         */

        foreach ($user_time_sheet as $time_sheet) {

            $not_exist = true;

            if(array_key_exists ( $time_sheet->project_id ,  $array )){

                $time = $array[$time_sheet->project_id];

                $time2 = $time_sheet->time_spent;

                // $secs = strtotime($time2)-strtotime("00:00:00");

                // $result = date("H:i:s",strtotime($time)+$secs);


                // $array[$time_sheet->project_id] = $result ;
                $array[$time_sheet->project_id] = $this->sum_the_time($time,$time2);

                $not_exist = false;

            }

            if($not_exist){
                $array[$time_sheet->project_id] = $time_sheet->time_spent ;
            }
        }

        // dd($array);

        //calculating the time, conveting days or the percentage into hours and mins

        $final_array = array();
        $counter = 0;

        foreach ($user_projects as $time_sheet) {

            if(array_key_exists ( $time_sheet->project_id , $array )){

                $user_seconds = $array[$time_sheet->project_id];

                
                list($hour,$minute,$second) = explode(':', $user_seconds);

                    //converting hour into second
                $hour = $hour * 60 * 60;

                $minute = $minute * 60;

                $total_time = $hour + $minute;

                
                

                $user_seconds = $total_time;



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

        // checking if the project exists in the array 

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
                'project_id'=>$u_project->project_id

                );


        }





    }

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
        $user_time_sheet->time_spent = $request->time_sheet;
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
    public function edit($id){

        $user = Auth::user();

        $user_id = $user->id;

        $time_sheet_id=Crypt::decrypt($id);
        

        $time_sheet_data = UserTimeSheetModel::findOrFail($time_sheet_id);

        $date = $time_sheet_data->date;

        $date=date_create($date);
        $date =  date_format($date,"d-m-Y");

        $project = Projects::findOrFail($time_sheet_data->project_id);

        

        return view('timesheet.timesheet_edit')->with('time_sheet_data',$time_sheet_data)->with('project',$project)
        ->with('date',$date)->with('user_id',$user_id);



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


        UserTimeSheetModel::where('id', $id)
        ->update(['time_spent'=>$request->time_sheet,
            'date'=> \Carbon\Carbon::createFromFormat('d-m-Y', $request->entry_date)->toDateString(),'activity'=>$request->activity,'remarks'=>$request->remarks_modal,
            'location'=>$request->location_modal]);

        $location = $request->user_timesheet;

        if($location==1){

            $request->session()->flash('alert-success', 'data has been successfully updated!');
            return redirect()->action('TimeSheetController@index'); 

        }else{

            $request->session()->flash('alert-success', 'data has been successfully updated!');
            return redirect()->action('TimeSheetController@time_log_accounts_display');

        }

        



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

    /**
     * sending the time log sheet to the line manager af an specific user
     */


    public function send_to_linemanager(Request $request){

        // dd($request->all());

        $array = $request->array_time_log;

        $user = Auth::user();

        //fetching the line manager
        $line_manager_id = DB::table('users')
        ->select('line_manager_id')
        ->where('id',$user->id)->first();

        $line_manager = User::where('id',$line_manager_id->line_manager_id)->first();


        foreach ($array as $single_value) {

            DB::table('time_sheet_user')
            ->where('id', $single_value)
            ->where('user_id', $user->id)
            ->update(['sent_to_manager' => $line_manager_id->line_manager_id]);

        }

        \Mail::to($line_manager)->send(new WelcomeAgain($user));

        dd("working");


    }


    public function display_line_manager(){

        if(Entrust::hasRole('Line Manager')){

            return view('timesheet.timesheet_linemanager_display');

        }else{

            return redirect()->back();

        }

    }

    /**
     * selecting the users which is user a particular line manager
     */

    public function get_submitted_users(Request $request){

        $user = Auth::user();

        $search_term = $request->input('term');

        $query_sub_users= "
        SELECT users.id , users.name AS text
        FROM users
        WHERE users.name LIKE '%{$search_term}%' AND users.valid=1 AND users.line_manager_id='$user->id'";

        $sub_users = DB::select($query_sub_users);


        return response()->json($sub_users);

    }

    /**
     * selecting only those time logs that have been sent to the line manager
     * by the sub ordinates view(timesheet_linemanager)
     */
    
    public function time_log_for_submitted_users($id,$start_date,$end_date){

        $start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $start_date)->toDateString();
        $end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $end_date)->toDateString();



        $time_sheet_log = DB::table('time_sheet_user')
        ->join('projects','time_sheet_user.project_id','=','projects.id')
        ->select('projects.project_name','time_sheet_user.id AS id','time_sheet_user.time_spent',
            'time_sheet_user.date','time_sheet_user.activity')
        ->where('time_sheet_user.user_id',$id)->where('time_sheet_user.valid',1)
        ->where('time_sheet_user.sent_to_manager','!=',0)
        ->where('time_sheet_user.sent_to_accounts',0)
        ->whereBetween('time_sheet_user.date',[$start_date,$end_date])->get();

        // dd($time_sheet_log);

        // return response()->json($time_sheet_log);

        $time_collection = collect($time_sheet_log);
    // dd($reservation_collection);
        return Datatables::of($time_collection)
        ->addColumn('action', function ($time_collection) {
            return 

            ' <a href="'. url('/timesheet') . '/' . 
            Crypt::encrypt($time_collection->id) . 
            '/edit' .'"' . 
            'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Details</a>';
        })
        ->editColumn('id', '{{$id}}')
        ->setRowId('id')
        ->make(true);

    }


    /**
     * 
     */
    
    public function submit_to_accounts_manager(Request $request){

        $array = $request->array_time_log;

        foreach ($array as $single_value) {

            DB::table('time_sheet_user')
            ->where('id', $single_value)
            ->update(['sent_to_accounts' => 1]);

        }

        dd("working");


    }



    public function old_time_logs_users(){


        return view('timesheet.previous_time_log_users');

    }

    /**
     * displaying the page to show the table for the data that has been sent to the account manager
     * from the line manager 
     * @return [type] [description]
     */
    public function lineManager_to_accountManager(){

        $line_manager = Auth::user();

        //selecting only those users whose line manager is the current user
        $sub_users = DB::table('users')
        ->select('id','name')
        ->where('line_manager_id',$line_manager->id)->get();

        return view('timesheet.lineManager_to_accountManager')->with('sub_users',$sub_users);

    }

    /**
     * fetching the details of the individual records on specific user from its line manager
     */

    public function old_records_for_line_managers(Request $request, $id, $start_date, $end_date){

        $start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $start_date)->toDateString();
        $end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $end_date)->toDateString();

        if($id == "all"){

            $user = Auth::user();

            $time_sheet_log = DB::table('time_sheet_user')
            ->join('projects','projects.id','=','time_sheet_user.project_id')
            ->join('users','users.id','=','time_sheet_user.user_id')
            ->select('time_sheet_user.id','time_sheet_user.activity','time_sheet_user.time_spent','time_sheet_user.date',
                'projects.project_name','users.name')
            ->where('time_sheet_user.sent_to_manager',$user->id)
            ->where('time_sheet_user.valid',1)
            ->whereBetween('time_sheet_user.date',[$start_date,$end_date])->get();
            

            $time_collection = collect($time_sheet_log);
            // dd($reservation_collection);
            return Datatables::of($time_collection)
            ->addColumn('action', function ($time_collection) {
                return 

                ' <a href="'. url('/timesheet') . '/' . 
                Crypt::encrypt($time_collection->id) . 
                '/edit' .'"' . 
                'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Details</a>';
            })
            ->editColumn('id', '{{$id}}')
            ->setRowId('id')
            ->make(true);


        }else{
            $user = Auth::user();

            $time_sheet_log = DB::table('time_sheet_user')
            ->join('projects','projects.id','=','time_sheet_user.project_id')
            ->join('users','users.id','=','time_sheet_user.user_id')
            ->select('time_sheet_user.id','time_sheet_user.activity','time_sheet_user.time_spent','time_sheet_user.date',
                'projects.project_name','users.name')
            ->where('time_sheet_user.sent_to_manager',$user->id)
            ->where('time_sheet_user.valid',1)
            ->where('time_sheet_user.user_id',$id)
            ->whereBetween('time_sheet_user.date',[$start_date,$end_date])->get();
            

            $time_collection = collect($time_sheet_log);
            // dd($reservation_collection);
            return Datatables::of($time_collection)
            ->addColumn('action', function ($time_collection) {
                return 

                ' <a href="'. url('/timesheet') . '/' . 
                Crypt::encrypt($time_collection->id) . 
                '/edit' .'"' . 
                'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Details</a>';
            })
            ->editColumn('id', '{{$id}}')
            ->setRowId('id')
            ->make(true);

        }

    }


    public function line_manager_refering_subordinates(Request $request){



        $array = $request->array_time_log;

        foreach ($array as $single_value) {

            DB::table('time_sheet_user')
            ->where('id', $single_value)
            ->update(['sent_to_manager' => 0]);

        }

        dd("working");

    }


    public function previous_details_time_log_users(Request $request,$start_date,$end_date){


        $user = Auth::user();

        $start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $start_date)->toDateString();

        $end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $end_date)->toDateString();


        $time_sheet_log = DB::table('time_sheet_user')
        ->join('projects','time_sheet_user.project_id','=','projects.id')
        ->select('projects.project_name','time_sheet_user.id AS id','time_sheet_user.time_spent','time_sheet_user.date','time_sheet_user.activity')
        ->where('time_sheet_user.user_id',$user->id)->where('time_sheet_user.valid',1)
        ->where('time_sheet_user.sent_to_manager','!=',0)
        ->whereBetween('time_sheet_user.date',[$start_date,$end_date])->get();


        // dd($time_sheet_log);

        $time_collection = collect($time_sheet_log);
    // dd($reservation_collection);
        return Datatables::of($time_collection)
        ->addColumn('action', function ($time_collection) {
            return 

            ' <a href="'. url('/timesheet') . '/' . 
            Crypt::encrypt($time_collection->id) . 
            '/edit' .'"' . 
            'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Details</a>';
        })
        ->editColumn('id', '{{$id}}')
        ->setRowId('id')
        ->make(true);
        

    }

    /**
     * time sheet details for the accounts to see and verify
     */
    public function time_log_accounts_display(){


        if(Entrust::hasRole('Accounts')){

            $users = DB::table('users')->select('id','name')->get();

            return view('timesheet.timesheet_accountmanager_display')->with('users',$users);
        }else{
            return redirect()->back();
        }

    }

    /**
     * timesheet details for accounts manager
     * view(timesheet_accountmanager)
     */
    
    public function details_for_accounts_manager(Request $request,$id,$start_date,$end_date){

        $start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $start_date)->toDateString();

        $end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $end_date)->toDateString();


        $time_sheet_log = DB::table('time_sheet_user')
        ->join('projects','time_sheet_user.project_id','=','projects.id')
        ->select('projects.project_name','time_sheet_user.id AS id','time_sheet_user.time_spent','time_sheet_user.date','time_sheet_user.activity')
        ->where('time_sheet_user.user_id',$id)->where('time_sheet_user.valid',1)
        ->where('time_sheet_user.sent_to_accounts',1)
        ->whereBetween('time_sheet_user.date',[$start_date,$end_date])->get();


        // dd($time_sheet_log);

        $time_collection = collect($time_sheet_log);
    // dd($reservation_collection);
        return Datatables::of($time_collection)
        ->addColumn('action', function ($time_collection) {
            return 

            ' <a href="'. url('/timesheet') . '/' . 
            Crypt::encrypt($time_collection->id) . 
            '/edit_by_accounts' .'"' . 
            'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Details</a>';
        })
        ->editColumn('id', '{{$id}}')
        ->setRowId('id')
        ->make(true);



    }

    /**
     * If the accounts manager sees something if wrong with the timesheet, he can edit the existing time sheet
     */
    public function edit_by_accounts(Request $request, $id){



        $time_sheet_id=Crypt::decrypt($id);
        

        $time_sheet_data = UserTimeSheetModel::findOrFail($time_sheet_id);

        $date = $time_sheet_data->date;

        $date = date_create($date);
        $date =  date_format($date,"d-m-Y");

        $project = Projects::findOrFail($time_sheet_data->project_id);

        

        return view('timesheet.edit_by_accounts')->with('time_sheet_data',$time_sheet_data)->with('project',$project)
        ->with('date',$date);


    }

    //testing for pdf
    public function test_pdf(){

        $html = '<h1>HTML Example</h1>
        Some special characters: &lt; € &euro; &#8364; &amp; è &egrave; &copy; &gt; \\slash \\\\double-slash \\\\\\triple-slash
        <h2>List</h2>
        List example:
        <ol>
        <li><b>bold text</b></li>
        <li><i>italic text</i></li>
        <li><u>underlined text</u></li>
        <li><b>b<i>bi<u>biu</u>bi</i>b</b></li>
        <li><a href="http://www.tecnick.com" dir="ltr">link to http://www.tecnick.com</a></li>
        <li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.<br />Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</li>
        <li>SUBLIST
        <ol>
        <li>row one
        <ul>
        <li>sublist</li>
        </ul>
        </li>
        <li>row two</li>
        </ol>
        </li>
        <li><b>T</b>E<i>S</i><u>T</u> <del>line through</del></li>
        <li><font size="+3">font + 3</font></li>
        <li><small>small text</small> normal <small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal</li>
        </ol>
        <dl>
        <dt>Coffee</dt>
        <dd>Black hot drink</dd>
        <dt>Milk</dt>
        <dd>White cold drink</dd>
        </dl>
        <div style="text-align:center">IMAGES<br />
        </div>';

        PDF::SetTitle('Hello World');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('hello_world.pdf');


    }















}
