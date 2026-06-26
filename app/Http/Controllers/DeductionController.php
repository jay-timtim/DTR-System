<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeductionController extends Controller
{
    public function index()
    {
        // Fetch values or provide instant default values for all parameters
        $settings = DB::table('deduction_settings')->first() ?? (object)[
            'late_rate_per_minute' => 0.00,
            'undertime_rate_per_minute' => 0.00,
            'pagibig_deduction' => 0.00,
            'sss_deduction' => 0.00,
            'philhealth_deduction' => 0.00,
            'other_deductions' => 0.00
        ];

        return view('admin.deductions', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'late_rate_per_minute' => 'required|numeric|min:0',
            'undertime_rate_per_minute' => 'required|numeric|min:0',
            'pagibig_deduction' => 'required|numeric|min:0',
            'sss_deduction' => 'required|numeric|min:0',
            'philhealth_deduction' => 'required|numeric|min:0',
            'other_deductions' => 'required|numeric|min:0',
        ]);

        $exists = DB::table('deduction_settings')->first();

        $data = [
            'late_rate_per_minute' => $request->late_rate_per_minute,
            'undertime_rate_per_minute' => $request->undertime_rate_per_minute,
            'pagibig_deduction' => $request->pagibig_deduction,
            'sss_deduction' => $request->sss_deduction,
            'philhealth_deduction' => $request->philhealth_deduction,
            'other_deductions' => $request->other_deductions,
            'updated_at' => now(),
        ];

        if ($exists) {
            DB::table('deduction_settings')->where('id', $exists->id)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('deduction_settings')->insert($data);
        }

        return back()->with('success', 'Deduction configurations updated successfully!');
    }
}
