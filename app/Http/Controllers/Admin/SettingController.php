<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\CompanySetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Image;

class SettingController extends Controller
{
    public function index(){
        $setting = CompanySetting::where('user_id',Auth::user()->id)->first();
        $users = User::where('user_type',Auth::user()->id)->where('role',2)->get();
        return view('admin.setting',compact('setting','users'));
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
