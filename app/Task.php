<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['heading', 'description', 'due_date', 'start_date', 'priority', 'status', 'progress', 'approved', 'created_by', 'screen_shot'];

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }
    public function AssignTo()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function AssignBy()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
    public function GetUsers()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function GetTaskCatagory()
    {
        return $this->belongsTo('App\TaskCatagory', 'task_category_id', 'id');
    }
    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
    public function isDueInLessThan24Hours(): bool
    {
        // Get the due date of the task
        $dueDate = Carbon::parse($this->due_date);

        // Get the current date and time
        $now = Carbon::now();

        // Calculate the time difference in hours
        return $dueDate->diffInHours($now) < 48 && $dueDate->isFuture();
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship to get the assignee of the task
    public function assignee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
