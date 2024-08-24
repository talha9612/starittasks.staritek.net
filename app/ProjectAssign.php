<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectAssign extends Model
{
    protected $table='project_assign'; 
    
    public function GetUsers()
    {
         return $this->belongsTo('App\User','user_id', 'id');
    }
    public function project_id()
    {
         return $this->belongsTo('App\Project','project_id', 'id');
    }
}
