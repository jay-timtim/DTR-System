<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('settings');
    }

    // Process setting updates
    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:100',
            'company_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'dtr_logo'     => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'loader_logo'  => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
        ]);

        // 1. Update Company Name
        DB::table('settings')->updateOrInsert(
            ['key' => 'company_name'],
            ['value' => $request->company_name, 'updated_at' => now()]
        );

        // 2. Handle Image Uploads dynamically
        $logos = ['company_logo', 'dtr_logo', 'loader_logo'];
        foreach ($logos as $logo) {
            if ($request->hasFile($logo)) {
                // Delete the old file from storage to keep the server clean
                $oldPath = DB::table('settings')->where('key', $logo)->value('value');
                if ($oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }

                // Store the file in storage/app/public/branding
                $path = $request->file($logo)->store('branding', 'public');

                DB::table('settings')->updateOrInsert(
                    ['key' => $logo],
                    ['value' => $path, 'updated_at' => now()]
                );
            }
        }

        return back()->with('success', 'Branding configurations saved successfully!');
    }

    public function showResetPage()
    {
        return view('admin.factory-reset');
    }

    // Execute targeted system purges
    public function executeReset(Request $request)
    {
        // 1. Core security authorization check
        if ($request->input('confirm_phrase') !== 'RESET') {
            return redirect()->back()->with('error', 'Action unauthorized. The verification phrase did not match.');
        }

        $target = $request->input('reset_target');

        try {
            switch ($target) {
                case 'attendance_only':
                    // Safe truncate clears records without deleting the table structure itself
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                    DB::table('attendance_logs')->truncate();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    Artisan::call('cache:clear');
                    return redirect()->back()->with('success', 'All employee attendance logs have been completely cleared.');

                case 'employees_only':
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                    // Clears employees (Note: You may also need to clear logs if employee_id relies on it)
                    DB::table('employees')->truncate();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                    Artisan::call('cache:clear');
                    return redirect()->back()->with('success', 'All employee profiles have been successfully purged from the system.');

                case 'full_system':
                    // Wipes everything, re-runs migrations, and runs seeders
                    Artisan::call('cache:clear');
                    Artisan::call('migrate:fresh', [
                        '--seed' => true,
                        '--force' => true
                    ]);

                    // Automatically log out user since their administrative login token was flushed
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect('/login')->with('success', 'Full system factory reset complete. Database returned to default configurations.');

                default:
                    return redirect()->back()->with('error', 'Invalid purge operation targeted.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'System execution error: ' . $e->getMessage());
        }
    }
}
