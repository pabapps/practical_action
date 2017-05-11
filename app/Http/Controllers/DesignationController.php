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

        $query_designations =  DB::table('designation')->select(['id', 'position_name'])->where('valid',1)->get();

        $designation_collection= collect($query_designations);
    // dd($reservation_collection);
        return Datatables::of($designation_collection)
        ->addColumn('action', function ($designation_collection) {
            return 

            ' <a href="'. url('/designation') . '/' . 
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
        
        $designation_id=Crypt::decrypt($id);

        $designation = Designation::where('id',$designation_id)->first();

        return view('designations.designation_edit')->with('designation',$designation);


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
        Designation::where('id', $id)
          ->update(['position_name' => $request->designation_name]);

        $request->session()->flash('alert-success', 'data has been successfully updated!');
        return redirect()->action('DesignationController@index'); 
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
