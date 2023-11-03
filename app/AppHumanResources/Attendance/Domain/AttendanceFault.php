<?php

namespace App\AppHumanResources\Attendance\Domain;

use Illuminate\Database\Eloquent\Model;

class AttendanceFault extends Model
{
    protected $table = 'attendance_faults';

    protected $fillable = ['emp_id', 'attendance_id', 'reason'];

}
