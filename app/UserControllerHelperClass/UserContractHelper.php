<?php

namespace App\UserControllerHelperClass;
use Illuminate\Http\Request;
use Crypt;
use Auth;
use App\User;
use App\UserContract;


class UserContractHelper{


	public static function userContract(Request $request,$id){
		
		$old_contract_data = UserContract::where('user_id',$id)->get();

		$last_data_object = collect($old_contract_data)->last();

		if(is_null($last_data_object)){
			//since the object is null, means there is no data related to this particular
			//user contract. Therefore, has to create a new record to make the contract fro this user

			$new_contract = new UserContract;

			$new_contract->user_id = $id;

			$new_contract->start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->contract_start_date)->toDateString();

			$new_contract->end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->contract_end_date)->toDateString();

			$new_contract->save();

			dd("working on it");


		}


	}

}