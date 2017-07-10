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
use App\Designation;
use App\Role;

class UserProfileController extends Controller
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
     * displaying a user profile that's specific to an id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user_id=Crypt::decrypt($id);

        $user = DB::table('users')->where('id', $user_id)->first();



        $date = date_create($user->joining_date);

        $date = date_format($date, "d-m-Y");

        $matrix_manager = User::where('id', $user->matrix_manager_id)->first();

        $line_manager = User::where('id', $user->line_manager_id)->first();


        $user_designation_connection = UserDesignationModel::where('user_id',$user_id)
        ->where('valid',1)->first();

        

        if(is_object($user_designation_connection)){

            $user_designation = Designation::where('id',$user_designation_connection->designation_id)->first();

            return view('userProfile.user_profile')->with('user',$user)->with('date',$date)->with('matrix_manager',$matrix_manager)
            ->with('line_manager',$line_manager)->with('user_designation',$user_designation);
        }else{

            return view('userProfile.user_profile')->with('user',$user)->with('date',$date)->with('matrix_manager',$matrix_manager)
            ->with('line_manager',$line_manager);

        }



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


        if(!empty($request->password) && !empty($request->password_confirm)){

            if($request->password != $request->password_confirm){

                $request->session()->flash('alert-danger', 'password does not match!');

                return redirect()->back();
            }else{

                $user = User::where('id',$id)->update(['password'=>bcrypt($request->password)]);

            }
        }


        //updating name
        if(!empty($request->name)){

            $user = User::where('id',$id)->update(['name'=>$request->name]);

        }

        //updating email
        if(!empty($request->email)){

            $user = User::where('id',$id)->update(['email'=>$request->email]);

        }

        //updating phone number

        if(!empty($request->phone_num)){

            $user = User::where('id',$id)->update(['phone_num'=>$request->phone_num]);

        }

        //updating gender
        if(!empty($request->gender)){

            $user = User::where('id',$id)->update(['gender'=>$request->gender]);

        }

        // //updating user location
        
        // if(!empty($request->user_location)){

        //     $user = User::where('id',$id)->update(['user_location'=>$request->user_location]);

        // }


        $request->session()->flash('alert-success', 'data has been updated');


        return redirect()->back();


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
