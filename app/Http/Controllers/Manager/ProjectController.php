<?php

namespace App\Http\Controllers\Manager;

use Auth;
use App\Task;
use App\User;
use App\Project;
use Carbon\Carbon;
use App\ProjectAssign;
use App\ProjectCatagory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $projects = Project::with('head','createproject','projectcatagory')->where('create_project',Auth::user()->id)->orwhere('project_head',Auth::user()->id)->get();
        $users = User::where('user_type',$id)->orwhere('team_member',$id)->where('role',3)->get();
        
        $assigns = ProjectAssign::where('manager_id',$id)->with('GetUsers')->get();
        return view('manager.projects',compact('projects','users','assigns'));
    }
    public function AddProject(Request $req){
        $id = Auth::user()->id;
        $project = new Project();
        $project->project_name = $req->name;
        $project->project_summary = $req->summary;
        $project->project_head = $req->head;
        $project->start_date = $req->start_date;
        $project->deadline = $req->end_date;
        $project->category_id = $req->catagory;
        $project->create_project = $id;
        $project->status = $req->status;
        $project->save();
        // For Assign Project Himself
        $assign = new ProjectAssign();
        $assign->project_id = $project->id;
        $assign->user_id = $id;
        $assign->manager_id = $id;
        $assign->save();

        return back()->with('success','Add Project successfully!');
    }
    public function AssignProject(Request $req){
        $check = ProjectAssign::where('user_id',$req->user_id)->where('project_id',$req->project_id)->count();

        if(!empty($check)){
            return back()->with('error','This is User Already Assign This Prject!');
        }else{
            $status = Project::find($req->project_id);
            if($status->status == 1){
                $status->status = 2;
                $status->save();
            }else{}
            $project = new ProjectAssign();
            $project->user_id = $req->user_id;
            $project->project_id = $req->project_id;
            $project->manager_id = Auth::user()->id;
            $project->save();
            return back()->with('success','Assign Project successfully!');
        }
       
    }
    public function EditProject(Request $req){
        $project = Project::where('id',$req->id)->with('projectcatagory')->first();
        $catagories = ProjectCatagory::where('user_id',Auth::user()->id)->orwhere('user_id',Auth::user()->user_type)->get();
        return view('manager.editproject',compact('project','catagories'));
    }
    public function DeleteProject(Request $req){
        $project = Project::find($req->id);
        $tasks = Task::where('project_id',$req->id)->get();
        for ($i=0; $i <sizeof($tasks) ; $i++) { 
            $task = $tasks[$i];
            $task->delete();
        }
        $project2 = ProjectAssign::where('project_id',$req->id)->get();
        $project->delete();
        if ($project2 != null) {
            foreach ($project2 as $post) {
                $post->delete();
            }
        }
        return back()->with('success','Project Deleted Successfully!');
    }
    public function UpdatedProject(Request $req){
        $project = Project::find($req->id);
        $pre_value = $project->project_complete;
        $project->project_name = $req->name;
        $project->project_summary = $req->summary;
        $project->project_head = $req->head;
        $project->start_date = $req->start_date;
        $project->deadline = $req->end_date;
        $project->category_id = $req->catagory;
        $project->create_project = $req->id;
        $project->status = $req->status;
        $project->project_complete = $pre_value;
        $project->save();
        return redirect('/manager/projects')->with('success','Project Updated Successfully!');
    }
}
