<?php

namespace App\Http\Controllers\User;

use App\CompanySetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index(){
        $user = User::where('id',Auth::user()->user_type)->first();
        $setting = CompanySetting::where('user_id',$user->user_type)->with('ContactPerson')->first();
        return view('user.setting',compact('setting'));
    }
}
