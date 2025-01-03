<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;  // Import the Validator facade

class UsersController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request using the Validator facade
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'mobile' => 'required|string|max:15|unique:user_login,mobile',
            'email' => 'required|email|unique:user_login,email',
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

        // Create a new user login entry
        $user = UserLogin::create([
            'username' => $request->username,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => $request->password, // Hash the password for storage
        ]);

        // Return the newly created user as a response
        return response()->json(['message' => 'User created successfully', 'data' => $user]);
    }
     public function update(Request $request, $id)
    {
  
        // Find the user by ID
        $user = UserLogin::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Initialize validation rules
        $validationRules = [];

        // If 'email' is provided, validate it
        if ($request->has('email')) {
            $validationRules['email'] = 'required|email|unique:user_login,email,' . $id; // Ignore current email
        }

        // If 'password' is provided, validate it
        if ($request->has('password')) {
            $validationRules['password'] = 'required|string|min:8';
        }

        // If 'mobile' is provided, validate it
        if ($request->has('mobile')) {
            $validationRules['mobile'] = 'required|string|max:15|unique:user_login,mobile,' . $id; // Ignore current mobile
        }

        // Perform validation
        $validator = Validator::make($request->all(), $validationRules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        // If 'email' is provided, update it
        if ($request->has('email')) {
            $user->email = $request->email;
        }

        // If 'password' is provided, hash and update it
        if ($request->has('password')) {
            $user->password =$request->password;
        }

        // If 'username' is provided, update it
        if ($request->has('username')) {
            $user->username = $request->username;
        }

        // If 'mobile' is provided, update it
        if ($request->has('mobile')) {
            $user->mobile = $request->mobile;
        }

        // If 'otp' is provided, update it
        if ($request->has('otp')) {
            $user->otp = $request->otp;
        }

        // If 'address' is provided, update it
        if ($request->has('address')) {
            $user->address = $request->address;
        }

        // If 'pincode' is provided, update it
        if ($request->has('pincode')) {
            $user->pincode = $request->pincode;
        }

        // If 'c_date' is provided, update it
        if ($request->has('c_date')) {
            $user->c_date = $request->c_date;
        }

        // If 'action' is provided, update it
        if ($request->has('action')) {
            $user->action = $request->action;
        }

        // Save the updated user
        $user->save();

        return response()->json(['message' => 'User updated successfully', 'data' => $user], 200);
    }


}
