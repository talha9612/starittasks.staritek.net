<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Project;
use App\User;
use App\Task;
use App\TaskCatagory;
use Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(){
        $projects = Project::where('create_project',Auth::user()->id)->orwhere('project_head',Auth::user()->id)->get();
        $users = User::where('user_type',Auth::user()->id)->orwhere('team_member',Auth::user()->id)->get();
        $tasks = Task::where('created_by',Auth::user()->id)->orwhere('user_id',Auth::user()->id)->get();
        return view('manager.taskhome',compact('projects','users','tasks'));
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
        $task->status = $req->status;
        $task->created_by = $id;
        $task->save();
        return redirect()->back()->with('success','Task Added Succefully!');
    }
    public function EditTask(Request $req){
        $task = Task::where('id',$req->id)->first();
        $project = Project::where('id',$task->project_id)->first();
        $users = User::where('user_type',Auth::user()->id)->orwhere('team_member',Auth::user()->id)->where('role',3)->get();
        $catagories = TaskCatagory::where('created_by',Auth::user()->id)->orwhere('created_by',Auth::user()->user_type)->get();
        return view('manager.edittask',compact('catagories','task','users','project'));
    }
    public function UpdateTask(Request $req){
        $task = Task::where('id',$req->task_id)->first() ;
        $task->heading = $req->title;
        $task->description = $req->summary;
        $task->due_date = $req->due_date;
        $task->start_date = $req->start_date;
        $task->user_id = $req->assign_to;
        $task->project_id = $req->project_id;
        $task->task_category_id = $req->catagory;
        $task->priority = $req->priority;
        $task->created_by = Auth::user()->id;
        $task->status = $req->status;
        $task->save();
        return redirect('/manager/tasks')->with('success','Task Updated Successfully!');
    }
    public function DeleteTask(Request $req){
        $task = Task::find($req->id);
        $task->delete();
        return back()->with('success','Task Deleted Successfully!');
    }
    public function TaskApproved(Request $req){
        $task = Task::find($req->status_id);
        $task->approved = $req->status;
        $task->save();
        if($req->status == 0){
            return response()->json(['success'=>'Task Unapproved Successfully!']);
        }else{
            return response()->json(['success'=>'Task Approved Successfully!']);
        }
        
    }
}
