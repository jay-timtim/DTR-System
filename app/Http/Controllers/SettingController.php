<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
