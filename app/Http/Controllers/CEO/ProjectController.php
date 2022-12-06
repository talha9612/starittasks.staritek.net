<?php

namespace App\Http\Controllers\CEO;

use App\Task;
use App\User;
use App\Project;
use App\ProjectAssign;
use App\ProjectCatagory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $projects = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',Auth::user()->user_type)->get();
        $users = User::where('user_type',$id)->where('role',3)->get();

        // $user =[Auth::user()->id];
        // $projects =[];
        // for($i=0; $i<count($users); $i++){
        //     array_push($user, $users[$i]->id);
        // }
        // for($i=0; $i<sizeof($user); $i++){
        //     $project = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',$user[$i])->get();
        //     array_push($projects, $project);
        // }
          
        return view('ceo.viewprojects',compact('projects','users'));
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

        $get_project = Project::where('project_name',$req->name)->where('project_head',$req->head)->first();
        $assign_project = new ProjectAssign();
        $assign_project->manager_id = $get_project->project_head;
        $assign_project->user_id = $get_project->project_head;
        $assign_project->project_id = $get_project->id;
        $assign_project->save();
        
        return redirect()->back();
    }
    public function ProjectEdit(Request $req){
        $id = Auth::user()->id;
        $project = Project::where('id',$req->id)->with('projectcatagory')->first();
        $users = User::where('team_member',$id)->where('role',3)->get();
        $catagories = ProjectCatagory::where('user_id',Auth::user()->id)->orwhere('user_id',Auth::user()->user_type)->get();
        return view('admin.editproject',compact('project','catagories','users'));
    }
    public function UpdateProject(Request $req){
        $project = Project::find($req->id);
        $project->project_name = $req->name;
        $project->project_summary = $req->summary;
        $project->project_head = $req->head;
        $project->start_date = $req->start_date;
        $project->deadline = $req->end_date;
        $project->category_id = $req->catagory;
        $project->create_project = Auth::user()->id;
        $project->status = $req->status;
        $project->save();
        return redirect('/admin/projects')->with('success','Project Updated Successfully!');
    }
    public function ProjectDelete(Request $req){
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
    public function AssignProject(Request $req){
        $checks = ProjectAssign::where('project_id',$req->project_id)->get();
        
        foreach ($checks as $key => $check) {
            $check->delete();
        }
        $users = $req->user_id;
        if(is_array($users)){
            
            for ($i=0; $i <sizeof($users) ; $i++) {

                $check = ProjectAssign::where('user_id',$users[$i])->where('project_id',$req->project_id)->count();
                if($check != 0){
                    continue;
                }else{
                    $status = Project::find($req->project_id);
                    if($status->status == 1){
                        $status->status = 2;
                        $status->save();
                    }else{}
                    $project = new ProjectAssign();
                    $project->user_id = $users[$i];
                    $project->project_id = $req->project_id;
                    $project->manager_id = Auth::user()->id;
                    $project->save();
                }
            }
        }else{
            return back()->with('error','Please First Select Project and Users!');
        }
       
        return back()->with('success','Project Assigned successfully!');
    }
    public function GetChangeProjectAssign(Request $req){
        $datas = ProjectAssign::where('project_id',$req->id)->get();
        return response()->json(['users'=>$datas]);
    }
}
