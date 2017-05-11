<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDesignationModel extends Model
{
    public $timestamps = false;

    protected $table = 'user_designation_connection';
    protected $primaryKey = 'id';
}
