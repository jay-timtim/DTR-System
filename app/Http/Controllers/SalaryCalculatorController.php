<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalaryCalculatorController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // We only fetch minute rates from deduction settings now
        $deductionSettings = DB::table('deduction_settings')->first() ?? (object)[
            'late_rate_per_minute' => 0.00,
            'undertime_rate_per_minute' => 0.00
        ];

        $lateRate = $deductionSettings->late_rate_per_minute;
        $undertimeRate = $deductionSettings->undertime_rate_per_minute;

        // Fetch active employees
        $employees = DB::table('employees')->where('status', 'Active')->get();
        $payrollData = [];

        foreach ($employees as $employee) {
            $totalLateMinutes = 0;
            $totalUndertimeMinutes = 0;
            $daysWorked = 0;

            // Group raw log entries into daily records with MIN/MAX punches
            $dailyRecords = DB::table('attendance_logs')
                ->where('employee_id', $employee->employee_id)
                ->whereBetween('log_date', [$startDate, $endDate])
                ->select(
                    'log_date as date',
                    DB::raw("MIN(CASE WHEN log_type IN ('TIME_IN', 'FIRST TIME IN') THEN log_time END) as time_in"),
                    DB::raw("MAX(CASE WHEN log_type IN ('BREAK_OUT', 'FIRST TIME OUT') THEN log_time END) as break_out"),
                    DB::raw("MIN(CASE WHEN log_type IN ('BREAK_IN', 'SECOND TIME IN') THEN log_time END) as break_in"),
                    DB::raw("MAX(CASE WHEN log_type IN ('TIME_OUT', 'SECOND TIME OUT') THEN log_time END) as time_out")
                )
                ->groupBy('log_date')
                ->get();

            foreach ($dailyRecords as $record) {
                $daysWorked++;

                // Parse schedule thresholds safely
                $sStart = $employee->schedule_start ? Carbon::parse($record->date . ' ' . $employee->schedule_start) : null;
                $sBOut  = $employee->break_start ? Carbon::parse($record->date . ' ' . $employee->break_start) : null;
                $sBIn   = $employee->break_end ? Carbon::parse($record->date . ' ' . $employee->break_end) : null;
                $sEnd   = $employee->schedule_end ? Carbon::parse($record->date . ' ' . $employee->schedule_end) : null;

                // Parse actual punches
                $t1In  = $record->time_in ? Carbon::parse($record->time_in) : null;
                $t1Out = $record->break_out ? Carbon::parse($record->break_out) : null;
                $t2In  = $record->break_in ? Carbon::parse($record->break_in) : null;
                $t2Out = $record->time_out ? Carbon::parse($record->time_out) : null;

                // --- 1. LATE CALCULATIONS ---
                if ($t1In && $sStart && $t1In->gt($sStart)) {
                    $totalLateMinutes += $sStart->diffInMinutes($t1In, true);
                }

                if ($t2In && $sBIn && $t2In->gt($sBIn)) {
                    $totalLateMinutes += $sBIn->diffInMinutes($t2In, true);
                }

                // --- 2. UNDERTIME CALCULATIONS ---
                if ($t1Out && $sBOut && $t1Out->lt($sBOut)) {
                    $totalUndertimeMinutes += $t1Out->diffInMinutes($sBOut, true);
                }

                if ($t2Out && $sEnd && $t2Out->lt($sEnd)) {
                    $totalUndertimeMinutes += $t2Out->diffInMinutes($sEnd, true);
                }
            }

            // Time-based calculations
            $lateDeduction = $totalLateMinutes * $lateRate;
            $undertimeDeduction = $totalUndertimeMinutes * $undertimeRate;

            // --- FIXED: Read directly from Employee Profile Columns ---
            $empPagibig    = $daysWorked > 0 ? ($employee->pagibig_deduction ?? 0.00) : 0;
            $empSss        = $daysWorked > 0 ? ($employee->sss_deduction ?? 0.00) : 0;
            $empPhilhealth = $daysWorked > 0 ? ($employee->philhealth_deduction ?? 0.00) : 0;
            $empOthers     = $daysWorked > 0 ? ($employee->other_deductions ?? 0.00) : 0;

            $totalDeductions = $lateDeduction + $undertimeDeduction + $empPagibig + $empSss + $empPhilhealth + $empOthers;

            $dailyRate = $employee->basic_salary;
            $grossEarned = $dailyRate * $daysWorked;
            $netPay = $grossEarned - $totalDeductions;

            $payrollData[] = [
                'employee_id'       => $employee->employee_id,
                'name'              => trim("{$employee->first_name} {$employee->last_name}"),
                'basic_salary'      => $employee->basic_salary,
                'days_worked'       => $daysWorked,
                'gross_earned'      => round($grossEarned, 2),
                'late_minutes'      => $totalLateMinutes,
                'late_deduction'    => round($lateDeduction, 2),
                'undertime_minutes' => $totalUndertimeMinutes,
                'undertime_deduction'=> round($undertimeDeduction, 2),

                // Map employee specific values
                'pagibig_deduction'   => round($empPagibig, 2),
                'sss_deduction'       => round($empSss, 2),
                'philhealth_deduction'=> round($empPhilhealth, 2),
                'other_deductions'    => round($empOthers, 2),

                'total_deductions'  => round($totalDeductions, 2),
                'net_pay'           => round(max(0, $netPay), 2)
            ];
        }

        return view('admin.salary-calculator', compact('payrollData', 'startDate', 'endDate', 'lateRate', 'undertimeRate'));
    }

    // --- NEW: AJAX Inline Update Handler ---
    public function updateInlineDeductions(Request $request)
    {
        $request->validate([
            'employee_id'          => 'required|string',
            'pagibig_deduction'    => 'required|numeric|min:0',
            'sss_deduction'        => 'required|numeric|min:0',
            'philhealth_deduction' => 'required|numeric|min:0',
            'other_deductions'     => 'required|numeric|min:0',
        ]);

        DB::table('employees')
            ->where('employee_id', $request->employee_id)
            ->update([
                'pagibig_deduction'    => $request->pagibig_deduction,
                'sss_deduction'        => $request->sss_deduction,
                'philhealth_deduction' => $request->philhealth_deduction,
                'other_deductions'     => $request->other_deductions,
                'updated_at'           => now()
            ]);

        return response()->json(['success' => true, 'message' => 'Deductions saved successfully']);
    }
}
