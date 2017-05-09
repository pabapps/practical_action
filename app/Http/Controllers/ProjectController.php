<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use Datatables;
use Crypt;
use Auth;
use Response;
use DB;

class ProjectController extends Controller
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
        return view('projects.projects_list');
    }


     public function get_all_projects(){

        $query_get_all_projects="
        SELECT 
        id,
        project_name,
        swif_code
        FROM projects
        WHERE projects.completion_status=1
        ";
        $projects=DB::select($query_get_all_projects);
        $projects_collection= collect($projects);
    // dd($reservation_collection);
        return Datatables::of($projects_collection)
        ->addColumn('action', function ($projects_collection) {
            return 

            ' <a href="'. url('/programs') . '/' . 
            Crypt::encrypt($projects_collection->id) . 
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
        return view("projects.project_create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $program_name = $request->program_name;
        $swif_code = $request->swif_code;

        $program = new Projects;
        $program->project_name = $program_name;
        $program->swif_code = $swif_code;
        $program->save();

        // dd("working");

        return redirect()->action('ProjectController@index');
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
