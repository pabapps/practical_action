<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Datatables;
use Crypt;
use Auth;
use Response;
use DB;

class RoleController extends Controller
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

        return view('roles.role_list');

    }


    public function get_all_roles(){
       $query_all_roles="
       SELECT 
       id,
       name,
       display_name,
       description
       FROM roles
       ";
       $roles = DB::select($query_all_roles);

       // dd($roles);

       $rolls_collection = collect($roles);
    // dd($reservation_collection);
       return Datatables::of($rolls_collection)
       ->addColumn('action', function ($rolls_collection) {
        return 

        ' <a href="'. url('/roles') . '/' . 
        Crypt::encrypt($rolls_collection->id) . 
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
        return view('roles.role_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role;

        $role->name = $request->role_name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;

        $role->save();

        return redirect()->action('RoleController@index');

        // dd("done");
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
