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
use App\UserContractNotification;
use Log;
use App\Jobs\ContractNotificationJob;


class UserContractHelper{


	public static function create_userContract(Request $request,$id){
		
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
					'end_date'=> \Carbon\Carbon::createFromFormat('d-m-Y', $request->contract_end_date)->toDateString(),'early_notify_month'=>$request->early_notification]);



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

		$new_contract->early_notify_month = $request->early_notification;

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
						"user_department"=>'-',
						"start_date"=>'-',
						"end_date"=>'-'
					);

				}else{

					$user_designation = Designation::where('id',$user_designation_model->designation_id)->first();

					$user_department = Department::where('id',$user_designation->department_id)->first();

					

					$active_user_array[$count] = array(
						"user_id"=>$user_list->id,
						"user_name"=>$user_list->name,
						"user_contract_time"=>'-',
						"user_designation"=>$user_designation->position_name,
						"user_department"=>$user_department->department,
						"start_date"=>'-',
						"end_date"=>'-'
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
						"user_contract_time"=>$test_date,
						"user_designation"=>'-',
						"user_department"=>'-',
						"start_date"=>$user_contract->start_date,
						"end_date"=>$user_contract->end_date
					);

				}else{

					$user_designation = Designation::where('id',$user_designation_model->designation_id)->first();

					$active_user_array[$count] = array(
						"user_id"=>$user_list->id,
						"user_name"=>$user_list->name,
						"user_contract_time"=>$test_date,
						"user_designation"=>$user_designation->position_name,
						"user_department"=>$user_department->department,
						"start_date"=>$user_contract->start_date,
						"end_date"=>$user_contract->end_date
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

			$early_notify_month = $contract->early_notify_month;

			// dd($early_notify_month);

			$o_month = substr($contract->end_date,5,2); 
			$o_day = substr($contract->end_date,8,2); 
			$o_year = substr($contract->end_date,0,4); 

			$test_date = \Carbon\Carbon::createFromDate($o_year, $o_month, $o_day )->diff(Carbon::now())->format('%y, %m, %d');

			$array_date = explode(",",$test_date);

			$year = $array_date[0];
			$months = $array_date[1];
			$days = $array_date[2];

			//if, month is less than 2, mail should be sent form the server
			if($year==0 && $months<=$early_notify_month && $early_notify_month!=0){
				
				//mail should be sent to the hr personal
				$user = User::where('id',1)->first();

				$mail_sent = static::check_if_mail_sent($user);

				dd($mail_sent);

				Log::info("Request Cycle with Queues Begins");        

				$jobs = (new ContractNotificationJob($user,$test_date))->onConnection('database')->delay(10);

				dispatch($jobs);

				Log::info("Request Cycle with Queues Ends");

			}
			
		}
		

		

	} 

	/**
	 * checking if the mail is sent within the last 7 days for a an user
	 * @return [boolean] [ if yes return false otherwise true ]
	 */
	private static function check_if_mail_sent(User $user){

		$previous_mail_sent_info = UserContractNotification::where("user_id",$user->id)->get();

		$last_mail_sent_ingo = collect($previous_mail_sent_info)->last();

		//where there is no data about ther user

		if(is_null($last_mail_sent_ingo)){

			static::add_user_to_notofication_log($user->id);
			return false;
		}else{
			
		}		

	}


	private static function add_user_to_notofication_log($user_id){

		$today_date = date("Y-m-d");

		// dd($today_date);

		$new_log = new UserContractNotification;

		$new_log->user_id = $user_id;
		$new_log->mail_sent_date = $today_date;
		$new_log->valid = 1;

		$new_log->save();


	}

	/*
	fetching the contract of an specific user from the given id
	*/

	public static function get_user_contract($user_id){

		$user_contract = UserContract::where('user_id',$user_id)->where('valid',1)->first();

		$contract_array = array();

		if(is_null($user_contract)){

			$contract_array = array(
				"start_date" => '',
				"end_date" => '',
			);
			
		}else{

			$start_date = date("d-m-Y", strtotime($user_contract->start_date));

			$end_date = date("d-m-Y", strtotime($user_contract->end_date));

			$contract_array = array(
				"start_date" => $start_date,
				"end_date" => $end_date,
				"early_notify_email"=>$user_contract->early_notify_month
			);

			

		}

		return $contract_array;

	}


















}