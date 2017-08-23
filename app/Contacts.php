<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $table = 'contacts';
    public $timestamps = true;
    protected $primaryKey = 'id';


    public function category()
    {
        return $this->belongsTo('App\Categories');
    }

    public function theme()
    {
        return $this->belongsToMany('App\ContactsTheme');
    }
}
