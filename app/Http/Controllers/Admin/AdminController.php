<?php

namespace App\Http\Controllers\Admin;

use App\CompanySetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Auth;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Project;
use App\ProjectCatagory;
use App\Task;

class AdminController extends Controller
{
    public function index(){

        $id = Auth::user()->id;
        $setting = CompanySetting::where('user_id', $id)->first();
        // $projects = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',Auth::user()->id)->get();
        $project_lists = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',Auth::user()->id)->get();
        $managers = User::where('user_type',$id)->where('role',2)->get();
        $user =[Auth::user()->id];
        $projects =[];
        for($i=0; $i<count($managers); $i++){
            array_push($user, $managers[$i]->id);
        }
        //dd($users);
        for($i=0; $i<sizeof($user); $i++){
            $project = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',$user[$i])->get();
            array_push($projects, $project);
        }

        $users = User::where('user_type',Auth::user()->id)->where('role', 3)->with('getTasks')->get();
        $managerscount = User::where('user_type',Auth::user()->id)->where('role',2)->count();
        $user_ids = [Auth::user()->id];
        $projectCount = 0;
        $CompleteprojectCount = 0;
        $memCount = 0;
        $taskCount = 0;
        for($i=0; $i<sizeof($users); $i++){
            array_push($user_ids,$users[$i]->id);

        }
       // dd($user_ids);
        for($i=0; $i<sizeof($user_ids); $i++){
        $project = Project::where('create_project',$user_ids[$i])->count();
        $projectComplete = Project::where('create_project',$user_ids[$i])->where('status',5)->count();
        $memberscount = User::where('user_type',$user_ids[$i])->where('role',3)->count();
        //$taskscount = Task::where('created_by',$user_ids[$i])->where('status','!=',4)->where('status','!=',5)->count();

        $projectCount = $projectCount + $project;
        $CompleteprojectCount = $CompleteprojectCount + $projectComplete;
        $memCount +=$memberscount;
        //$taskCount +=$taskscount;
        }
        foreach ($users as $user) {
            array_push($user_ids, $user->id);
        }

        // Fetch tasks assigned to these users and not having status 4 or 5
        $tasks = Task::whereIn('user_id', $user_ids)
                     ->where('status', '!=', 4)
                     ->where('status', '!=', 5)
                     ->get();
                     $taskCount = $tasks->count();

        return view('admin.dashboard',compact('projects','projectCount','CompleteprojectCount','managerscount','memCount','taskCount','setting','managers'));
    }
    public function Dashboardv(){
        $id = Auth::user()->id;
        $setting = CompanySetting::where('user_id', $id)->first();
        $projects = Project::with('head','getTasks','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',Auth::user()->id)->get();
//        $project_lists = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',Auth::user()->id)->get();

        $users = User::where('user_type',Auth::user()->id)->where('role', 3)->with('getTasks')->get();
        $user_ids = [Auth::user()->id];
        $projectCount = 0;
        $CompleteprojectCount = 0;
        $memCount = 0;
        $taskCount = 0;
        for($i=0; $i<sizeof( $users); $i++){
            array_push($user_ids,$users[$i]->id);
        }
        for($i=0; $i<sizeof($user_ids); $i++){
            $project = Project::where('create_project',$user_ids[$i])->count();
            $projectComplete = Project::where('create_project',$user_ids[$i])->where('status',5)->count();
            $memberscount = User::where('user_type',$user_ids[$i])->where('role',3)->count();
            $taskscount = Task::where('created_by',$user_ids[$i])->where('status','!=',4)->where('status','!=',5)->count();

            $projectCount = $projectCount + $project;
            $CompleteprojectCount = $CompleteprojectCount + $projectComplete;
            $memCount +=$memberscount;
            $taskCount +=$taskscount;
        }
        // Fetch tasks assigned to these users and not having status 4 or 5
                $tasks = Task::whereIn('user_id', $user_ids)
                ->where('status', '!=', 4)
                ->where('status', '!=', 5)
                ->get();
                $taskCount = $tasks->count();
//        dd($projects);
        return view('admin.dashboardv',compact('projects','projectCount','CompleteprojectCount','memCount','taskCount','setting','users'));
    }
    public function ProjectHeads(){
        $id = Auth::user()->id;
        $users = User::where('user_type',$id)->where('role',2)->get();
        return response()->json([
            'users'=>$users
        ]);
    }

}
