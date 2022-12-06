<?php

namespace App\Http\Controllers\User;

use App\Task;
use App\User;
use App\Project;
use App\ProjectAssign;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use App\Mail\SendMarkDownMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Spatie\Activitylog\Models\Activity;

class TaskController extends Controller
{
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
    public function SingleTaskComplete(Request $request){
        // dd($request->all());
        $images_array =[];
        $task = Task::find($request->task_id);
        $task->description = $request->desc;
        $task->progress = $request->progress;
        if($request->progress =='five'){
            $task->progress_int = 5;
        }else if($request->progress =='twentyfive'){
            $task->progress_int = 25;
        }else if($request->progress =='fifty'){
            $task->progress_int = 50;
        }else if($request->progress =='seventyfive'){
            $task->progress_int = 75;
        }else if($request->progress =='onehundred'){
            $task->progress_int = 100;
        }else if($request->progress ==null){
            $task->progress_int = 0;
        }
        if($request->progress == 'onehundred'){
            $task->status = 5;
        }
        // Project Complition Calculation
            $privous_progress = $task->progress_int;
            $project = Project::where('id',$task->project_id)->first();
            $tasks = Task::where('project_id',$task->project_id)->get();
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
        // dd($project_com);
            $project->save();
        // Calculation end //
        if($request->hasFile('images')){
            $images = $request->file('images');
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
           // For Email
           $tasks = Task::where('id',$request->task_id)->with('project','AssignBy')->first();
        
           // Get Users For Email ////////
           $assign_projects = ProjectAssign::where('project_id',$tasks->project_id)->get();
           $users = [];
           $user1 = User::where('id',$tasks->user_id)->first();
           $user2 = User::where('id',$tasks->created_by)->first();
           $user3s = User::where('user_type',Auth::user()->user_type)->where('role',4)->get();
           foreach($user3s as $user){
               if($tasks->task_view_ceo === 1){
                   array_push($users,$user);
               }
           }
           array_push($users,$user1);
           array_push($users,$user2);
           for($i=0; $i<sizeof($assign_projects); $i++){
               $user = User::where('id',$assign_projects[$i]->user_id)->first();
               if($user->email !== $user1->email){
                   array_push($users, $user);
               }
           }
           // End Get Users For Email ///////
        //    for($i=0; $i<sizeof($users); $i++){
        //        // Mail::to($users[$i]->email)->send( new SendMarkDownMail($tasks, $users[$i]));
        //        $subject = 'truly awesome subject line';
        //        SendEmail::dispatch($tasks,$users[$i],$subject);
        //    }
           // End For Email
        $task->save();
        // return redirect()->back();
    }
}
