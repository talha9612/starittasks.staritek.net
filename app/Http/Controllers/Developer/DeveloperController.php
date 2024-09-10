<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    
    
    
}
