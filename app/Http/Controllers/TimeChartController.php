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
use Charts;


class TimeChartController extends Controller
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
        $user = Auth::user();

        //getting all the projects that has been assigned to this user
        // $user_projects = "
        // SELECT 
        // users_projects_connection.allocated_days,
        // projects.id,
        // projects.project_name
        // FROM users_projects_connection
        // JOIN projects
        // ON projects.id=users_projects_connection.project_id
        // WHERE users_projects_connection.user_id='$user->id' 
        // AND users_projects_connection.valid=1
        // ";

        // $user_projects = DB::select($user_projects);

        // $time_array = array();

        // $counter = 0;

        // //user time spent on each projecs
        
        // foreach ($user_projects as $projects) {


        //     $user_time = "
        //     SELECT 
        //     time_sheet_user.project_id,
        //     SEC_TO_TIME(SUM(TIME_TO_SEC(time_sheet_user.time_spent))) AS time
        //     FROM time_sheet_user
        //     WHERE time_sheet_user.user_id='$user->id' AND time_sheet_user.project_id='$projects->id'
        //     GROUP BY time_sheet_user.project_id
        //     ";

        //     $user_time = DB::select($user_time);

        //     if(count($user_time)>0){

        //         $time_array[$counter] = $user_time;

        //         $counter++;
        //     }

        // }

        // // dd($time_array);

        // $time_percent = array();

        // $counter = 0;

        // foreach ($time_array as $time) {
        //     // dd($time[0]->project_id);

        //     foreach ($user_projects as $projects) {
        //         //project matches
        //         if($projects->id==$time[0]->project_id){

        //             //conveting the project time into hours
        //             $allocated_days = $projects->allocated_days;

        //             $days = floatval($allocated_days);

        //             $hours = $days * 8 * 60;

        //             list($t_hour,$t_minute,$t_second) = explode(':', $time[0]->time);

        //             //converting the time into seconds
        //             $t_minute = $t_minute + ($t_hour * 60);

        //             //conveting into percent
        //             $percent = ($t_minute/$hours) * 100;

        //             $remaining_percent = 100 - $percent;

        //             $time_percent[$counter] = array(
        //                 'project_name' => $projects->project_name,
        //                 'remaining_hour' => $remaining_percent,
        //                 'completed' => $percent 
        //                 );

        //             $counter++;

        //         }
        //     }

        // }
        
        $chart =  Charts::multi('line', 'highcharts')
        ->colors(['#ff0000', '#00ff00', '#0000ff'])
        ->labels(['One', 'Two', 'Three'])
        ->dataset('Test 1', [1,2,3])
        ->dataset('Test 2', [0,6,0])
        ->dataset('Test 3', [3,4,1]);
        return view('chartjs/chart', ['chart' => $chart]);

        

        // return view('chartjs/chart', compact('final_array'));

        
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
        //
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
