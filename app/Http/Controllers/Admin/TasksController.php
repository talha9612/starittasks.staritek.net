<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Task;
use App\User;
use App\Project;
use App\TaskCatagory;
use Illuminate\Http\Request;
use App\Mail\SendMarkDownMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Spatie\Activitylog\Models\Activity;

class TasksController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $project_lists = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',Auth::user()->id)->get();
        $users = User::where('user_type',$id)->where('role',2)->get();
        $user =[Auth::user()->id];
        $projects =[];
        $tasks =[];
        for($i=0; $i<count($users); $i++){
            array_push($user, $users[$i]->id);
        }
        for($i=0; $i<sizeof($user); $i++){
            $project = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',$user[$i])->get();
            $task = Task::where('created_by',$user[$i])->with('project','AssignTo','AssignBy')->get();
            array_push($projects, $project);
            array_push($tasks, $task);
        }
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
        // For Email
        $tasks = Task::where('id',$task->id)->with('project','AssignBy')->first();
        $user = User::where('id',$task->user_id)->first();
        Mail::to($user->email)->send( new SendMarkDownMail($tasks, $user));
        // End For Email
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
        $images_array =[];
        $task = Task::find($req->id);
        $task->heading = $req->title;
        $task->description = $req->summary;
        $task->start_date = $req->start_date;
        $task->due_date = $req->due_date;
        $task->user_id = $req->assign_to;
        $task->project_id = $req->project_id;
        $task->task_category_id = $req->catagory;
        $task->priority = $req->priority;
        $task->progress = $req->progress;
        if($req->progress == 'onehundred'){
            $task->status = 5;
        }else{
            $task->status = $req->status;
        }
        if($req->hasFile('images')){
            $images = $req->file('images');
            for($i=0; $i<sizeof($images); $i++){
                $image = $images[$i];
                $filename = time().rand().'.'.$image->getClientOriginalExtension();
                Image::make($image)->save(public_path('/uploads/screenshots/'.$filename));
                array_push($images_array, $filename);
            }
        }
        if($images_array !=[]){
            $task->screen_shot = $images_array;
        }
        $task->save();
        // For Email
        $tasks = Task::where('id',$task->id)->with('project','AssignBy')->first();
        $user = User::where('id',$task->user_id)->first();
        Mail::to($user->email)->send( new SendMarkDownMail($tasks, $user));
        // End For Email
        return redirect('admin/tasks')->with('success','Task Updated Successfully!');
    }
    public function DeleteTask(Request $req){
        $id =$req->id;
        $attr = Task::find($id);
        $attr->delete();
        return redirect('admin/tasks');
    }
    public function SingleTaskModel(Request $req){
        $task = Task::where('id',$req->task_id)->with('project','AssignTo','AssignBy','GetTaskCatagory')->first();
        $backups = Activity::where('subject_id',$req->task_id)->orderBy('id', 'desc')->get();
        $users = User::get();
        
        return response()->json([
            'data'=>$task,
            'activities'=>$backups,
            'users'=>$users
        ]);
    }
}
