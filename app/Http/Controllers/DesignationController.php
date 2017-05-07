<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Designation;
use Datatables;
use Crypt;
use Auth;
use Response;
use DB;

class DesignationController extends Controller
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
        return view('designations.designation_list');
    }


    public function get_all_designations(){

        $query_designations="
        SELECT 
        id,
        position_name,
        department_name
        FROM designation
        WHERE designation.valid=1
        ";
        $designation=DB::select($query_designations);
        $designation_collection= collect($designation);
    // dd($reservation_collection);
        return Datatables::of($designation_collection)
        ->addColumn('action', function ($designation_collection) {
            return 

            ' <a href="'. url('/programs') . '/' . 
            Crypt::encrypt($designation_collection->id) . 
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
        return view("designations.designation_create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $designation = new Designation;
        $designation->position_name = $request->designation_name;
        $designation->department_name = $request->department_name;
        $designation->valid = 1; //valid
        $designation->save();

        return redirect()->action('DesignationController@index');
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
