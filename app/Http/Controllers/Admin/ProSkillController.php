<?php

namespace App\Http\Controllers\Admin;

use App\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProSkillController extends Controller
{
    public function index(){
        $skills = Skill::where('user_id',Auth::user()->id)->orwhere('user_id',Auth::user()->user_type)->get();
        return response()->json([
            'skills' => $skills,
        ]);
    }
    public function SaveSkill(Request $req){
        $skill = new Skill();
        $skill->name = $req->skillname;
        $skill->user_id = Auth::user()->id;
        $skill->save();
        return response()->json([
            "success"=>"Saved Successfully",
            "status"=>200
        ]);
    }
    public function DelProSkill(Request $req){
        $id =$req->id;
        $attr = Skill::find($id);
        $attr->delete();
        return response()->json([
            "success"=>"Deleted Successfully",
            "status"=>200
        ]);
    }
}
