<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ThemeSetting;
use Auth;
class ThemeSettingController extends Controller
{
    public function index(Request $req){
        $theme = ThemeSetting::find($req->status_id);
        $theme->theme_mode = $req->status;
        $theme->save();
        return response()->json(['success'=>'Theme Setting Updated Successfully!']);
    }
    public function TopHeader(Request $req){
        $theme = ThemeSetting::find($req->status_id);
        $theme->header_dark = $req->status;
        $theme->save();
        return response()->json(['success'=>'Theme Setting Updated Successfully!']);
    }
    public function MinSideBar(Request $req){
        $theme = ThemeSetting::find($req->status_id);
        $theme->min_sidebar_dark = $req->status;
        $theme->save();
        return response()->json(['success'=>'Theme Setting Updated Successfully!']);
    }
    public function SideBar(Request $req){
        $theme = ThemeSetting::find($req->status_id);
        $theme->sidebar_dark = $req->status;
        $theme->save();
        return response()->json(['success'=>'Theme Setting Updated Successfully!']);
    }
    public function BoxShadow(Request $req){
        $theme = ThemeSetting::find($req->status_id);
        $theme->box_shadow = $req->status;
        $theme->save();
        return response()->json(['success'=>'Theme Setting Updated Successfully!']);
    }
}
