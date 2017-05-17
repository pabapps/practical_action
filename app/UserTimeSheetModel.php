<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTimeSheetModel extends Model
{

	public $timestamps = false;

	protected $table = 'time_sheet_user';
	protected $primaryKey = 'id';


}
