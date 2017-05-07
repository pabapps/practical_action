<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = 'projects';
    public $timestamps = false;
    protected $primaryKey = 'id';



    /**
     * get the 
     */
    public function user_projects(){

    	return $this->hasMany('App\UserProjectConnection', 'project_id'); //project_id is the foreign on that table

    }
}
