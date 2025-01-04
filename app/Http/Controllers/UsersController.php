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

            $users = $users->where('action','0')->get();

        }

        // Pass data to the view
        return view('users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = UserLogin::find($id);

        if (!$user) {
            return redirect()->route('user.view')->withErrors('User not found');
        }

        return view('users.edit', compact('user')); // Create an edit view
    }

    public function update(Request $request, $id)
    {
        $user = UserLogin::find($id);

        if (!$user) {
            return redirect()->route('user.view')->withErrors('User not found');
        }

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:user_login,email,' . $id,
            'mobile' => 'required|string|max:15|unique:user_login,mobile,' . $id,
        ]);

        $user->update($validated);

        return redirect()->route('user.view')->with('success', 'User updated successfully');
    }

    public function delete($id)
    {
        $user = UserLogin::find($id);

        if (!$user) {
            return redirect()->route('user.view')->withErrors('User not found');
        }
        $user->update(['action' => '1']);

        return redirect()->route('user.view')->with('success', 'User deleted successfully');
    }

    
}
