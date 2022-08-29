<?php
namespace App\Helpers;
use App\ThemeSetting;
use Auth;
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
}