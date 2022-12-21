<?php

namespace App\Http\Controllers\CEO;

use App\Task;
use App\User;
use App\Project;
use App\CompanySetting;
use Illuminate\Http\Request;
use App\Mail\SendMarkDownMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CeoController extends Controller
{
    public function index(){

        $id = Auth::user()->id;
        $setting = CompanySetting::where('user_id', $id)->first();

        $projects = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',Auth::user()->user_type)->get();
//      All Count Queries
        $managers = User::where('user_type',Auth::user()->user_type)->where('role', 3)->with('getTasks')->get();
        $managerscount = User::where('user_type',Auth::user()->user_type)->where('role',2)->count();
        $manager_ids = [Auth::user()->id];
        $projectCount = 0;
        $CompleteprojectCount = 0;
        $memCount = 0;
        $taskCount = 0;
        for($i=0; $i<sizeof($managers); $i++){
            array_push($manager_ids,$managers[$i]->id);

        }
        for($i=0; $i<sizeof($manager_ids); $i++){
            $project = Project::where('create_project',$manager_ids[$i])->count();
            $projectComplete = Project::where('create_project',$manager_ids[$i])->where('status',5)->count();
            $memberscount = User::where('user_type',$manager_ids[$i])->where('role',3)->count();
            $taskscount = Task::where('created_by',$manager_ids[$i])->where('status','!=',4)->where('status','!=',5)->count();

            $projectCount = $projectCount + $project;
            $CompleteprojectCount = $CompleteprojectCount + $projectComplete;
            $memCount +=$memberscount;
            $taskCount +=$taskscount;
        }
        return view('ceo.dashboard',compact('projects','projectCount','CompleteprojectCount','managerscount','memCount','taskCount','setting','managers'));
    }
    public function Dashboardv(){
        $id = Auth::user()->user_type;

        $setting = CompanySetting::where('user_id', $id)->first();
        $projects = Project::with('head','getTasksCeo','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',$id)->get();
        $managers = User::where('user_type',$id)->where('role', 3)->with('getTasks')->get();

        $manager_ids = [Auth::user()->id];
        $projectCount = 0;
        $CompleteprojectCount = 0;
        $memCount = 0;
        $taskCount = 0;
        for($i=0; $i<sizeof($managers); $i++){
            array_push($manager_ids,$managers[$i]->id);
        }
        for($i=0; $i<sizeof($manager_ids); $i++){
            $project = Project::where('create_project',$manager_ids[$i])->count();
            $projectComplete = Project::where('create_project',$manager_ids[$i])->where('status',5)->count();
            $memberscount = User::where('user_type',$manager_ids[$i])->where('role',3)->count();
            $taskscount = Task::where('created_by',$manager_ids[$i])->where('status','!=',4)->where('status','!=',5)->count();

            $projectCount = $projectCount + $project;
            $CompleteprojectCount = $CompleteprojectCount + $projectComplete;
            $memCount +=$memberscount;
            $taskCount +=$taskscount;
        }
//        dd($projects);
        return view('ceo.dashboardv',compact('projects','projectCount','CompleteprojectCount','memCount','taskCount','setting','managers'));
    }
    public function ProjectHeads(){
        $id = Auth::user()->id;
        $users = User::where('user_type',$id)->where('role',2)->get();
        return response()->json([
            'users'=>$users
        ]);
    }
}
