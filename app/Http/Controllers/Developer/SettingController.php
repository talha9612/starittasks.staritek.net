<?php

namespace App\Http\Controllers\Developer;

use App\User;
use App\CompanySetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    public function index(){
        $setting = CompanySetting::where('user_id',Auth::user()->user_type)->first();
        $users = User::where('id',Auth::user()->user_type)->where('role',1)->get();
        return view('developer.setting',compact('setting','users'));
    }
    public function UpdateSetting(Request $request){
        $setting = CompanySetting::where('id',$request->id)->first();
        $setting->name = $request->name;
        $setting->email = $request->email;
        $setting->address = $request->address;
        $setting->phone = $request->phone;
        $setting->mobile = $request->mobile;
        $setting->web_url = $request->web_url;
        $setting->contact_person = $request->contact_person;
        $setting->fax = $request->fax;
        if($request->hasFile('logo')){
            $avatar = $request->file('logo');
            $filename = time().'.'.$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(100,100)->save(public_path('/uploads/company_logos/'.$filename));
            $setting->logo = $filename;
            $setting->save();
           }
        $setting->save();
        return redirect()->back();
    }
}
