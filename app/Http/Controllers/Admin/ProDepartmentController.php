<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ProDepartmentController extends Controller
{
    public function index(){
        $departments = Designation::where('added_by',Auth::user()->id)->orwhere('added_by',Auth::user()->user_type)->get();
       //dd($departments);
        return response()->json([
            'departments' => $departments,
        ]);
    }
    // public function SaveDepartment(Request $req){
    //     $department = new Department();
    //     $department->name = $req->departmentname;
    //     $department->added_by = Auth::user()->id;
    //     $department->save();
    //     return response()->json([
    //         "success"=>"Saved Successfully",
    //         "status"=>200
    //     ]);
    // }
    public function SaveDepartment(Request $req) {
        // Validate the request data
        $validatedData = $req->validate([
            'departmentname' => 'required|string|max:255',
        ]);
    
        try {
            // Create a new department
            $department = new Designation();
            $department->name = $validatedData['departmentname'];
            $department->added_by = Auth::user()->id; // Assuming 'user_id' is the correct field
            $department->save();
    
            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Department saved successfully',
                'status' => 200
            ]);
    
        } catch (\Exception $e) {
            // Log the exception and return an error response
            Log::error('Error saving department: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the department.',
                'status' => 500
            ]);
        }
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
