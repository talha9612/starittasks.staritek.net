<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\ProjectAssign;
use App\ProjectCatagory;
use Auth;
class ProjectController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $project_lists = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',Auth::user()->id)->get();
        $users = User::where('user_type',$id)->where('role',2)->get();
        $user =[Auth::user()->id];
        $projects =[];
        for($i=0; $i<count($users); $i++){
            array_push($user, $users[$i]->id);
        }
        for($i=0; $i<sizeof($user); $i++){
            $project = Project::with('head','createproject','projectcatagory','assign_project.GetUsers')->where('create_project',$user[$i])->get();
            array_push($projects, $project);
        }
        
        return view('admin.viewprojects',compact('projects','users','project_lists'));
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
        $users = User::where('user_type',$id)->where('role',2)->get();
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
        $project2 = ProjectAssign::where('project_id',$req->id)->get();
        $project->delete();
        if ($project2 != null) {
            foreach ($project2 as $post) {
                $post->delete();
            }
        }
        return back()->with('success','Project Deleted Successfully!');
    }
}
