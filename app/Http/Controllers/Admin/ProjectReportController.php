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
        $currentUser = Auth::user();
        $userType = $currentUser->user_type;
        $currentUserId = $currentUser->id;
    
        $userIds = User::where('user_type', $userType)
            ->whereIn('role', [1, 2, 3])
            ->pluck('id');
    
        $projects = Project::with('head', 'createproject', 'projectcatagory', 'assign_project.getusers')
            ->whereIn('create_project', $userIds)
            ->get();
    
        $users = User::where('user_type', $userType)
            ->where('role', 3)
            ->get();
    
        return view('admin.projectreport', compact('projects', 'users'));
    }
    
}
