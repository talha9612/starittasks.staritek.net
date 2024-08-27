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
    // public function index(){

    //     $id = Auth::user()->id;
    //     $setting = CompanySetting::where('user_id', $id)->first();

    //     $projects = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',Auth::user()->user_type)->get();
    //     $users = User::where('user_type',Auth::user()->user_type)->where('role', 3)->with('getTasks')->get();
    //     $managerscount = User::where('user_type',Auth::user()->user_type)->where('role',2)->count();
    //     $user_ids = [Auth::user()->id];
    //     $projectCount = 0;
    //     $CompleteprojectCount = 0;
    //     $memCount = 0;
    //     $taskCount = 0;
    //     for($i=0; $i<sizeof($users); $i++){
    //         array_push($user_ids,$users[$i]->id);
    //     }
    //     for($i=0; $i<sizeof($user_ids); $i++){
    //         $project = Project::where('create_project',$user_ids[$i])->count();
    //         $projectComplete = Project::where('create_project',$user_ids[$i])->where('status',5)->count();
    //         $memberscount = User::where('user_type',$user_ids[$i])->where('role',3)->count();
    //         $taskscount = Task::where('created_by',$user_ids[$i])->where('status','!=',4)->where('status','!=',5)->count();
    //         $projectCount = $projectCount + $project;
    //         $CompleteprojectCount = $CompleteprojectCount + $projectComplete;
    //         $memCount +=$memberscount;
    //         $taskCount +=$taskscount;
    //     }
    //     return view('ceo.dashboard',compact('projects','projectCount','CompleteprojectCount','managerscount','memCount','taskCount','setting','users'));
    // }

    // public function index()
    // {
    //     $user = Auth::user();
    //     $userType = $user->user_type;
    //     $userId = $user->id;
    
    //     $setting = CompanySetting::where('user_id', $userId)->first();
    
    //     $projects = Project::with('head', 'createproject', 'projectcatagory', 'assign_project.GetUsers')
    //         ->where('create_project', $userType)
    //         ->get();
    
    //     $users = User::where('user_type', $userType)
    //         ->where('role', 3)
    //         ->get();
    
    //     $managersCount = User::where('user_type', $userType)
    //         ->where('role', 2)
    //         ->count();
    
    //     $userIds = User::where('user_type', $userType)->pluck('id')->toArray();
    
    //     $projectCount = Project::whereIn('create_project', $userIds)->count();
    //     $CompleteprojectCount = Project::whereIn('create_project', $userIds)->where('status', 5)->count();
    //     $pendingTaskCount = Task::whereIn('created_by', $userIds)
    //         ->where('status', '!=', 4)
    //         ->where('status', '!=', 5)
    //         ->count();
    //     $memCount = $users->count(); 
    
    //     return view('ceo.dashboard', compact(
    //         'projects', 
    //         'projectCount', 
    //         'CompleteprojectCount', 
    //         'managersCount', 
    //         'memCount', 
    //         'pendingTaskCount', 
    //         'setting', 
    //         'users'
    //     ));
    // }
    
    public function index()
    {
        $user = Auth::user();
        $userType = $user->user_type;
        
        $setting = CompanySetting::where('user_id', $user->id)->first();
    
        $projects = Project::with('head', 'createproject', 'projectcatagory', 'assign_project.GetUsers')
            ->where('create_project', $userType)
            ->where('status', 5) 
            ->get();
    
        $users = User::where('user_type', $userType)
            ->where('role', 3)
            ->get();
    
        $managerscount = User::where('user_type', $userType)
            ->where('role', 2)
            ->count();
    
        $userIds = User::where('user_type', $userType)->pluck('id')->toArray();
    
        $projectCount = Project::whereIn('create_project', $userIds)->count();
        $CompleteprojectCount = Project::whereIn('create_project', $userIds)
            ->where('status', 5)
            ->count();
        $pendingTaskCount = Task::whereIn('created_by', $userIds)
            ->where('status', '!=', 4)
            ->where('status', '!=', 5)
            ->count();
        $memCount = $users->count(); 
    
        return view('ceo.dashboard', compact(
            'projects', 
            'projectCount', 
            'CompleteprojectCount', 
            'managerscount', 
            'memCount', 
            'pendingTaskCount', 
            'setting', 
            'users'
        ));
    }
    
      
    // public function Dashboardv() {
    //     $user = Auth::user();
    //     $userType = $user->user_type;
    
    //     $setting = CompanySetting::where('user_id', $user->id)->first();
    
    //     $project = Project::with('head', 'createproject', 'projectcatagory', 'assign_project.GetUsers')
    //         ->where('create_project', $userType)
    //         ->get();
    
    //     $users = User::where('user_type', $userType)
    //         ->where('role', 3)
    //         ->get();
    
    //     $managerscount = User::where('user_type', $userType)
    //         ->where('role', 2)
    //         ->count();
    
    //     $userIds = User::where('user_type', $userType)->pluck('id');
    
    //     $projectCount = Project::whereIn('create_project', $userIds)->count();
    //     $CompleteprojectCount = Project::whereIn('create_project', $userIds)
    //         ->where('status', 5)
    //         ->count();
    
    //     $tasksByProject = Task::select('tasks.*', 'projects.project_name')
    //         ->join('projects', 'tasks.project_id', '=', 'projects.id')
    //         ->whereIn('tasks.created_by', $userIds)
    //         ->where('tasks.status', '!=', 4)
    //         ->where('tasks.status', '!=', 5)
    //         ->get()
    //         ->groupBy('project_id');
    
    //     $taskCount = Task::whereIn('created_by', $userIds)
    //         ->where('status', '!=', 4)
    //         ->where('status', '!=', 5)
    //         ->count();
    
    //     $memCount = $users->count();
    //     return view('ceo.dashboardv', compact(
    //         'project',
    //         'projectCount',
    //         'CompleteprojectCount',
    //         'memCount',
    //         'taskCount',
    //         'setting',
    //         'managerscount',
    //         'tasksByProject'
    //     ));
    // }
    public function Dashboardv() {
        $user = Auth::user();
        $userType = $user->user_type;
    
        // Fetch company settings
        $setting = CompanySetting::where('user_id', $user->id)->first();
    
        // Get IDs of managers and admins
        $userIds = User::where('user_type', $userType)
            ->whereIn('role', [2, 1]) // Assuming role 2 is for managers and role 1 is for admins
            ->pluck('id');
    
        // Fetch projects created by managers or admins
        $projects = Project::with('head', 'createproject', 'projectcatagory', 'assign_project.GetUsers')
            ->whereIn('create_project', $userIds)
            ->get();
    
        // Fetch users with role 3 (team members)
        $users = User::where('user_type', $userType)
            ->where('role', 3)
            ->get();
    
        // Count managers and admins
        $managersAndAdminsCount = User::where('user_type', $userType)
            ->whereIn('role', [2, 1]) // Count both managers and admins
            ->count();
    
        // Collect all user IDs in the same company
        $userIds = User::where('user_type', $userType)->pluck('id');
    
        // Aggregate counts
        $projectCount = Project::whereIn('create_project', $userIds)->count();
        $CompleteprojectCount = Project::whereIn('create_project', $userIds)
            ->where('status', 5)
            ->count();
    
        // Group tasks by project_id
        $tasksByProject = Task::select('tasks.*', 'projects.project_name')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->whereIn('tasks.created_by', $userIds)
            ->where('tasks.status', '!=', 4)
            ->where('tasks.status', '!=', 5)
            ->get()
            ->groupBy('project_id');
    
        $taskCount = Task::whereIn('created_by', $userIds)
            ->where('status', '!=', 4)
            ->where('status', '!=', 5)
            ->count();
    
        $memCount = $users->count();
    
        return view('ceo.dashboardv', compact(
            'projects',
            'projectCount',
            'CompleteprojectCount',
            'memCount',
            'taskCount',
            'setting',
            'managersAndAdminsCount',
            'tasksByProject'
        ));
    }
    
    
            // $id = Auth::user()->user_type;

        // $setting = CompanySetting::where('user_id', $id)->first();
        // $projects = Project::with('head','getTasksCeo','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',$id)->get();
        // $managers = User::where('user_type',$id)->where('role', 3)->with('getTasks')->get();

        // $manager_ids = [Auth::user()->id];
        // $projectCount = 0;
        // $CompleteprojectCount = 0;
        // $memCount = 0;
        // $taskCount = 0;
        // for($i=0; $i<sizeof($managers); $i++){
        //     array_push($manager_ids,$managers[$i]->id);
        // }
        // for($i=0; $i<sizeof($manager_ids); $i++){
        //     $project = Project::where('create_project',$manager_ids[$i])->count();
        //     $projectComplete = Project::where('create_project',$manager_ids[$i])->where('status',5)->count();
        //     $memberscount = User::where('user_type',$manager_ids[$i])->where('role',3)->count();
        //     $taskscount = Task::where('created_by',$manager_ids[$i])->where('status','!=',4)->where('status','!=',5)->count();
        //     $projectCount = $projectCount + $project;
        //     $CompleteprojectCount = $CompleteprojectCount + $projectComplete;
        //     $memCount +=$memberscount;
        //     $taskCount +=$taskscount;      
        //}
        

        

    
    public function ProjectHeads(){
        $id = Auth::user()->id;
        $users = User::where('user_type',$id)->where('role',2)->get();
        return response()->json([
            'users'=>$users
        ]);
    }
}
