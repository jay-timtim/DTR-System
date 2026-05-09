<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DtrController extends Controller
{
    public function viewDTR(Request $request)
    {
        $query = DB::table('attendance_logs')
            ->join('employees', 'employees.employee_id', '=', 'attendance_logs.employee_id')
            ->select(
                'attendance_logs.employee_id',
                'employees.first_name',
                'employees.last_name',
                'employees.schedule_start',
                'employees.break_start',
                'employees.break_end',
                'employees.schedule_end',
                'attendance_logs.log_date as date',

                // 1st In (Morning) - First log of this type
                DB::raw("MIN(CASE WHEN log_type IN ('TIME_IN', 'FIRST TIME IN') THEN log_time END) as time_in"),

                // 1st Out (Break Out) - Last log of this type
                DB::raw("MAX(CASE WHEN log_type IN ('BREAK_OUT', 'FIRST TIME OUT') THEN log_time END) as break_out"),

                // 2nd In (Break In) - FIXED: Changed to MIN to get their first return log
                DB::raw("MIN(CASE WHEN log_type IN ('BREAK_IN', 'SECOND TIME IN') THEN log_time END) as break_in"),

                // 2nd Out (Final Out) - Last log of this type
                DB::raw("MAX(CASE WHEN log_type IN ('TIME_OUT', 'SECOND TIME OUT') THEN log_time END) as time_out")
            );

        /* --- FILTERS --- */
        if ($request->employee_id) {
            $query->where('attendance_logs.employee_id', $request->employee_id);
        }

        if ($request->start_date) {
            $query->where('attendance_logs.log_date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->where('attendance_logs.log_date', '<=', $request->end_date);
        }

        /* --- GROUPING --- */
        $records = $query
            ->groupBy(
                'attendance_logs.employee_id',
                'employees.first_name',
                'employees.last_name',
                'employees.schedule_start',
                'employees.break_start',
                'employees.break_end',
                'employees.schedule_end',
                'attendance_logs.log_date'
            )
            ->orderBy('date', 'desc')
            ->paginate(15)
            ->appends($request->all());

        $employees = DB::table('employees')->orderBy('last_name')->get();

        return view('view-dtr', compact('records', 'employees'));
    }
}
