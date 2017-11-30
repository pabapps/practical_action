<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserContractNotification extends Model
{
	public $timestamps = false;

	protected $table = 'contract_notification_log';
	protected $primaryKey = 'id';
}
