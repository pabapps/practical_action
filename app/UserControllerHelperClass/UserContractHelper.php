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

			static::create_contract($request,$id);

		}else{

			//the object is not null, in that case we need to check is the object is valid or not. If the object is valid, we are going to just update the existing record with teh changed data. However, if it's invalid, we have to create a new record for this particular user

			if($last_data_object->valid == 1){
				//update the existing record

				UserContract::where('user_id', $id)
				->update(['start_date' =>  \Carbon\Carbon::createFromFormat('d-m-Y', $request->contract_start_date)->toDateString(),
					'end_date'=> \Carbon\Carbon::createFromFormat('d-m-Y', $request->contract_end_date)->toDateString()]);



			}else{
				//well, as the object is invalid need to create a new object
				static::create_contract($request,$id);
			}

		}


	}


	private static function create_contract(Request $request,$id){
		$new_contract = new UserContract;

		$new_contract->user_id = $id;

		$new_contract->start_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->contract_start_date)->toDateString();

		$new_contract->end_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->contract_end_date)->toDateString();

		$new_contract->save();
	}


	//checking the contract of each and every users from the contractlist to see how long their contract will last
	public static function contract_check(){

		$contract_list = UserContract::where('valid',1)->get();

		

	} 

}