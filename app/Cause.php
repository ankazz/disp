<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cause extends Model
{
    protected $table = 'cause';

    public function task(){
        return $this->hasMany('App\Task');
    }
}
