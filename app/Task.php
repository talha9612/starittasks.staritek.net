<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function project()
    {
        return $this->belongsTo('App\Project','project_id', 'id');
    }
    public function AssignTo()
    {
        return $this->belongsTo('App\User','user_id', 'id');
    }
    public function AssignBy()
    {
        return $this->belongsTo('App\User','created_by', 'id');
    }
    public function GetUsers()
    {
        return $this->belongsTo('App\User','user_id', 'id');
    }
    public function GetTaskCatagory()
    {
        return $this->belongsTo('App\TaskCatagory','task_category_id', 'id');
    }
}
