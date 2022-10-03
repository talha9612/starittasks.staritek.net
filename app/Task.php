<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Task extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['heading','description','due_date','start_date','priority','status','progress','approved','created_by','screen_shot'];

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
