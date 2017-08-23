<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactsTheme extends Model
{
    protected $table = 'themes';
    public $timestamps = true;
    protected $primaryKey = 'id';


    public function contact()
    {
        return $this->belongsToMany('App\Contacts');
    }
}
