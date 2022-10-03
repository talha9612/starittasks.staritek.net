<?php

namespace App\Http\Controllers\Admin;

use App\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProDepartmentController extends Controller
{
    public function index(){
        $departments = Designation::where('added_by',Auth::user()->id)->orwhere('added_by',Auth::user()->user_type)->get();
        return response()->json([
            'departments' => $departments,
        ]);
    }
    public function SaveDepartment(Request $req){
        $department = new Designation();
        $department->name = $req->departmentname;
        $department->added_by = Auth::user()->id;
        $department->save();
        return response()->json([
            "success"=>"Saved Successfully",
            "status"=>200
        ]);
    }
    public function DelProDepartment(Request $req){
        $id =$req->id;
        $attr = Designation::find($id);
        $attr->delete();
        return response()->json([
            "success"=>"Deleted Successfully",
            "status"=>200
        ]);
    }
}
