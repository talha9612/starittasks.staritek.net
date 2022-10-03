<?php

namespace App\Http\Controllers\Manager;

use App\Task;
use App\User;
use App\Project;
use App\TaskCatagory;
use App\OtherTeamMember;
use Illuminate\Http\Request;
use App\Mail\SendMarkDownMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Spatie\Activitylog\Models\Activity;

class TaskController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $projects = Project::where('create_project',Auth::user()->id)->orwhere('project_head',Auth::user()->id)->get();
        $tasks = Task::where('created_by',Auth::user()->id)->orwhere('user_id',Auth::user()->id)->get();

        $merged = User::where('user_type',$id)->orwhere('team_member',Auth::user()->id)->get();
        $others = OtherTeamMember::where('manager_id', $id)->get();
        $user_array = [];
        for($i=0; $i<sizeof($others); $i++){
            $user = User::where('id',$others[$i]->team_member_id)->first();
            array_push($user_array, $user);
        }
        $users =  $merged->merge($user_array);

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
        // For Email
        $tasks = Task::where('id',$task->id)->with('project','AssignBy')->first();
        $user = User::where('id',$task->user_id)->first();
        Mail::to($user->email)->send( new SendMarkDownMail($tasks, $user));
        // End For Email
        return redirect()->back()->with('success','Task Added Succefully!');
    }
    public function EditTask(Request $req){
        $id = Auth::user()->id;
        $task = Task::where('id',$req->id)->first();
        $project = Project::where('id',$task->project_id)->first();
        // $users = User::where('user_type',Auth::user()->id)->orwhere('team_member',Auth::user()->id)->where('role',3)->get();
        $merged = User::where('user_type',$id)->orwhere('team_member',Auth::user()->id)->get();
        $others = OtherTeamMember::where('manager_id', $id)->get();
        $user_array = [];
        for($i=0; $i<sizeof($others); $i++){
            $user = User::where('id',$others[$i]->team_member_id)->first();
            array_push($user_array, $user);
        }
        $users =  $merged->merge($user_array);
        $catagories = TaskCatagory::where('created_by',Auth::user()->id)->orwhere('created_by',Auth::user()->user_type)->get();
        return view('manager.edittask',compact('catagories','task','users','project'));
    }
    public function UpdateTask(Request $req){
        // dd($req->all());
        $images_array =[];
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
        $task->progress = $req->progress;
        if($req->progress == 'onehundred'){
            $task->status = 5;
        }else{
            $task->status = $req->status;
        }
        // if($req->hasFile('image')){
        //     $avatar = $req->file('image');
        //     $filename = time().'.'.$avatar->getClientOriginalExtension();
        //     Image::make($avatar)->save(public_path('/uploads/screenshots/'.$filename));
        //     $task->screen_shot = $filename;
        //     $task->save();
        // }
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
