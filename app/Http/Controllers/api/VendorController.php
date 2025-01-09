<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VendorLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;  // Import the Validator facade

class VendorController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request using Validator facade with unique rule
        $validator = Validator::make($request->all(), [
            'shop_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:15|unique:vendor_login,mobile_no', 
            'email' => 'required|email|unique:vendor_login,email',
            'password' => 'required|string|min:8',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return validation errors as a response
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]); // 400 for bad request
        }

        // Create the vendor login entry
        $vendor = VendorLogin::create([
            'shop_name' => $request->shop_name,
            'username' => $request->username,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'password' => $request->password, // Hash the password for storage
        ]);

        // Return the newly created vendor as a response
        return response()->json(['message' => 'Vendor created successfully', 'data' => $vendor]);
    }

    public function update(Request $request, $id)
    {
        // Find the vendor by ID
        $vendor = VendorLogin::find($id);

        // Check if the vendor exists
        if (!$vendor) {
            return response()->json(['message' => 'Vendor not found'], 404);
        }

        // Initialize validation rules
        $validationRules = [];

        // If 'email' is provided, validate it
        if ($request->has('email')) {
            $validationRules['email'] = 'required|email|unique:vendor_login,email,' . $id; // Ignore current email
        }

        // If 'password' is provided, validate it
        if ($request->has('password')) {
            $validationRules['password'] = 'required|string|min:8';
        }

        // If 'mobile' is provided, validate it
        if ($request->has('mobile_no')) {
            $validationRules['mobile_no'] = 'required|string|max:15|unique:vendor_login,mobile_no,' . $id; // Ignore current mobile
        }

        // Perform validation
        $validator = Validator::make($request->all(), $validationRules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        // If 'email' is provided, update it
        if ($request->has('email')) {
            $vendor->email = $request->email;
        }

        // If 'password' is provided, hash and update it
        if ($request->has('password')) {
            $vendor->password = $request->password;
        }

        // If 'username' is provided, update it
        if ($request->has('username')) {
            $vendor->username = $request->username;
        }

        // If 'mobile_no' is provided, update it
        if ($request->has('mobile_no')) {
            $vendor->mobile_no = $request->mobile_no;
        }

        // If 'shop_name' is provided, update it
        if ($request->has('shop_name')) {
            $vendor->shop_name = $request->shop_name;
        }

        // If 'gst_no' is provided, update it
        if ($request->has('gst_no')) {
            $vendor->gst_no = $request->gst_no;
        }

        // If 'pan_no' is provided, update it
        if ($request->has('pan_no')) {
            $vendor->pan_no = $request->pan_no;
        }

        // If 'address' is provided, update it
        if ($request->has('address')) {
            $vendor->address = $request->address;
        }

        // If 'pincode' is provided, update it
        if ($request->has('pincode')) {
            $vendor->pincode = $request->pincode;
        }

        // If 'approval_status' is provided, update it
        if ($request->has('approval_status')) {
            $vendor->approval_status = $request->approval_status;
        }

        // If 'is_customization' is provided, update it
        if ($request->has('is_customization')) {
            $vendor->is_customization = $request->is_customization;
        }

        // If 'in_designer' is provided, update it
        if ($request->has('in_designer')) {
            $vendor->in_designer = $request->in_designer;
        }

        // If 'description' is provided, update it
        if ($request->has('description')) {
            $vendor->description = $request->description;
        }

        // Save the updated vendor
        $vendor->save();

        return response()->json(['message' => 'Vendor updated successfully', 'data' => $vendor], 200);
    }

    public function login(Request $request){
      
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // Find the vendor by email
        $vendor = VendorLogin::where('email', $request->email)->where('password',$request->password)->first();
    
        // Check if the vendor exists
        if (!$vendor) {
            return response()->json(['message' => 'Vendor not found'], 404);
        }
    

    
        // If successful, you can return some kind of success response, e.g., a token or vendor data
        return response()->json(['message' => 'Login successful', 'vendor' => $vendor], 200);
    }
    
}
