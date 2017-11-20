<?php

namespace App\UserControllerHelperClass;
use Illuminate\Http\Request;
use Crypt;
use Auth;
use App\User;
use App\UserContract;


class UserContractHelper{


	public static function userContract(Request $request,$id){
		dd($id);
	}

}