<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectReportController extends Controller
{
    public function index(){
        $id = Auth::user()->id;  
        $projects = Project::with('head','createproject','projectcatagory','assign_project.getusers')->where('create_project',Auth::user()->id)->get();
        $users = User::where('user_type',$id)->where('role',3)->get();

        $user =[Auth::user()->id];
        $projects =[];
        for($i=0; $i<count($users); $i++){
            array_push($user, $users[$i]->id);
        }
        for($i=0; $i<sizeof($user); $i++){
            $project = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',$user[$i])->get();
            array_push($projects, $project);
        }
          
        return view('admin.projectreport',compact('projects','users'));
    }
}
