<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    protected $guard = 'employee';

    public function education()
    {
        return $this->belongsTo('App\Education');
    }

    public function position()
    {
        return $this->belongsTo('App\Position');
    }
}
