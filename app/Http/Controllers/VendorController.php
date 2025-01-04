<?php

namespace App\Http\Controllers;

use App\Models\VendorLogin;
use Illuminate\Http\Request;

class VendorController extends Controller
{
   
    public function view(Request $request)
{
    // Retrieve filtering inputs
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');
    $approvalStatus = $request->input('approve_status');

    // Query the database only if filters are applied
    $vendors = null; // Default value if no filters are applied

    if ($fromDate || $toDate || $approvalStatus !== null) {
        $vendors = VendorLogin::query();

        if ($fromDate) {
            $vendors->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $vendors->whereDate('created_at', '<=', $toDate);
        }

        if ($approvalStatus !== null) {
            $vendors->where('approval_status', $approvalStatus);
        }

        $vendors = $vendors->get();
    }

    // Pass data to the view
    return view('vendors.index', compact('vendors'));
}

    
}
