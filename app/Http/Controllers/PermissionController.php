<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use App\User;
use Datatables;
use Crypt;
use Auth;
use Response;
use DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permissions.permission_list');
    }


    public function get_all_permissions(){
        $query_get_all_permission="
        SELECT 
        id,
        name,
        display_name,
        description
        FROM permissions
        ";
        $permissions=DB::select($query_get_all_permission);
        $permissions_collection= collect($permissions);
    // dd($reservation_collection);
        return Datatables::of($permissions_collection)
        ->addColumn('action', function ($permissions_collection) {
            return 

            ' <a href="'. url('/permissions') . '/' . 
            Crypt::encrypt($permissions_collection->id) . 
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
        return view('permissions.permission_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = new Permission;

        $permission->name = $request->permission_name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;

        $permission->save();

        return redirect()->action('PermissionController@index');

        // dd('done');

    }


    public function roles_list(){

        return view('permissions.permission_role_list');

    }

    public function user_role_permissions_details(){

        $roles = DB::table('roles')->select('id','name','description')->get();

        $role_collection= collect($roles);
    // dd($reservation_collection);
        return Datatables::of($role_collection)
        ->addColumn('action', function ($role_collection) {
            return 

            ' <a href="'. url('/permissions') . '/' . 
            Crypt::encrypt($role_collection->id) . 
            '' .'"' . 
            'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Edit</a>';
        })
        ->editColumn('id', '{{$id}}')
        ->setRowId('id')
        ->make(true);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $role_id=Crypt::decrypt($id);

        $role = Role::where('id',$role_id)->first();

        return view('permissions.set_user_permission')->with('role',$role);


    }

    public function get_permissions_for_roles(Request $request){

        $search_term = $request->input('term');

        $query_permissions= "
        SELECT id, name AS text
        FROM permissions
        WHERE name LIKE '%{$search_term}%'";

        $permissions = DB::select($query_permissions);

        // dd($permissions);

        return response()->json($permissions);

    }

    public function permission_details(Request $request){

        $permission_id = $request->name;

        $permission_details = DB::table('permissions')->select('description')
        ->where('id',$permission_id)->first();

        // dd($project_code);
        
        return response()->json($permission_details);


    }


    public function submit_role_permission(Request $request){

        $user = Auth::user();

        if($user->hasRole(['Admin'])){

            $role_id = $request->user_id;

            $permissions = $request->data;

        //fetching the user role

            $role = Role::where('id',$role_id)->first();

        //deleting previous premission for this role
            DB::table('permission_role')->where('role_id', '=',$role_id)->delete();

            foreach ($permissions as $array) {

            // dd($array[3]);

                $permission = Permission::where('id',$array[3])->first();

                $role->attachPermission($permission);

            }

            dd("done");
        }else{

            $value = -1;

            return json_encode($value);


        }



    }

    /**
     * ajax request view(permissions.set_user_permission)
     */

    public function get_old_permissions_roles(Request $request){

        $role_id = $request->id;

        $role = Role::where('id',$role_id)->first();

        $permission_id = DB::table('permission_role')->select('permission_id')
        ->where('role_id',$role_id)->get();

        $permission_array = array();
        $counter = 0;

        foreach ($permission_id as $permission) {

            $database_permission = Permission::where('id',$permission->permission_id)->first();

            $permission_array[$counter] = array(
                'id'                    => $database_permission->id,
                'permission_name'       => $database_permission->name,
                'description'           => $database_permission->description
                );

            $counter++;

        }

        // dd($permission_array);

        return response()->json($permission_array);

    }






    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission_id = Crypt::decrypt($id);

        $permission = Permission::where('id',$permission_id)->first();

        return view('permissions.permission_edit')->with('permission',$permission);

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


        Permission::where('id', $id)
        ->update(['name' => $request->permission_name,
            'display_name' => $request->display_name,
            'description' => $request->description]);

        $request->session()->flash('alert-success', 'data has been successfully updated!');
        return redirect()->action('PermissionController@index');   

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
