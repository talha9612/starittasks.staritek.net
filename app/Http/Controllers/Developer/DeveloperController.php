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
                         ->select('user_id', 'name', 'phone', 'email', 'address', 'status')
                         ->get();

        $allcompanies = $userDetails->count();
    
        // Pass the userDetails variable to the view
        return view('developer.dashboard', compact('userDetails' , 'allcompanies'));
    }
    
    public function Status(Request $req)
    {
        try {
            if ($req->ajax()) {
                $req->validate([
                    'user_id' => 'required|integer',
                    'status' => 'required|integer|in:0,1',
                ]);
    
                $userId = $req->input('user_id');
                $status = $req->input('status');
    
                Log::info("Received request to update status: User ID = $userId, Status = $status");
    
                // Check if the record exists in company_setting
                $recordExists = DB::table('company_setting')->where('user_id', $userId)->exists();
    
                if ($recordExists) {
                    // Update company_setting table
                    $companySettingUpdated = DB::table('company_setting')
                        ->where('user_id', $userId)
                        ->update(['status' => $status]);
    
                    Log::info("Company Setting Updated: $companySettingUpdated");
    
                    // Check if update affected any rows
                    if ($companySettingUpdated === 0) {
                        Log::error("Failed to update company_setting table: No rows affected. User ID = $userId, Status = $status");
                        return response()->json(['error' => 'Failed to update company setting.'], 500);
                    }
    
                    // Update users table
                    $userUpdated = DB::table('users')
                        ->where('user_type', $userId) // Ensure 'user_type' is correct
                        ->update(['status' => $status]);
    
                    Log::info("Users Table Updated: $userUpdated");
    
                    if ($userUpdated === 0) {
                        Log::error("Failed to update users table: No rows affected. User ID = $userId, Status = $status");
                        return response()->json(['error' => 'Failed to update user status.'], 500);
                    }
    
                    return response()->json(['success' => 'Status updated successfully!']);
                } else {
                    Log::error("Record not found in company_setting table. User ID = $userId");
                    return response()->json(['error' => 'Record not found.'], 404);
                }
            }
    
            Log::error("Invalid request.");
            return response()->json(['error' => 'Invalid request.'], 400);
        } catch (\Exception $e) {
            Log::error("Exception: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
    
}