<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\TaskCatagory;
use Illuminate\Http\Request;
use Auth;
class TaskCataController extends Controller
{
    public function TaskCatagory(){
        $id = Auth::user()->id;
        $catagories = TaskCatagory::where('created_by',$id)->get();
        return response()->json([
            'catagories' => $catagories,
        ]);
    }
    public function AddTaskCatagory(Request $req){
        $catagory = new TaskCatagory();
        $catagory->category_name = $req->catagoryname;
        $catagory->created_by = Auth::user()->id;
        $catagory->save();
        return response()->json([
            "success"=>"Saved Successfully",
            "status"=>200
        ]);
    }
    public function DeleteTaskCatagory(Request $req){
        $id =$req->id;
        $attr = TaskCatagory::find($id);
        $attr->delete();
        return response()->json([
            "success"=>"Deleted Successfully",
            "status"=>200
        ]);
    }
}
