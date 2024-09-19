<?php

namespace App\Http\Controllers\Developer;

use App\User;
use App\Skill;
use App\Designation;
use App\CompanySetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index(){
        $user = User::where('id',Auth::user()->id)->with('getdepartment','getskill')->first();
        $company = CompanySetting::where('user_id',Auth::user()->user_type)->first();
        $manager_ids = [];
        $departments = [];
        $skills = [];
        // $managers = User::where('user_type',Auth::user()->id)->get();
        // for($i=0; $i<sizeof($managers); $i++){
        // array_push($manager_ids,$managers[$i]->id);
        // }
        // for($i=0; $i<sizeof($manager_ids); $i++){
        //     $department = Designation::where('added_by',$manager_ids[$i])->get();
        //     $skill = Skill::where('user_id',$manager_ids[$i])->get();
        //     array_push($departments, $department);
        //     array_push($skills, $skill);
        // }
        return view('developer.profile',compact('user','company'));
    }
    public function UpdateProfile(Request $request){
//        dd($request->all());
        $user = User::where('id',$request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->role = 5;
        $user->department = 0;
        $user->dob = $request->dob;
        $user->skill = 0;
        $user->gender = $request->gender;
        if($request->hasFile('image')){
            $avatar = $request->file('image');
            $filename = time().'.'.$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(public_path('/uploads/staf_images/'.$filename));
            $user->image = $filename;
            $user->save();
           }

        $user->save();
        return redirect()->back();
    }
    public function CheckEamil(Request $req){
        $user = User::where('email',$req->email)->count();
        return $user;
    }
    public function CheckPassword(Request $req){
       if(Hash::check( $req->password,Auth::user()->password)){
        return 1;
       }else{
        return 0;
       }
    }
    public function UpdatePassword(Request $req){
        if(Hash::check( $req->old_password,Auth::user()->password)){
            if($req->new_password !== $req->confirm_passowrd){
                return redirect()->back()->with('error','Your New And Confirm Password Not Match!');
            }else{
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($req->new_password);
                $user->save();
                return redirect()->back()->with('success','Your Password is Updated!');
            }
        }else{
            return redirect()->back()->with('error','Your Old Password Incorrect!');
        }
    }
}
