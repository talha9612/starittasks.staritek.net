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
        // $projects = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',Auth::user()->id)->get();
        $projects = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',Auth::user()->user_type)->get();
        $users = User::where('user_type',$id)->get();

        $managers = User::where('user_type',Auth::user()->id)->get();
        $managerscount = User::where('user_type',Auth::user()->user_type)->count();
    
        $manager_ids = [];
        $projectCount = Project::where('create_project',Auth::user()->user_type)->count();
        $CompleteprojectCount =  Project::where('create_project',Auth::user()->user_type)->where('status',4)->where('status',5)->count();
        $memCount = User::where('user_type',Auth::user()->user_type)->where('role',3)->count();
        $taskCount = Task::where('created_by',Auth::user()->user_type)->where('status','!=',4)->where('status','!=',5)->count();
        return view('ceo.dashboard',compact('projects','projectCount','CompleteprojectCount','managerscount','memCount','taskCount','setting'));
    }
    public function ProjectHeads(){
        $id = Auth::user()->id;
        $users = User::where('user_type',$id)->where('role',2)->get();
        return response()->json([
            'users'=>$users
        ]);
    }
}
