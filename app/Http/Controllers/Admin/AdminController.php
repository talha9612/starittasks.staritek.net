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
    public function index()
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $userType = $user->user_type;
        $managers = User::where('user_type', $id)->where('role', 2)->get();

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
        $taskCount = Task::whereIn('created_by', $userIds)
            ->where('status', '!=', 4)
            ->where('status', '!=', 5)
            ->count();
        $memCount = $users->count();

        return view('admin.dashboard', compact(
            'projects',
            'projectCount',
            'CompleteprojectCount',
            'managerscount',
            'memCount',
            'taskCount',
            'setting',
            'users',
            'managers'
        ));
    }
    public function Dashboardv()
    {
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

        return view('admin.dashboardv', compact(
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
    public function ProjectHeads()
    {
        $id = Auth::user()->id;
        $users = User::where('user_type', $id)->where('role', 2)->get();
        return response()->json([
            'users' => $users
        ]);
    }
}
