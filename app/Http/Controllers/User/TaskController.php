<?php

namespace App\Http\Controllers\User;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        // dd($request->file('images'));
        $images_array =[];
        $task = Task::find($request->task_id);
        $task->description = $request->desc;
        $task->progress = $request->progress;
        if($request->progress == 'onehundred'){
            $task->status = 5;
        }
        
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
        $task->save();
        return redirect()->back();
    }
}
