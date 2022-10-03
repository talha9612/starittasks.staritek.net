<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\TaskCatagory;
use Illuminate\Http\Request;
use Auth;
class TaskCategoryController extends Controller
{
    public function index(){
        $catagories = TaskCatagory::where('created_by',Auth::user()->id)->orwhere('created_by',Auth::user()->user_type)->get();
        return response()->json([
            'catagories' => $catagories,
        ]);
    }
    public function AddCategory(Request $req){
        $catagory = new TaskCatagory();
        $catagory->category_name = $req->catagoryname;
        $catagory->created_by = Auth::user()->id;
        $catagory->save();
        return response()->json([
            "success"=>"Saved Successfully",
            "status"=>200
        ]);
    }
    public function DelProCategory(Request $req){
        $id =$req->id;
        $attr = TaskCatagory::find($id);
        $attr->delete();
        return response()->json([
            "success"=>"Deleted Successfully",
            "status"=>200
        ]);
    }
}
