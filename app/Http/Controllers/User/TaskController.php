<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Task;
class TaskController extends Controller
{
    public function SingleTaskModel(Request $req){
        $task = Task::where('id',$req->task_id)->with('project','AssignTo','AssignBy','GetTaskCatagory')->first();
        return response()->json([
            'data'=>$task,
        ]);
    }
    public function SingleTaskComplete(Request $req){
        $task = Task::find($req->task_id);
        $task->status = 5;
        $task->save();
        return response()->json([
            'statusCode' => 200,
            'success'=>'Task Completed mark'
        ]);
    }
}
