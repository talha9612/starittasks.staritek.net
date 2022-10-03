<?php

namespace App\Http\Controllers\Manager;

use App\CompanySetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class SettingController extends Controller
{
    public function index(){
        $setting = CompanySetting::where('user_id',Auth::user()->user_type)->with('ContactPerson')->first();
        return view('manager.setting',compact('setting'));
    }
}
