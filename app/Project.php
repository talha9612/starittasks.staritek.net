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
        return $this->belongsTo('App\ProjectAssign','project_head', 'manager_id');
    }
}
