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

        // Get deduction rates
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

            // Group raw log entries into daily records with MIN/MAX punches (matching your DTR view)
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

                // Parse schedule thresholds safely (Matching your DTR Blade file exactly)
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
                // Morning Shift Late: actual punch ($t1In) is GREATER than schedule ($sStart)
                if ($t1In && $sStart && $t1In->gt($sStart)) {
                    // Passing "true" as the second parameter forces a absolute positive integer
                    $totalLateMinutes += $sStart->diffInMinutes($t1In, true);
                }

                // Afternoon Shift Late: actual break return ($t2In) is GREATER than break end schedule ($sBIn)
                if ($t2In && $sBIn && $t2In->gt($sBIn)) {
                    $totalLateMinutes += $sBIn->diffInMinutes($t2In, true);
                }

                // --- 2. UNDERTIME CALCULATIONS ---
                // Morning Shift Early Exit: actual break out ($t1Out) is LESS than break start schedule ($sBOut)
                if ($t1Out && $sBOut && $t1Out->lt($sBOut)) {
                    $totalUndertimeMinutes += $t1Out->diffInMinutes($sBOut, true);
                }

                // Afternoon Shift Early Exit: final clock out ($t2Out) is LESS than shift end schedule ($sEnd)
                if ($t2Out && $sEnd && $t2Out->lt($sEnd)) {
                    $totalUndertimeMinutes += $t2Out->diffInMinutes($sEnd, true);
                }
            }

            // Calculations
            $lateDeduction = $totalLateMinutes * $lateRate;
            $undertimeDeduction = $totalUndertimeMinutes * $undertimeRate;
            $totalDeductions = $lateDeduction + $undertimeDeduction;

            // Daily Rate structure
            $dailyRate = $employee->basic_salary;
            $grossEarned = $dailyRate * $daysWorked;
            $netPay = $grossEarned - $totalDeductions;

            $payrollData[] = [
                'employee_id' => $employee->employee_id,
                'name' => trim("{$employee->first_name} {$employee->last_name}"),
                'basic_salary' => $employee->basic_salary,
                'days_worked' => $daysWorked,
                'gross_earned' => round($grossEarned, 2),
                'late_minutes' => $totalLateMinutes,
                'late_deduction' => round($lateDeduction, 2),
                'undertime_minutes' => $totalUndertimeMinutes,
                'undertime_deduction' => round($undertimeDeduction, 2),
                'total_deductions' => round($totalDeductions, 2),
                'net_pay' => round(max(0, $netPay), 2)
            ];
        }

        return view('admin.salary-calculator', compact('payrollData', 'startDate', 'endDate', 'lateRate', 'undertimeRate'));
    }
}
