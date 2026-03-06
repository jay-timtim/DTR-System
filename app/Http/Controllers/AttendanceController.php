<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function log(Request $request)
    {
        $employeeId = $request->employee_id;
        $logType = $request->log_type;
        $today = now()->toDateString();

        // Check employee existence
        $employee = DB::table('employees')
            ->where('employee_id', $employeeId)
            ->first();

        if(!$employee){
            return back()->with('error','Employee not found');
        }

        /*
        ------------------------------------------------
        Prevent Duplicate Punch Within 30 Seconds
        ------------------------------------------------
        */

        $lastLog = DB::table('attendance_logs')
            ->where('employee_id', $employeeId)
            ->orderByDesc('id')
            ->first();

        if($lastLog){

            $lastLogTime = strtotime($lastLog->log_time);
            $currentTime = time();

            if(($currentTime - $lastLogTime) < 3){
                return back()->with('error','Please wait before logging again');
            }
        }

        /*
        ------------------------------------------------
        Attendance State Validation Engine
        ------------------------------------------------
        */

        $latestLog = DB::table('attendance_logs')
            ->where('employee_id', $employeeId)
            ->whereDate('log_time', $today)
            ->orderByDesc('id')
            ->first();

        $allowed = false;

        if(!$latestLog){

            // First log must be TIME_IN
            if($logType == 'TIME_IN'){
                $allowed = true;
            }

        }else{

            switch($latestLog->log_type){

                case 'TIME_IN':

                    if(in_array($logType,['BREAK_OUT','TIME_OUT'])){
                        $allowed = true;
                    }

                    break;

                case 'BREAK_OUT':

                    if($logType == 'BREAK_IN'){
                        $allowed = true;
                    }

                    break;

                case 'BREAK_IN':

                    if($logType == 'TIME_OUT'){
                        $allowed = true;
                    }

                    break;

            }

        }

        if(!$allowed){
            return back()->with('error','Invalid attendance sequence');
        }

        /*
        ------------------------------------------------
        Insert Attendance Log
        ------------------------------------------------
        */

        DB::table('attendance_logs')->insert([
            'employee_id' => $employeeId,
            'log_time' => now(),
            'log_date' => $today,
            'log_type' => $logType,
            'device_name' => $request->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success','Attendance recorded');
    }

}
