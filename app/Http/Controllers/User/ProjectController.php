<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Task;
use App\Project;
use App\ProjectAssign;
use App\Skill;
use DateTime;
class ProjectController extends Controller
{
    public function index(Request $req){
        $project = project::where('id',$req->project_id)->with('projectcatagory')->first();
        $date1 = new DateTime($project->start_date);
        $date2 = new DateTime($project->deadline);
        $interval = $date1->diff($date2);
        $left_days = $interval->format('%a');
        $assign_task = Task::where('user_id',Auth::user()->id)->where('status','!=',4)->where('status','!=',5)->count();
        $complete_task = Task::where('user_id',Auth::user()->id)->where('status',5)->count();
        $assign_tables = ProjectAssign::where('project_id',$req->project_id)->with('Getusers')->get();
        $skills = [];
        $skills = Skill::where('user_id',$project->create_project)->get();
        if(count($skills) == 0){
            $skills = Skill::where('user_id',$project->project_head)->get();
        }
        $tasks = Task::where('user_id',Auth::user()->id)->orwhere('user_id',Auth::user()->user_type)->where('project_id',$req->project_id)->with('project','AssignTo','AssignBy')->get();
        return view('user.project',compact('project','left_days','assign_task','complete_task','assign_tables','skills','tasks'));
    }
   
}
