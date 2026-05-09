<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeductionController extends Controller
{
    public function index()
    {
        $settings = DB::table('deduction_settings')->first() ?? (object)[
            'late_rate_per_minute' => 0.00,
            'undertime_rate_per_minute' => 0.00
        ];
        return view('admin.deductions', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'late_rate_per_minute' => 'required|numeric|min:0',
            'undertime_rate_per_minute' => 'required|numeric|min:0',
        ]);

        $exists = DB::table('deduction_settings')->first();

        if ($exists) {
            DB::table('deduction_settings')->where('id', $exists->id)->update([
                'late_rate_per_minute' => $request->late_rate_per_minute,
                'undertime_rate_per_minute' => $request->undertime_rate_per_minute,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('deduction_settings')->insert([
                'late_rate_per_minute' => $request->late_rate_per_minute,
                'undertime_rate_per_minute' => $request->undertime_rate_per_minute,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Deduction rates updated successfully!');
    }
}
