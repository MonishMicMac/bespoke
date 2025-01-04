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

        $vendors = $vendors->where('action','0')->get();
    }

    // Pass data to the view
    return view('vendors.index', compact('vendors'));
}


public function edit($id)
{
    $vendor = VendorLogin::find($id);
    if (!$vendor) {
        return redirect()->route('vendor.view')->with('error', 'Vendor not found.');
    }

    return view('vendors.edit', compact('vendor'));
}

public function update(Request $request, $id)
{
    $vendor = VendorLogin::find($id);
    if (!$vendor) {
        return redirect()->route('vendor.view')->with('error', 'Vendor not found.');
    }

    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:vendor_login,email,' . $id,
        'mobile_no' => 'required|string|max:15|unique:vendor_login,mobile_no,' . $id,
    ]);

    $vendor->update($validated);

    return redirect()->route('vendor.view')->with('success', 'Vendor updated successfully.');
}

public function destroy($id)
{
    $vendor = VendorLogin::find($id);
    if (!$vendor) {
        return redirect()->route('vendor.view')->with('error', 'Vendor not found.');
    }

    $vendor->update(['action' => '1']);
    return redirect()->route('vendor.view')->with('success', 'Vendor deleted successfully.');
}

public function updateStatus(Request $request)
{
    $request->validate([
        'id' => 'required|exists:vendor_login,id',
        'approval_status' => 'required|in:1,2',
    ]);

    $vendor = VendorLogin::find($request->id);
    $vendor->update(['approval_status' => $request->approval_status]);

    $message = $request->approval_status == 1 ? 'Vendor approved successfully' : 'Vendor declined successfully';

    return response()->json(['status' => 'success', 'message' => $message]);
}


    
}
