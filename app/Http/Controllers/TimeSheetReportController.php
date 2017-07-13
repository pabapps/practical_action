<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use PDF;

class TimeSheetReportController extends Controller
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

      $users = DB::table('users')->select('id','name')->get();

      return view('timesheet.reports.timeReport')->with('users',$users);
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
 * this will get the projects that a user has been assigned 
 */

public function get_user_projects(Request $request){

  $user_id = $request->id;

  $search_term = $request->input('term');

  $query_user_porjects = "
  SELECT 
  users_projects_connection.project_id AS id,
  projects.project_name AS text
  FROM users_projects_connection
  JOIN projects
  ON projects.id=users_projects_connection.project_id AND projects.valid=1 AND projects.completion_status=1
  WHERE users_projects_connection.user_id='$user_id' AND users_projects_connection.valid=1 
  AND projects.project_name LIKE '%{$search_term}%'
  ";

  $projects = DB::select($query_user_porjects);

  return response()->json($projects);


}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

      $user_id = $request->user_id;

      $start_date = $request->start_date;

      $end_date = $request->end_date;

      $start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $start_date)->toDateString();

      $end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $end_date)->toDateString();

      $user_projects = $request->user_projects;



      $query_time_report = DB::table('time_sheet_user')
      ->join('projects','time_sheet_user.project_id','=','projects.id')
      ->join('users','time_sheet_user.user_id','=','users.id')
      ->select('projects.project_name','projects.project_code',
        'time_sheet_user.time_spent','time_sheet_user.project_id')->where('time_sheet_user.user_id',$user_id)
      ->where('time_sheet_user.valid',1)->where('time_sheet_user.sent_to_accounts',1)
      ->where('projects.valid',1)
      ->whereBetween('time_sheet_user.date',[$start_date,$end_date])->get();

        // dd($query_time_report);

      $time_array = array();

      foreach ($query_time_report as $time_report) {

        if(array_key_exists($time_report->project_id, $time_array)){

          $time = $time_array[$time_report->project_id];

          $time2 = $time_report->time_spent;

          $time_array[$time_report->project_id] = $this->sum_the_time($time,$time2);

        }else{
          $time_array[$time_report->project_id] = $time_report->time_spent;
        }


      }

        // dd($time_array);

        /**
         * fetching the total time that has been allocated for each projects for an user
         */
        
        $query_yearly_time_for_projects = DB::table('users_projects_connection')
        ->select('project_id','allocated_days')
        ->where('users_projects_connection.user_id',$user_id)
        ->where('users_projects_connection.valid',1)->get();

        $month_time_array = array();

        foreach ($query_yearly_time_for_projects as $yearly_time) {

          $days_from_years = $yearly_time->allocated_days;

            //converting it into hours
          $hours = floatval($days_from_years) * 8;

            //converting the yearly hours into monthly hours dividing by 18.8

          $monthly_hours = $hours/18.8;

          $month_time_array[$yearly_time->project_id] = ceil($monthly_hours);

        }

        $user = User::where('id',$user_id)->first();

        $project_names = array();

        $project_id = array();

        $count = 0;

        foreach ($query_time_report as $time_report) {
          if(array_key_exists($time_report->project_id, $project_names)){

          }else{
            $project_names[$time_report->project_id] = $time_report->project_name;

            $project_id[$count] = $time_report->project_id;
            $count++;
          }
        }


        $project_name_line = "";

        for($i = 0; $i<count($project_id); $i++){
            // dd($project_id[$i]);
            // 
            // dd($time_array[$project_id[$i]]);

          $project_name_line =$project_name_line.'<tr><td>'.$project_names[$project_id[$i]].'</td><td>'.$month_time_array[$project_id[$i]].'</td><td>'.$time_array[$project_id[$i]].'</td></tr>';

        }


        $html = '<h1>Time Sheet Report</h1>
        
        <h3>Name: '.$user->name.'</h3>

        <h4>Email: '.$user->email.'</h4>

        <h4>Phone Number: '.$user->phone_num.'</h4>

        <br>

        <table border="1">
        <tr>
        <th><b>Project Name</b> </th>
        <th><b>Monthly Hours</b></th> 
        <th><b>Completed Hours</b></th>
        </tr>'.$project_name_line.'

        
        </table>

        ';

        PDF::SetTitle('Time Sheet Reprot');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('time_sheet_report.pdf');
      }



      /**
       * report for specific project
       */


      public function get_report_for_specific_project(Request $request){

        $user_id = $request->user_id;

        $start_date = $request->start_date;

        $end_date = $request->end_date;

        $start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $start_date)->toDateString();

        $end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $end_date)->toDateString();

        $user_project = $request->user_project;


        //calculating the number of days between two date range

        $day1 = strtotime($start_date);

        $day2 = strtotime($end_date);

        $datediff =  $day2 - $day1;

        $val = floor($datediff / (60 * 60 * 24)) + 1;

        
        $query_time_report = DB::table('time_sheet_user')
        ->join('projects','time_sheet_user.project_id','=','projects.id')
        ->join('users','time_sheet_user.user_id','=','users.id')
        ->select('projects.project_name','projects.project_code',
          'time_sheet_user.time_spent','time_sheet_user.project_id','time_sheet_user.date','time_sheet_user.location',
          'time_sheet_user.activity')->where('time_sheet_user.user_id',$user_id)
        ->where('time_sheet_user.valid',1)->where('time_sheet_user.sent_to_accounts',1)
        ->where('projects.valid',1)
        ->whereBetween('time_sheet_user.date',[$start_date,$end_date])
        ->orderBy('time_sheet_user.date')->get();

        // dd($query_time_report);
        
        $time_array = array();

        $details_of_time = array();

        $detials_of_activity = array();

        //need to add up the working hours if the date is same

        for($i=0; $i<count($query_time_report); $i++){

          $time = $query_time_report[$i]->time_spent;

          $date = $query_time_report[$i]->date;


          $start_ul = "<ul>";

          $end_ul = "</ul>";

          $list_time = "<li>".$time."</li>" ;
          $list_array = "<li>".$query_time_report[$i]->activity."</li>" ;
          
          //checking for duplicate dates, if same dates are same simply adding the hours that is associated with
          //the same dates. Otherwise, storing the date in another index of an array          

          for($j= $i+1; $j<count($query_time_report); $j++){

            if($query_time_report[$j]->date == $query_time_report[$i]->date){

              $time2 = $query_time_report[$j]->time_spent;

              $time = $this->sum_the_time($time,$time2);

              $list_time = $list_time. "<li>".$time2."</li>";

              $list_array = $list_array . "<li>".$query_time_report[$j]->activity."</li>" ;

              
            }else{

              break;
            }
          }
          
          if(!array_key_exists($query_time_report[$i]->date, $time_array)){
            $time_array[$query_time_report[$i]->date] = $time;

            $detials_of_dates[$query_time_report[$i]->date] = $start_ul.$list_array.$end_ul;

            $details_of_time[$query_time_report[$i]->date] = $start_ul.$list_time.$end_ul;

          }

        }

        // dd($details_of_time);

        $modified_details_of_date = array();

        $modified_details_of_time = array();

        // dd(array_keys($time_array));

        //keys in this array are just the dates, each unique dates have time tagged along with it
        $keys_for_array = array_keys($time_array);

        //this array is used for seperating the days from the long date (YYYY-mm-dd) taking only the (dd)
        //and stroing the time in that day index
        
        $days_time = array();

        for($i=0; $i<count($keys_for_array); $i++){

          list($year,$month,$day) = explode('-', $keys_for_array[$i]);

          if($day<10){
            list($not_required,$x) = explode('0',$day);
            $days_time[$x] = $time_array[$keys_for_array[$i]];

            $modified_details_of_date[$x] = $detials_of_dates[$keys_for_array[$i]];

            $modified_details_of_time[$x] = $details_of_time[$keys_for_array[$i]];

          }else{
            $days_time[$day] = $time_array[$keys_for_array[$i]];

            $modified_details_of_date[$day] = $detials_of_dates[$keys_for_array[$i]];

            $modified_details_of_time[$day] = $details_of_time[$keys_for_array[$i]];
          }
        }

        $user = User::where('id',$user_id)->first();

        $total_time = "00:00:00";
        

        $pdf_line = "";

        for($i=1; $i<=$val; $i++){

          if(array_key_exists($i, $days_time)){

            $total_time = $this->sum_the_time($total_time,$days_time[$i]);

            $pdf_line =$pdf_line.'<tr><td align="center" >'.$i.'</td><td align="center" >'.$days_time[$i].'</td><td align="center">'.$modified_details_of_time[$i].'</td><td align="center" >'.$modified_details_of_date[$i].'</td></tr>';
          }else{
            $pdf_line =$pdf_line.'<tr><td align="center" >'.$i.'</td><td align="center" >'." ".'</td><td>'." ".'</td><td>'." ".'</td></tr>';
          }

        }


        $html = '<h1>Time Sheet Report</h1>
        
        <h3>Name: '.$user->name.'</h3>

        <h4>Email: '.$user->email.'</h4>

        <h4>Phone Number: '.$user->phone_num.'</h4>

        <br>

        <table border="1">
        <tr>
        <th align="center" style="width:10%"><b>Days</b> </th>
        <th align="center" style="width:20%"><b>Hours</b></th> 
        <th align="center" style="width:30%"><b>time</b></th> 
        <th align="center" style="width:40%" ><b>Details</b></th>
        </tr>'.$pdf_line.'

        <br>
        <h4>Total time :'.$total_time.'</h4>

        </table>

        ';

        PDF::SetTitle('Time Sheet Report');
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('time_sheet_report.pdf');
        

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
