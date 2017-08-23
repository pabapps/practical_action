<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';
    public $timestamps = false;
    protected $primaryKey = 'id';


    public function contact()
    {
        return $this->hasMany('App\Contacts');
    }
}
