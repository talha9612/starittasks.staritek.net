<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectAssign extends Model
{
    protected $table='project_assign'; 

    protected $fillable = ['project_id', 'user_id', 'manager_id'];

    
    public function GetUsers()
    {
         return $this->belongsTo('App\User','user_id', 'id');
    }
    public function project_id()
    {
         return $this->belongsTo('App\Project','project_id', 'id');
    }
}
