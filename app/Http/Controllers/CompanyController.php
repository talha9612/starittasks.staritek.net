<?php

namespace App\Http\Controllers;

use Image;
use App\User;
use App\ThemeSetting;
use App\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class CompanyController extends Controller
{
    public function AddCompanyInfo(Request $request){
        // $encrypted = Crypt::encryptString('Hello world.');
        // dd($request->all());
        if($request->con_code == 'eyJpdiI6IjdtaTEvRVc5UjdPcWtRNUt'){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = '123456789';
            $user->address = $request->address;
            $user->password = Hash::make($request->password);
            $user->role = 1;
            $user->department = 1;
            $user->skill = 1;
            $user->gender = 1;
            $user->user_type = 0;
            $user->team_member = 0;
            $user->image = 'default.jpg';
            $user->save();
            // if($request->hasFile('image')){
            //     $avatar = $request->file('image');
            //     $filename = time().'.'.$avatar->getClientOriginalExtension();
            //     Image::make($avatar)->resize(300,300)->save(public_path('/uploads/staf_images/'.$filename));
            //     $user->image = $filename;
            //     $user->save();
            //    }
            $users = User::where('id',$user->id)->first();
            $users->user_type = $user->id;
            $users->team_member = $user->id;
            $users->save();

            // For Theme Setting
            $theme = new ThemeSetting();
            $theme->user_id = $user->id;
            $theme->theme_mode = 0;
            $theme->save();
            // Theme Setting End //

            $setting = new CompanySetting();
            $setting->name = $request->c_name;
            $setting->email = $request->c_email;
            $setting->address = 'Not Added';
            $setting->phone = $request->c_phone;
            $setting->logo = $request->c_image;
            $setting->user_id = $user->id;
            if($request->hasFile('c_image')){
                $avatar = $request->file('c_image');
                $filename = time().'.'.$avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(100,100)->save(public_path('/uploads/company_logos/'.$filename));
                $setting->logo = $filename;
                $setting->save();
            }
            $setting->save();
            return redirect('/login/');
        }else{
            return redirect()->back()->with('error','Your Conformation Code is Not Correct!');
        }
    }
    public function RegisterCompany(){
        return view('welcome');
    }
    public function ForLogin(Request $req){
        return view('login');

    }
    public function CheckEamil(Request $req){
        // dd($req->all());
        $user = User::where('email',$req->email)->count();
        return $user;
    }
}
