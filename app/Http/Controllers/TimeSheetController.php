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
    	->select('designation.position_name','users.name','users.id')->get();    

    	/**
    	 * list of the projects in which a user is connected along with their time sheet data
    	 */

    	$user_projects = DB::table('users_projects_connection')
    	->join('projects','projects.id', '=','users_projects_connection.project_id')
    	->select('projects.project_name','users_projects_connection.project_id','users_projects_connection.allocated_time',
    		'users_projects_connection.allocated_days')->where('users_projects_connection.valid',1)->get();

        return view('timesheet.timesheet_create')->with('user_projects',$user_projects)->with('user_info',$user_info[0]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
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
