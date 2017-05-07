<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = 'designation';
    public $timestamps = false;
    protected $primaryKey = 'id';



    public function designation_connection()
    {
        return $this->hasOne('App\UserDesignationConnection','designation_id');
    }
}
