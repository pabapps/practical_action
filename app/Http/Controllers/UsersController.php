<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Datatables;
use Crypt;
use Auth;
use App\User;

class UsersController extends Controller
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
        return view('users.users_list');
    }

    public function get_all_users(){

        // dd("working on it");

        $query_get_all_users="
        SELECT 
        id,
        users.name,
        users.email,
        users.phone_num,
        users.gender
        FROM users
        WHERE users.valid=1
        ";
        $users=DB::select($query_get_all_users);
        $users_collection= collect($users);
        // return Datatables::of(User::all())->make(true);
    // dd($reservation_collection);
        return Datatables::of($users_collection)
        ->addColumn('action', function ($users_collection) {
            return ' <a href="'. url('/users') . '/' . 
            Crypt::encrypt($users_collection->id) . 
            '/edit' .'"' . 
            'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Edit</a>'.
            ' <a href="'. url('/users') . '/' . 
            Crypt::encrypt($users_collection->id) . 
            '/edit' .'"' . 
            'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i>Delete</a>';
        })
        ->editColumn('id', '{{$id}}')
        ->setRowId('id')
        ->make(true);

    }


    public function get_line_managers(Request $request){ 

        $id = $request->id;

        $search_term = $request->input('term');

        $query_users= "
        SELECT users.id , users.name AS text
        FROM users WHERE users.id!= '$id' AND users.name LIKE '%{$search_term}%' AND users.valid=1";

        $users = DB::select($query_users);

        // dd($users);

        return response()->json($users);

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
        $user_id=Crypt::decrypt($id);

        $user = User::where('valid',  1)->where('id',$user_id)->first();

        $date = date_create($user->joining_date);

        $date = date_format($date, "d-m-Y");

        return view('users.user_edit')->with('user',$user)->with('date',$date);

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
        // dd($request->all());

        if(!empty($request->password) && !empty($request->password_confirm)){

            if($request->password != $request->password_confirm){

                $request->session()->flash('alert-danger', 'password does not match!');

                return redirect()->back();
            }

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
}
