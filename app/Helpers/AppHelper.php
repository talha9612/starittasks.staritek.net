<?php
namespace App\Helpers;

use App\CompanySetting;
use App\ThemeSetting;
use App\User;
//use Auth;
use Illuminate\Support\Facades\Auth;
class AppHelper
{
    public static function instance()
    {
        return new AppHelper();
    }
    public function GetTheme(){
        $theme = ThemeSetting::where('user_id', Auth::user()->id)->first();
        return $theme;
    }
    public function CompanySettingAdmin(){
        $setting = CompanySetting::where('user_id',Auth::user()->id)->first();
        return $setting;
    }
    public function CompanySettingManager(){
        $id = Auth::user()->user_type;
        $setting = CompanySetting::where('user_id',$id)->first();
        return $setting;
    }
    public function CompanySettingUser(){
        $id = Auth::user()->user_type;
        $manager = User::where('id',$id)->first();
        $setting = CompanySetting::where('user_id',$manager->user_type)->first();
        return $setting;
    }
    public function CompanySettingCEO(){
        $id = Auth::user()->user_type;
        $setting = CompanySetting::where('user_id',$id)->first();
        return $setting;
    }
    public function CompanySettingForEmail(){
        $id = Auth::user()->user_type;
        $setting = CompanySetting::where('user_id',$id)->first();
        return $setting;
    }
}