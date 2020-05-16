<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function employee()
    {
        $this->hasMany('App\Employee');
    }
}
