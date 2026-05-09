<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'birthday',
        'gender',
        'address',
        'position',
        'department',
        'employment_status',
        'date_hired',
        'basic_salary',
        'schedule_start',
        'break_start',
        'break_end',
        'schedule_end',
        'photo_path',
        'status'
    ];
}
