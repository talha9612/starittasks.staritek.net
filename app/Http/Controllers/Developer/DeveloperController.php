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
        $req->validate([
            'user_id' => 'required|integer',
            'status' => 'required|integer',
        ]);

        $userId = $req->input('user_id');
        $status = $req->input('status');

        $record = DB::table('company_setting')->where('user_id', $userId)->first();

        if ($record) {
            $updated = DB::table('company_setting')
                ->where('user_id', $userId)
                ->update(['status' => $status]);

            if ($updated) {
                return response()->json(['success' => 'Status Changed Successfully!']);
            } else {
                return response()->json(['error' => 'Failed to update status.'], 500);
            }
        } else {
            return response()->json(['error' => 'Record not found.'], 404);
        }
    }

    return response()->json(['error' => 'Invalid request.'], 400);
}
    
    
    

    

}
