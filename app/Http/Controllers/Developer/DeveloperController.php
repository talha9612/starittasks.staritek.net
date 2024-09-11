<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeveloperController extends Controller
{
    public function index()
    {
        return view('developer.dashboard');
    }


    public function Team()
    {
        // Retrieve distinct user_ids from the company_setting table
        $userIds = DB::table('company_setting')
                     ->select('user_id')
                     ->distinct()
                     ->pluck('user_id');
    
        // Retrieve additional information for each user_id
        $userDetails = DB::table('company_setting') // Adjust table name if different
                         ->whereIn('user_id', $userIds)
                         ->select('id', 'name', 'phone', 'email', 'address', 'status')
                         ->get();

        $allcompanies = $userDetails->count();
    
        // Pass the userDetails variable to the view
        return view('developer.dashboard', compact('userDetails' , 'allcompanies'));
    }
    
    public function updateStatus(Request $req)
    {
        if ($req->ajax()) {
            // Validate request data
            $req->validate([
                'user_id' => 'required|integer',
                'status' => 'required|integer',
            ]);
    
            // Find the record in the company_setting table
            $record = DB::table('company_setting')->where('user_id', $req->user_id)->first();
            
            if ($record) {
                // Update the status
                DB::table('company_setting')
                    ->where('user_id', $req->user_id)
                    ->update(['status' => $req->status]);
    
                return response()->json(['success' => 'Status Changed Successfully!']);
            } else {
                return response()->json(['error' => 'Record not found.'], 404);
            }
        }
    
        return response()->json(['error' => 'Invalid request.'], 400);
    }
    
    
    

    

}
