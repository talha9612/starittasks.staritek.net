<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Project;
use App\ProjectAssign;
use App\Task;
// use Auth;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $req)
    {
        $id = Auth::user()->id;
        $assign_task = Task::where('user_id', Auth::user()->id)->where('status', '!=', 4)->where('status', '!=', 5)->count();
        $complete_task = Task::where('user_id', Auth::user()->id)->where('status', 5)->count();
        $tasks = Task::where('user_id', Auth::user()->id)->where('approved', 0)->orwhere('user_id', Auth::user()->user_type)->with('project', 'AssignTo', 'AssignBy')->get();

        $assignedProjectIds = ProjectAssign::where('user_id', $id)
            ->pluck('project_id')
            ->toArray();

        $projects = Project::where(function ($query) use ($id, $assignedProjectIds) {
            $query->where('create_project', $id)
                ->orWhere('project_head', $id)
                ->orWhereIn('id', $assignedProjectIds);
        })
            ->with('head', 'createproject', 'projectcatagory', 'assigns')
            ->get();
            $due_dates = [];


                $assign_projects = count($assignedProjectIds);



        $users = User::where('user_type', $id)->where('role', 3)->get();
        return view('user.dashboard', compact('assign_projects', 'assign_task', 'complete_task', 'tasks', 'projects'));
    }}