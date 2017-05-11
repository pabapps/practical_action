<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Designation;
use App\Department;
use Datatables;
use Crypt;
use Auth;
use Response;
use DB;

class DepartmentController extends Controller
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
    	return view('departments.department_list');
    }

    public function get_all_departments(){

    	$query_departments =  DB::table('department')->select(['id', 'department'])->where('valid',1)->get();

    	$department_collection = collect($query_departments);
    // dd($reservation_collection);
    	return Datatables::of($department_collection)
    	->addColumn('action', function ($department_collection) {
    		return 

    		' <a href="'. url('/departments') . '/' . 
    		Crypt::encrypt($department_collection->id) . 
    		'/edit' .'"' . 
    		'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Edit</a>';
    	})
    	->editColumn('id', '{{$id}}')
    	->setRowId('id')
    	->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('departments.department_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$department = new Department;

    	$department->department = $request->department_name;
    	$department->valid = 1;

    	$department->save();

    	return redirect()->action('DepartmentController@index');
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
