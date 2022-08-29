<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
use Auth;
use App\User;
use App\Designation;
use App\Skill;
use App\Task;
use App\ProjectAssign;
use App\ThemeSetting;
use Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class ManagerController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $projects = Project::where('project_head',$id)->orwhere('project_head',Auth::user()->id)->with('head','createproject','projectcatagory')->get();
        $users = User::where('user_type',$id)->where('role',3)->get();
        $user = User::where('team_member',$id)->where('role',3)->count();
        $project = Project::where('project_head',Auth::user()->id)->count();
        $project_ids = Project::where('project_head',Auth::user()->id)->get();
        $pro_ids = [];
        $pandding_tasks = 0;
        $pandding_tasks_complete = 0;
        for($i=0; $i<sizeof($project_ids); $i++){
            array_push($pro_ids,$project_ids[$i]->id);
        }
        for($i=0; $i<sizeof($pro_ids); $i++){
            $pandding_task = Task::where('project_id',$pro_ids[$i])->where('status','!=',4)->where('status','!=',5)->count();
            $pandding_task_com = Task::where('project_id',$pro_ids[$i])->where('status',5)->count();
            $pandding_tasks += $pandding_task;
            $pandding_tasks_complete += $pandding_task_com;
        }

        
        return view('manager.dashboard',compact('projects','users','project','user','pandding_tasks','pandding_tasks_complete'));
    }
    public function ProjectHeads(){
        $id = Auth::user()->id;
        $users = User::where('user_type',$id)->where('role',3)->get();
        return response()->json([
            'users'=>$users
        ]);
    }
    public function Team(){
        $id = Auth::user()->id;
        $users = User::where('user_type',$id)->orwhere('team_member',Auth::user()->id)->with('getusers')->get();
        $designations = Designation::where('added_by',$id)->orwhere('added_by',Auth::user()->user_type)->get();
        $skills = Skill::where('user_id',$id)->orwhere('user_id',Auth::user()->user_type)->get();

        return view('manager.team',compact('users','designations','skills'));
    }
    public function AddTeam(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->user_type = Auth::user()->id;
        $user->role = $request->role;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->department = $request->department;
        $user->skill = $request->skill;
        $user->team_member = Auth::user()->id;

        if($request->hasFile('image')){
            $avatar = $request->file('image');
            $random = Str::random(40);
            $filename =  $random.time().'.'.$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(public_path('/uploads/staf_images/'.$filename));
            
            $user->image = $filename;
            $user->save();
           }
        $user->save();
         // For Theme Setting
         $theme = new ThemeSetting();
         $theme->user_id = $user->id;
         $theme->theme_mode = 0;
         $theme->save();
         // Theme Setting End //
        return redirect()->back();
    }
    public function EditTeam(Request $req){
        $user = User::where('id',$req->id)->first();
        $manager_ids = [];
        $departments = [];
        $skills = [];
        $managers = User::where('user_type',$user->user_type)->get();
        for($i=0; $i<sizeof($managers); $i++){
        array_push($manager_ids,$managers[$i]->id);
        }
        for($i=0; $i<sizeof($manager_ids); $i++){
            $department = Designation::where('added_by',$manager_ids[$i])->get();
            $skill = Skill::where('user_id',$manager_ids[$i])->get();
            array_push($departments, $department);
            array_push($skills, $skill);
        }
       return view('manager.editteam',compact('user','departments','skills'));
    }
    public function UpdateTeam(Request $request){
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        if($request->password != null){
            $user->password = Hash::make($request->password);
        }else{}
        $user->role = $request->role;
        $user->department = $request->department;
        $user->skill = $request->skill;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        
        if($request->hasFile('image')){
            $avatar = $request->file('image');
            $filename = time().'.'.$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(public_path('/uploads/staf_images/'.$filename));
            
            $user->image = $filename;
            $user->save();
           }
        $user->save();
        return redirect('manager/users');
    }
    public function DeleteTeam(Request $req){
        $user = user::find($req->id);
        $project2 = ProjectAssign::where('user_id',$req->id)->get();
        if ($project2 != null) {
            foreach ($project2 as $post) {
                $post->delete();
            }
        }
        $user->delete();
        return back()->with('success','User Deleted Successfully!');
    }
}
