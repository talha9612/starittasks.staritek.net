<?php

namespace App\Http\Controllers\CEO;

use App\User;
use App\Skill;
use App\Designation;
use App\ThemeSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class ManagerController extends Controller
{
    public function index(){
        $id = Auth::user()->user_type;
        $users = User::where('user_type',$id)->with('getusers')->get();
        $designations = Designation::where('added_by',$id)->get();
        $skills = Skill::where('user_id',$id)->get();
        return view('ceo.addmanager',compact('users','designations','skills'));
    }
    public function AddManager(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        // $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->user_type = Auth::user()->id;
        $user->role = 3;
        $user->department = $request->department;
        $user->skill = 0;
        // $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->team_member = Auth::user()->id;
        if($request->hasFile('image')){
            $avatar = $request->file('image');
            $filename = time().'.'.$avatar->getClientOriginalExtension();
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
    public function ChangeStatus(Request $req){
        if($req->ajax()){
            $db_cata = User::find($req->status_id);
            $db_cata->status = $req->status;
            $db_cata->save();
            return response()->json(['success'=>'Status Changed Successfully!']);
         }
    }
    public function EditManager(Request $req){
       
        $user = User::where('id',$req->id)->first();
        $manager_ids = [];
        $departments = [];
        $skills = [];
        $managers = User::where('user_type',Auth::user()->id)->get();
        for($i=0; $i<sizeof($managers); $i++){
        array_push($manager_ids,$managers[$i]->id);
        }
        for($i=0; $i<sizeof($manager_ids); $i++){
            $department = Designation::where('added_by',$manager_ids[$i])->get();
            $skill = Skill::where('user_id',$manager_ids[$i])->get();
            array_push($departments, $department);
            array_push($skills, $skill);
        }
       return view('ceo.editmanager',compact('user','departments','skills'));
    }
    public function SelectTeamManager(){
        $users = User::where('user_type',Auth::user()->id)->where('role',2)->get();
        return response()->json([
            'users'=>$users
        ]);
    }
    public function DeleteUser(Request $req){
        $user = user::find($req->id);
        $user->delete();
        return back()->with('success','User Deleted Successfully!');
    }
    public function UpdateManager(Request $request){
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
        return redirect('ceo/manager');
    }
    public function AddCEO(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        // $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->user_type = Auth::user()->id;
        $user->role = 4;
        $user->department = $request->department;
        $user->skill = 0;
        // $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->team_member = Auth::user()->id;
        if($request->hasFile('image')){
            $avatar = $request->file('image');
            $filename = time().'.'.$avatar->getClientOriginalExtension();
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
}
