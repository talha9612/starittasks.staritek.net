<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProjectCatagory;
use Auth;
class ProCatagoryController extends Controller
{
    public function index(){
        $catagories = ProjectCatagory::where('user_id',Auth::user()->id)->orwhere('user_id',Auth::user()->user_type)->get();
        return response()->json([
            'catagories' => $catagories,
        ]);
    }
    public function SaveCategory(Request $req){
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
