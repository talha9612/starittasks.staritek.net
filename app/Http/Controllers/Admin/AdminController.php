<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Project;
use App\ProjectCatagory;
use App\Task;

class AdminController extends Controller
{
    public function index(){
        $projects = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',Auth::user()->id)->get();
        $managers = User::where('user_type',Auth::user()->id)->get();
        $managerscount = User::where('user_type',Auth::user()->id)->where('role',2)->count();
    
        $manager_ids = [];
        $projectCount = 0;
        $CompleteprojectCount = 0;
        $memCount = 0;
        $taskCount = 0;
        for($i=0; $i<sizeof($managers); $i++){
            array_push($manager_ids,$managers[$i]->id);
        }
        for($i=0; $i<sizeof($manager_ids); $i++){
        $project = Project::where('create_project',$manager_ids[$i])->count();
        $projectComplete = Project::where('create_project',$manager_ids[$i])->where('status',4)->where('status',5)->count();
        $memberscount = User::where('user_type',$manager_ids[$i])->where('role',3)->count();
        $taskscount = Task::where('created_by',$manager_ids[$i])->where('status','!=',4)->where('status','!=',5)->count();

        $projectCount = $projectCount + $project;
        $CompleteprojectCount = $CompleteprojectCount + $projectComplete;
        $memCount +=$memberscount;
        $taskCount +=$taskscount;

        }
        return view('admin.dashboard',compact('projects','projectCount','CompleteprojectCount','managerscount','memCount','taskCount'));
    }
    public function ProjectHeads(){
        $id = Auth::user()->id;
        $users = User::where('user_type',$id)->where('role',2)->get();
        return response()->json([
            'users'=>$users
        ]);
    }
   
}
