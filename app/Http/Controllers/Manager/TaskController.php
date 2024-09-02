<?php

namespace App\Http\Controllers\Manager;

use App\Task;
use App\User;
use App\Skill;
use App\Project;
use App\TaskCatagory;
use App\ProjectAssign;
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
    public function AddTask(Request $req)
    {
        $id = Auth::user()->id; // ID of the user creating the task
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
    
        // Save the task
        $task->save();
    
        // Ensure the user is assigned to the project
        $projectId = $req->project_id;
        $userId = $req->assign_to;
        $managerId = $id; // ID of the user creating the task as manager
    
        // Check if the user is already assigned to the project
        $projectAssign = ProjectAssign::where('project_id', $projectId)
                                      ->where('user_id', $userId)
                                      ->first();
    
        if (!$projectAssign) {
            // Add the user to the project if they are not already assigned
            ProjectAssign::create([
                'project_id' => $projectId,
                'user_id' => $userId,
                'manager_id' => $managerId, // Set manager_id to the user creating the task
            ]);
        }
    
        // Project Completion Calculation
        $project = Project::find($projectId);
        $tasks = Task::where('project_id', $projectId)->get();
        $NumberOfTasks = $tasks->count();
        
        $TasksInProjectNum = (100 / ($NumberOfTasks + 1));
    
        // Remove Previous added Value Into Project Progress Bar
        $project_com = 0;
        foreach ($tasks as $taskInProject) {
            if ($project->project_complete > 0) {
                $pproject_progress = ($taskInProject->progress_int * $TasksInProjectNum) / 100;
                $project_com += $pproject_progress;
            }
        }
    
        // Add New Task Progress
        $task_progress = intval($task->progress_int);
        $project_progress = ($task_progress * $TasksInProjectNum) / 100;
        $project_com += $project_progress;
        $project->project_complete = $project_com;
        $project->save();
    
        // Send Email
        $taskDetails = Task::where('id', $task->id)
                            ->with('project', 'AssignBy')
                            ->first();
        $user = User::find($task->user_id);
        Mail::to($user->email)->send(new SendMarkDownMail($taskDetails, $user));
    
        return redirect()->back()->with('success', 'Task Added Successfully!');
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
    public function ShowTaskDetail(Request $req){
        
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
        return view('manager.taskdetails',compact('left_days','pending_tasks','complete_task','task','backups','users'));
    }
}
