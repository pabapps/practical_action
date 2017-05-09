<?php

namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    
	public $timestamps = false;

    protected $table = 'permissions';
    protected $primaryKey = 'id';
    

}
