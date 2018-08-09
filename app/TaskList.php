<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    protected $table = 'taskList';

    
    public function task()
    {
        return $this->belongsTo('App\Task','task_id','id');
    }

}
