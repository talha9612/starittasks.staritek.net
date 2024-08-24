<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Task;
use App\Project;
use App\ProjectAssign;
use App\Skill;
use App\User;
use DateTime;
class ProjectController extends Controller
{
    public function index(Request $req){
        $project = project::where('id',$req->project_id)->with('projectcatagory')->first();
        $date1 = new DateTime();
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
        $users = User::where('id',Auth::user()->team_member)->first();
        $tasks = Task::where('created_by',$users->id)->where('project_id',$req->project_id)->with('project','AssignTo','AssignBy')->get();
        // $tasks = Task::where('user_id',Auth::user()->id)->orWhere('created_by',Auth::user()->user_type)->where('project_id',$req->project_id)->with('project','AssignTo','AssignBy')->get();
        return view('user.project',compact('project','left_days','assign_task','complete_task','assign_tables','skills','tasks'));
    }
   
}
