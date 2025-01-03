<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        
        // Authenticate admin
        $admin = Admin::where('name', $request->name)->where('action', '0')->where('password', $request->password)->first();
        // dd($admin);

        if ($admin) {
            session(['admin_id' => $admin->id]); // Store admin ID in session
            return redirect('/admin/dashboard')->with('success', 'Logged in successfully.');
        }

        return back()->with('error', 'Invalid credentials or inactive account.');
    }

    public function logout()
    {
        session()->forget('admin_id'); // Clear session
        return redirect('/admin/login')->with('success', 'Logged out successfully.');
    }
}
