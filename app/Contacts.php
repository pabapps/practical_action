<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $table = 'contacts';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
