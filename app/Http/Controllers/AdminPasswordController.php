<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use MongoDB\Driver\Session;

class AdminPasswordController extends Controller
{
    // Show the Change Account Settings form
    public function index()
    {
        // Fetch current logged-in admin data to pre-fill the username
        // If using standard Session: $admin = DB::table('admins')->where('id', session('admin_id'))->first();
        $admin = DB::table('admins')->where('id', Auth::id())->first();

        return view('admin.change-password', compact('admin'));
    }

    // Process the username and password update
    public function update(Request $request)
    {
        $adminId = session('admin_id'); // Or session('admin_id') if you use manual sessions

        // 1. Validate inputs
        // The username must be unique in the 'admins' table, except for the current admin's ID
        $request->validate([
            'username'         => 'required|string|max:255|unique:admins,username,' . $adminId,
            'current_password' => 'required',
            'new_password'     => 'nullable|string|min:8|confirmed', // Optional: only validate if they want to change it
        ]);

        // 2. Fetch the current admin record
        $admin = DB::table('admins')->where('id', $adminId)->first();

        if (!$admin) {
            return back()->withErrors(['error' => 'Admin account not found.']);
        }

        // 3. Verify the current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        // 4. Prepare update data
        $updateData = [
            'username'   => $request->username,
            'updated_at' => now(),
        ];

        // Only hash and update the password if they typed a new one
        if ($request->filled('new_password')) {
            $updateData['password'] = Hash::make($request->new_password);
        }

        // 5. Save changes to the database
        DB::table('admins')->where('id', $adminId)->update($updateData);

        // Optional: Update session username if using manual sessions
        if (session()->has('admin_username')) {
            session(['admin_username' => $request->username]);
        }

        return back()->with('success', 'Account credentials updated successfully!');
    }
}
