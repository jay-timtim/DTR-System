<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function reports(Request $request)
    {
        $today = now()->toDateString();

        // 1. Build the base query for grouped daily attendance logs
        $query = DB::table('attendance_logs as a')
            ->join('employees as e', 'a.employee_id', '=', 'e.employee_id')
            ->select(
                'a.employee_id',
                'e.first_name',
                'e.last_name',
                'a.log_date as attendance_date', // Using log_date directly
                DB::raw("MIN(CASE WHEN a.log_type = 'FIRST TIME IN' THEN a.log_time END) as time_in"),
                DB::raw("MAX(CASE WHEN a.log_type = 'SECOND TIME OUT' THEN a.log_time END) as time_out"),
                DB::raw("MAX(a.log_type) as status")
            )
            ->groupBy(
                'a.employee_id',
                'e.first_name',
                'e.last_name',
                'a.log_date'
            );

        // 2. Apply Filters dynamically if present in the request
        if ($request->filled('employee_id')) {
            $query->where('a.employee_id', $request->input('employee_id'));
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('a.log_date', [
                $request->input('start_date'),
                $request->input('end_date')
            ]);
        }

        // Execute query pagination
        $records = $query->latest('attendance_date')->paginate(20)->withQueryString();

        // 3. Dropdown list lookup
        $employees = DB::table('employees')->get();

        // 4. Analytics Summary Blocks
        $totalAttendance = DB::table('attendance_logs')->count();

        // Top Performer lookup
        $mostPresentEmployee = DB::table('attendance_logs')
            ->select('employee_id', DB::raw('count(*) as total'))
            ->groupBy('employee_id')
            ->orderByDesc('total')
            ->first();

        $mostPresentName = null;
        if ($mostPresentEmployee) {
            $emp = DB::table('employees')
                ->where('employee_id', $mostPresentEmployee->employee_id)
                ->first();
            if ($emp) {
                $mostPresentName = $emp->first_name . ' ' . $emp->last_name;
            }
        }

        // PostgreSQL late engine tracking for today
        $lateToday = DB::table('attendance_logs')
            ->join('employees', 'attendance_logs.employee_id', '=', 'employees.employee_id')
            ->whereDate('attendance_logs.log_date', $today)
            ->where('attendance_logs.log_type', 'FIRST TIME IN')
            ->whereRaw('attendance_logs.log_time::time > employees.schedule_start::time')
            ->distinct('attendance_logs.employee_id')
            ->count();

        return view('reports', compact(
            'records',
            'employees',
            'totalAttendance',
            'mostPresentName',
            'lateToday'
        ));
    }
}
