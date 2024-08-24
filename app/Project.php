<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    public function head()
    {
        return $this->belongsTo('App\User','project_head', 'id');
    }
    public function createproject()
    {
        return $this->belongsTo('App\User','create_project', 'id');
    }
    public function projectcatagory()
    {
        return $this->belongsTo('App\ProjectCatagory','category_id', 'id');
    }
    public function assign_project()
    {
         return $this->hasMany('App\ProjectAssign','project_id', 'id');
    }
    public function project_id()
    {
         return $this->hasMany('App\ProjectAssign','project_id', 'id');
    }
    public function getTasks(){
        return $this->hasMany('App\Task','project_id','id');
    }
    public function getTasksCeo(){
        return $this->hasMany('App\Task','project_id','id')
            ->where('approved', 0)
            ->where('task_view_ceo', 1);
    }
}
