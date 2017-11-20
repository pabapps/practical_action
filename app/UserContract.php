<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserContract extends Model
{
    public $timestamps = false;

    protected $table = 'contract';
    protected $primaryKey = 'id';
}
