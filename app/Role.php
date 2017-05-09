<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    
	public $timestamps = false;

    protected $table = 'roles';
    protected $primaryKey = 'id';

    
}
