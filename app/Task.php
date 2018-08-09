<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function causes()
    {
        //return $this->belongsTo('App\Cause', 'Cause_ID', 'id');
        return $this->belongsTo('App\Cause','Cause_ID','id');
    }

    public function status()
    {
        return $this->belongsTo('App\Status','Status_ID','id');
    }

    public function taskList(){
        return $this->hasMany('App\TaskList');
    }
}
