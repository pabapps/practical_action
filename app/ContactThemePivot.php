<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactThemePivot extends Model
{
    protected $table = 'contact_theme';
    public $timestamps = true;
    protected $primaryKey = 'id';
}
