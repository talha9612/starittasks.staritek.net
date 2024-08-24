<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProjectCatagory;
// use Auth;
use Illuminate\Support\Facades\Auth;
class ProCatagoryController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $catagories = ProjectCatagory::where('user_id',$id)->get();
        return response()->json([
            'catagories' => $catagories,
        ]);
    }
    public function SaveCatagory(Request $req){
        $catagory = new ProjectCatagory();
        $catagory->name = $req->catagoryname;
        $catagory->user_id = Auth::user()->id;
        $catagory->save();
        return response()->json([
            "success"=>"Saved Successfully",
            "status"=>200
        ]);
    }
    public function DelProCategory(Request $req){
        $id =$req->id;
        $attr = ProjectCatagory::find($id);
        $attr->delete();
        return response()->json([
            "success"=>"Deleted Successfully",
            "status"=>200
        ]);
    }
}
