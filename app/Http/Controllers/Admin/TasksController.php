<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Task;
use App\TaskCatagory;
use Auth;
class TasksController extends Controller
{
    public function index(){
        $projects = Project::with('head','createproject','projectcatagory')->where('create_project',Auth::user()->id)->get();
        $id = Auth::user()->id;
        $users = User::where('user_type',$id)->get();
        $tasks = Task::where('created_by',$id)->with('project','AssignTo','AssignBy')->get();
        return view('admin.addtasks',compact('projects','users','tasks'));
    }
    public function AddTask(Request $req){
        $id = Auth::user()->id;
        $task = new Task();
        $task->heading = $req->title;
        $task->description = $req->summary;
        $task->start_date = $req->start_date;
        $task->due_date = $req->due_date;
        $task->user_id = $req->assign_to;
        $task->project_id = $req->project_id;
        $task->task_category_id = $req->catagory;
        $task->priority = $req->priority;
        $task->status = 1;
        $task->created_by = $id;
        $task->save();
        return redirect()->back();
    }
    public function SelectHead(Request $req){
        $project = Project::where('id',$req->id)->first();
        $user = User::where('id',$project->project_head)->first();
        return response()->json(['user'=>$user]);
    }
    public function EditTask(Request $req){
        $task = Task::where('id',$req->id)->with('project','AssignTo')->first();
        $manager_ids = [];
        $task_catagories = [];
        $managers = User::where('user_type',Auth::user()->id)->get();
        for($i=0; $i<sizeof($managers); $i++){
        array_push($manager_ids,$managers[$i]->id);
        }
        for($i=0; $i<sizeof($manager_ids); $i++){
            $catagories = TaskCatagory::where('created_by',$manager_ids[$i])->get();
            array_push($task_catagories, $catagories);
        }
        return view('admin.edittask',compact('task','task_catagories'));
    }
    public function UpdateTask(Request $req){
        $task = Task::find($req->id);
        $task->heading = $req->title;
        $task->description = $req->summary;
        $task->start_date = $req->start_date;
        $task->due_date = $req->due_date;
        $task->user_id = $req->assign_to;
        $task->project_id = $req->project_id;
        $task->task_category_id = $req->catagory;
        $task->priority = $req->priority;
        $task->status = 1;
        $task->save();
        return redirect('admin/tasks');
    }
    public function DeleteTask(Request $req){
        $id =$req->id;
        $attr = Task::find($id);
        $attr->delete();
        return redirect('admin/tasks');
    }
    
}
