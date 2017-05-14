<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProjectModel extends Model
{
    public $timestamps = false;

    protected $table = 'users_projects_connection';
    protected $primaryKey = 'id';
}
