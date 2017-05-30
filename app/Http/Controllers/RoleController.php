<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
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
        '/role_edit' .'"' . 
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
     * [user_roles description]
     * displays the user_role page
     * @return [type] [description]
     */
    public function user_roles(){

        return view('roles.user_role_list');

    }


    public function get_all_users_role(){
        // dd("working on it");

        $user_roles = DB::table('users')
        ->leftJoin('role_user','role_user.user_id','=','users.id')
        ->leftJoin('roles','roles.id','=','role_user.role_id')
        ->select('users.id','users.name','roles.name AS roles_name')->get();

        $user_role_collection = collect($user_roles);
    // dd($reservation_collection);
        return Datatables::of($user_role_collection)
        ->addColumn('action', function ($user_role_collection) {
            return 

            ' <a href="'. url('/roles') . '/' . 
            Crypt::encrypt($user_role_collection->id) . 
            '/edit' .'"' . 
            'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Edit</a>';
        })
        ->editColumn('id', '{{$id}}')
        ->setRowId('id')
        ->make(true);

    }

    public function submit_user_role(Request $request){

        $user_id = $request->user_id;

        $role_id = $request->role_id;

        //checking if the user already has a role
        $already_exist = false;


        $role_from_database = "
        SELECT role_id
        FROM role_user WHERE user_id='$user_id'";

        $role_from_database = DB::select($role_from_database);

        if(sizeof($role_from_database)>=1){

            //user role exist
            $already_exist = true; 

            //update the existing role with the new role
            
            DB::table('role_user')->where('user_id', '=',$user_id)->delete();

            $role = Role::where('id',$role_id)->first();

            $user = User::findOrFail($user_id);

            $user->attachRole($role); 

            $request->session()->flash('alert-success', 'This person role has been assigned as '.$role->name.'!');
            return redirect()->back(); 


        }else{

            //use has no role 
            //assign a role to this user
            $role = Role::where('id',$role_id)->first();

            $user = User::findOrFail($user_id);

            $user->attachRole($role); 

            $request->session()->flash('alert-success', 'This person role has been assigned as '.$role->name.'!');
            return redirect()->back(); 

        }

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

        $user = User::findOrFail($user_id);

        $role = DB::table('roles')
        ->join('role_user','roles.id','=','role_id')
        ->select('roles.name','roles.id')
        ->where('role_user.user_id',$user_id)->get();

        return view('roles.user_role')->with('user',$user)->with('role',$role);
        
    }

    public function ajax_get_all_roles(Request $request){

       $search_term = $request->input('term');

       $role_query = "
       SELECT roles.id, roles.name AS text
       FROM roles 
       WHERE roles.name LIKE '%{$search_term}%'";

       $roles = DB::select($role_query);

        // dd($users);

       return response()->json($roles);

   }

   public function role_edit($id){

    $role_id = Crypt::decrypt($id);

    $role = Role::where('id',$role_id)->first();

    // dd($role);

    return view('roles.role_edit')->with('role',$role);


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
        Role::where('id', $id)
        ->update(['name' => $request->role_name,
            'display_name' => $request->display_name,
            'description' => $request->description]);

        $request->session()->flash('alert-success', 'data has been successfully updated!');
        return redirect()->action('RoleController@index');   
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
     * [roles_for_specific_user description]
     * @param  Request $return [user_id]
     * @return [$roles]          [roles details]
     */
    public function roles_for_specific_user(Request $request){

        $user_id = $request->user_id;

        $role_ids = DB::table('role_user')->select('role_id')->where('user_id',$user_id)->get();

        $counter = 0;
        $role_array = array();


        foreach ($role_ids as $role_id) {

            
            $role = Role::where('id',$role_id->role_id)->first();

            $role_array[$counter] = array(
                'name'=>$role->name,
                'description'=>$role->description
                );
            $counter++;

        }

        // dd($role_array);

        return json_encode($role_array);



    }




















}
