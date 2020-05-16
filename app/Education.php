<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    public function employee()
    {
        $this->hasMany('App\Employee');
    }
}
