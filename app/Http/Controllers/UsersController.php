<?php

namespace App\Http\Controllers;

use App\Models\UserLogin;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function view(Request $request)
    {
        // Retrieve filtering inputs
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $approvalStatus = $request->input('approve_status');
    
        // Query the database only if filters are applied
        $users = null; // Default value if no filters are applied
    
       
        if ($fromDate || $toDate || $approvalStatus !== null) {
            $users = UserLogin::query();
    
            if ($fromDate) {
                $users->whereDate('created_at', '>=', $fromDate);
            }
    
            if ($toDate) {
                $users->whereDate('created_at', '<=', $toDate);
            }
    
            if ($approvalStatus !== null) {
                $users->where('approval_status', $approvalStatus);
            }
    
            $users = $users->get();
         
        }
    
        // Pass data to the view
        return view('users.index', compact('users'));
    }
   
}
