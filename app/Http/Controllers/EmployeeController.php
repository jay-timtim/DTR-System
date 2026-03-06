<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::latest()->get();

        return view('manage-employees', compact('employees'));
    }
    private function generateEmployeeId()
    {
        do {
            $random = strtoupper(Str::random(6));
            $employeeId = 'EMP-' . $random;

        } while (Employee::where('employee_id', $employeeId)->exists());

        return $employeeId;
    }
    public function store(Request $request)
    {
        $employeeId = $this->generateEmployeeId();

        Employee::create([
            'employee_id' => $employeeId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'address' => $request->address,
            'position' => $request->position,
            'employment_status' => $request->employment_status,
            'schedule_start' => $request->schedule_start,
            'break_start' => $request->break_start,
            'break_end' => $request->break_end,
            'schedule_end' => $request->schedule_end,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success','Employee Added');
    }
}
