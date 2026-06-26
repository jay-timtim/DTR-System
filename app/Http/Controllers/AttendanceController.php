<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function getStatus($employeeId)
    {
        $today = now()->toDateString();

        $lastLog = DB::table('attendance_logs')
            ->where('employee_id',$employeeId)
            ->whereDate('log_time',$today)
            ->orderByDesc('id')
            ->first();

        if(!$lastLog){
            return response()->json([
                'next' => ['FIRST TIME IN','SECOND TIME IN','FIRST TIME OUT','SECOND TIME OUT']
            ]);
        }
        elseif($lastLog->log_type == 'SECOND TIME OUT'){
            return response()->json([
                'next' => []
            ]);
        }

        // Check if the property equals the string
        else {
            return response()->json([
                'next' => ['FIRST TIME IN','SECOND TIME IN','FIRST TIME OUT','SECOND TIME OUT']
            ]);
        }

    }

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
            // Change: Return JSON instead of back()
            return response()->json([
                'success' => false,
                'message' => 'Employee not found'
            ], 404);
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
                return response()->json([
                    'success' => false,
                    'message' => 'Please wait before logging again'
                ], 429);
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

        // Logic remains same, but ensure log types match your frontend button values
        if(!$latestLog){
            if($logType == 'FIRST TIME IN') $allowed = true;
        } else {
            switch($latestLog->log_type){
                case 'FIRST TIME IN':
                    if(in_array($logType, ['FIRST TIME OUT', 'SECOND TIME OUT'])) $allowed = true;
                    break;
                case 'FIRST TIME OUT':
                    if($logType == 'SECOND TIME IN') $allowed = true;
                    break;
                case 'SECOND TIME IN':
                    if($logType == 'SECOND TIME OUT') $allowed = true;
                    break;
            }
        }

        if(!$allowed){
            return response()->json([
                'success' => false,
                'message' => 'Invalid attendance sequence'
            ], 400);
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

        // Change: Success JSON response
        return response()->json([
            'success' => true,
            'message' => 'Attendance recorded: ' . str_replace('_', ' ', $logType)
        ]);
    }



}
