<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\ProjectAssign;
use App\Task;
use Illuminate\Http\Request;
// use Auth;
use illuminate\Support\Facades\Auth;
use App\User;
use App\Project;
class UserController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $assigns = ProjectAssign::where('user_id',Auth::user()->id)->get();
        $assign_projects = ProjectAssign::where('user_id',Auth::user()->id)->count();
        $assign_task = Task::where('user_id',Auth::user()->id)->where('status','!=',4)->where('status','!=',5)->count();
        $complete_task = Task::where('user_id',Auth::user()->id)->where('status',5)->count();
        $tasks = Task::where('user_id',Auth::user()->id)->where('approved',0)->orwhere('user_id',Auth::user()->user_type)->with('project','AssignTo','AssignBy')->get();
        $projects = Project::where('project_head',$id)->orwhere('project_head',Auth::user()->id)->with('head','createproject','projectcatagory')->get();
        $users = User::where('user_type',$id)->where('role',3)->get();
        return view('user.dashboard',compact('assign_projects','assign_task','complete_task','tasks'));
    }
}
