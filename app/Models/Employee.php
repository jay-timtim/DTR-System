<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'employee_id',
        'first_name',
        'last_name',
        'gender',
        'address',
        'position',
        'employment_status',
        'schedule_start',
        'break_start',
        'break_end',
        'schedule_end',
        'photo_path',
        'status'
    ];
}
