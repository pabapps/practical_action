<?php

namespace App\UserControllerHelperClass;
use Illuminate\Http\Request;
use Crypt;
use Auth;
use App\User;
use App\UserContract;
use Carbon\Carbon;
use App\Designation;
use App\UserDesignationModel;
use App\Department;
use Log;
use App\Jobs\ContractNotificationJob;


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

		$today_date = date("Y-m-d");

		foreach ($contract_list as $list) {
			
			if(strtotime($today_date) > strtotime($list->end_date)){

				UserContract::where('user_id', $list->user_id)
				->update(['valid' =>  0]);

			}

		}

	} 

	/**
	 *need to create a list of users along with the contract 
	 */


	public static function active_user_list(){


		$active_user_list = User::where('valid',1)->get();


		$active_user_array = array();

		$count = 1;

		foreach ($active_user_list as $user_list) {
			
			$user_contract = UserContract::where('user_id',$user_list->id)->where('valid',1)->first();


			if(is_null($user_contract)){

				$user_designation_model  = UserDesignationModel::where('user_id',$user_list->id)->where('valid',1)->first();

				if(is_null($user_designation_model)){
					
					$active_user_array[$count] = array(
						"user_id"=>$user_list->id,
						"user_name"=>$user_list->name,
						"user_contract_time"=>'-',
						"user_designation"=>'-',
						"user_department"=>'-'
					);

				}else{

					$user_designation = Designation::where('id',$user_designation_model->designation_id)->first();

					$user_department = Department::where('id',$user_designation->department_id)->first();

					

					$active_user_array[$count] = array(
						"user_id"=>$user_list->id,
						"user_name"=>$user_list->name,
						"user_contract_time"=>'-',
						"user_designation"=>$user_designation->position_name,
						"user_department"=>$user_department->department
					);

				}

				

				$count++;

			}else{
				//need to calculate time time difference 
				$today_date = date("Y-m-d");

				$date1 = new \DateTime($today_date);
				$date2 = new \DateTime($user_contract->end_date);

				// dd($user_contract->end_date);

				$o_month = substr($user_contract->end_date,5,2); 
				$o_day = substr($user_contract->end_date,8,2); 
				$o_year = substr($user_contract->end_date,0,4); 

				$test_date = \Carbon\Carbon::createFromDate($o_year, $o_month, $o_day )->diff(Carbon::now())->format('%y years, %m months and %d days');// => "23 years, 6 months and 26 days"

				$user_designation_model  = UserDesignationModel::where('user_id',$user_list->id)->where('valid',1)->first();

				$user_designation = Designation::where('id',$user_designation_model->designation_id)->first();

				$user_department = Department::where('id',$user_designation->department_id)->first();


				if(is_null($user_designation_model)){

					$active_user_array[$count] = array(
						"user_id"=>$user_list->id,
						"user_name"=>$user_list->name,
						"user_contract_time"=>'-',
						"user_designation"=>'-',
						"user_department"=>'-'
					);

				}else{

					$user_designation = Designation::where('id',$user_designation_model->designation_id)->first();

					$active_user_array[$count] = array(
						"user_id"=>$user_list->id,
						"user_name"=>$user_list->name,
						"user_contract_time"=>$test_date,
						"user_designation"=>$user_designation->position_name,
						"user_department"=>$user_department->department
					);

					$count++;

				}

				

			}



		}

		// dd($active_user_array);

		return json_encode($active_user_array);



	}


	public static function sendmail_to_active_users(){
		// dd("working on it");
		$user_contract = UserContract::where('valid',1)->get();

		foreach ($user_contract as $contract) {

			$date2 = new \DateTime($contract->end_date);

			$o_month = substr($contract->end_date,5,2); 
			$o_day = substr($contract->end_date,8,2); 
			$o_year = substr($contract->end_date,0,4); 

			$test_date = \Carbon\Carbon::createFromDate($o_year, $o_month, $o_day )->diff(Carbon::now())->format('%y, %m, %d');

			$array_date = explode(",",$test_date);

			$months = $array_date[1];
			$days = $array_date[2];

			//if, month is less than 2, mail should be sent form the server
			if($months<2){
				
				//mail should be sent to the hr personal
				$user = User::where('id',1)->first();

				// dd($user);

				Log::info("Request Cycle with Queues Begins");        

				$jobs = (new ContractNotificationJob($user,$test_date))->onConnection('database')->delay(10);

				dispatch($jobs);

				Log::info("Request Cycle with Queues Ends");

			}
			
		}
		

		

	} 





















}