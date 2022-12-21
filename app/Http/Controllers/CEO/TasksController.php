<?php

namespace App\Http\Controllers\CEO;

use App\Task;
use App\User;
use App\Project;
use App\TaskCatagory;
use Illuminate\Http\Request;
use App\Mail\SendMarkDownMail;
use App\Http\Controllers\Controller;
use App\ProjectAssign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Spatie\Activitylog\Models\Activity;
use App\Jobs\SendEmail;

class TasksController extends Controller
{
    public function index(){

        $id = Auth::user()->user_type;
        $projects = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',$id)->get();

        $tasks = Task::where('created_by',$id)->where('task_view_ceo',1)->with('project','AssignTo','AssignBy')->get();
        return view('ceo.addtasks',compact('projects','tasks'));
    }
    public function AddTask(Request $req){
        // $id = Auth::user()->id;
        // $task = new Task();
        // $task->heading = $req->title;
        // $task->description = $req->summary;
        // $task->start_date = $req->start_date;
        // $task->due_date = $req->due_date;
        // $task->user_id = $req->assign_to;
        // $task->project_id = $req->project_id;
        // $task->task_category_id = $req->catagory;
        // $task->priority = $req->priority;
        // $task->status = 1;
        // $task->created_by = $id;
        // $task->save();
        // // For Email
        // $tasks = Task::where('id',$task->id)->with('project','AssignBy')->first();
        // $user = User::where('id',$task->user_id)->first();
        // Mail::to($user->email)->send( new SendMarkDownMail($tasks, $user));
        // // End For Email
        // return redirect()->back();
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
        // Project Complition Calculation
            $project = Project::where('id',$req->project_id)->first();
            $tasks = Task::where('project_id',$req->project_id)->get();
            $NumberOfTasks = sizeof($tasks);

            $TasksInProjectNum = (100/($NumberOfTasks+1));
            // For Remove Privous added Value Into Project Progress Bar
                $project_com = 0;
                for ($i=0; $i < sizeof($tasks) ; $i++) {
                    if($project->project_complete>0){
                        $pproject_progress = ($tasks[$i]->progress_int*($TasksInProjectNum))/100;
                        $project_com += $pproject_progress;
                    }
                }
            // Prvious Value remove End Here //
            $task_progress = intval($task->progress_int);
            $project_progress = ($task_progress*($TasksInProjectNum))/100;
            $project_com += $project_progress;
            $project->project_complete= $project_com;
            $project->save();
        // Calculation end //
        $task->save();
        // For Email
        $tasks = Task::where('id',$task->id)->with('project','AssignBy')->first();
        $user = User::where('id',$task->user_id)->first();
        Mail::to($user->email)->send( new SendMarkDownMail($tasks, $user));
        // End For Email
        return redirect()->back()->with('success','Task Added Succefully!');
    }
    public function SelectHead(Request $req){
        $project = Project::where('id',$req->id)->first();
        $user = User::where('id',$project->project_head)->first();
        $users = User::where('team_member',$user->team_member)->where('role',3)->get();
        return response()->json(['users'=>$users]);
    }
    public function EditTask(Request $req){
        $task = Task::where('id',$req->id)->with('project','AssignTo')->first();
        $manager_ids = [];
        $task_catagories = [];
        $managers = User::where('team_member',Auth::user()->id)->where('role',3)->get();
        // dd($managers);
        // for($i=0; $i<sizeof($managers); $i++){
        // array_push($manager_ids,$managers[$i]->id);
        // }
        // for($i=0; $i<sizeof($manager_ids); $i++){
            $task_catagories = TaskCatagory::where('created_by',Auth::user()->id)->get();
        //     array_push($task_catagories, $catagories);
        // }
        return view('admin.edittask',compact('task','task_catagories','managers'));
    }
    public function UpdateTask(Request $req){
        // $images_array =[];
        // $task = Task::find($req->id);
        // $task->heading = $req->title;
        // $task->description = $req->summary;
        // $task->start_date = $req->start_date;
        // $task->due_date = $req->due_date;
        // $task->user_id = $req->assign_to;
        // $task->project_id = $req->project_id;
        // $task->task_category_id = $req->catagory;
        // $task->priority = $req->priority;
        // $task->progress = $req->progress;
        // if($req->progress == 'onehundred'){
        //     $task->status = 5;
        // }else{
        //     $task->status = $req->status;
        // }
        // if($req->hasFile('images')){
        //     $images = $req->file('images');
        //     for($i=0; $i<sizeof($images); $i++){
        //         $image = $images[$i];
        //         $filename = time().rand().'.'.$image->getClientOriginalExtension();
        //         Image::make($image)->save(public_path('/uploads/screenshots/'.$filename));
        //         array_push($images_array, $filename);
        //     }
        // }
        // if($images_array !=[]){
        //     $task->screen_shot = $images_array;
        // }
        // $task->save();
        // // For Email
        // $tasks = Task::where('id',$task->id)->with('project','AssignBy')->first();
        // $user = User::where('id',$task->user_id)->first();
        // Mail::to($user->email)->send( new SendMarkDownMail($tasks, $user));
        // // End For Email
        // return redirect('admin/tasks')->with('success','Task Updated Successfully!');
        $images_array =[];
        $task = Task::where('id',$req->id)->first();
        $task->heading = $req->title;
        $task->description = $req->summary;
        $task->due_date = $req->due_date;
        $task->start_date = $req->start_date;
        $task->user_id = $req->assign_to;
        $task->project_id = $req->project_id;
        $task->task_category_id = $req->catagory;
        $task->priority = $req->priority;
        $privous_progress = $task->progress_int;
        $task->created_by = Auth::user()->id;
        $task->progress = $req->progress;
        if($req->progress =='five'){
            $task->progress_int = 5;
        }else if($req->progress =='twentyfive'){
            $task->progress_int = 25;
        }else if($req->progress =='fifty'){
            $task->progress_int = 50;
        }else if($req->progress =='seventyfive'){
            $task->progress_int = 75;
        }else if($req->progress =='onehundred'){
            $task->progress_int = 100;
        }
        if($req->progress == 'onehundred'){
            $task->status = 5;
        }else{
            $task->status = $req->status;
        }
        // Project Complition Calculation
            $project = Project::where('id',$req->project_id)->first();
            $tasks = Task::where('project_id',$req->project_id)->get();
            $NumberOfTasks = sizeof($tasks);
            $TasksInProjectNum = (100/$NumberOfTasks);
            // For Remove Privous added Value Into Project Progress Bar
            $project_com = 0;
            for ($i=0; $i < sizeof($tasks) ; $i++) {

                    $pproject_progress = ($tasks[$i]->progress_int*(100/$NumberOfTasks))/100;
                    $project_com += $pproject_progress;

            }
                if($project_com>0 && $privous_progress>0){
                    $pproject_progress = ($privous_progress*$TasksInProjectNum)/100;
                    $project_com -= $pproject_progress;
                }
            // Prvious Value remove End Here //
            $task_progress = intval($task->progress_int);
            $project_progress = ($task_progress*$TasksInProjectNum)/100;
            $project_com += $project_progress;
            $project->project_complete= $project_com;
            $project->save();
        // Calculation end //
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
    public function ShowTaskDetail(Request $req){
        // dd(request()->path());
        $task = Task::where('id',$req->id)->with('project','AssignTo','AssignBy','GetTaskCatagory')->first();
        $date2 = strtotime($task->due_date);
        $now = time();
        $datediff = $date2 - $now;
        $left_days = round($datediff / (60 * 60 * 24));
        $pending_tasks = Task::where('id',$req->id)->where('status','!=',4)->where('status','!=',5)->count();
        $complete_task = Task::where('id',$req->id)->where('status',5)->count();
        $backups = Activity::where('subject_id',$req->id)->orderBy('id', 'desc')->get();
        $users = User::get();
        // $assign_tables = ProjectAssign::where('project_id',$req->project_id)->with('Getusers')->get();
        // $skills = [];
        // $skills = Skill::where('user_id',$project->create_project)->get();
        // if(count($skills) == 0){
        //     $skills = Skill::where('user_id',$project->project_head)->get();
        // }
        return view('ceo.taskdetails',compact('left_days','pending_tasks','complete_task','task','backups','users'));
    }
    public function SingleTaskComplete(Request $request){
        // dd($request->all());

        $task = Task::find($request->task_id);
        $task->description = $request->desc;
        $task->save();
        // For Email
        $tasks = Task::where('id',$request->task_id)->with('project','AssignBy')->first();

        // Get Users For Email ////////
        $assign_projects = ProjectAssign::where('project_id',$task->project_id)->get();
        $users = [];
        $user1 = User::where('id',$tasks->user_id)->first();
        $user2 = User::where('id',$tasks->created_by)->first();
        array_push($users,$user1);
        array_push($users,$user2);
        for($i=0; $i<sizeof($assign_projects); $i++){
            $user = User::where('id',$assign_projects[$i]->user_id)->first();
            if($user->email !== $user1->email){
                array_push($users, $user);
            }
        }
        // End Get Users For Email ///////
        for($i=0; $i<sizeof($users); $i++){
            // Mail::to($users[$i]->email)->send( new SendMarkDownMail($tasks, $users[$i]));
            SendEmail::dispatch($tasks,$users[$i]);
        }

        // End For Email
        return redirect()->back();
    }
}
