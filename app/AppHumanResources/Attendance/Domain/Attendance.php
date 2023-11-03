<?php

namespace App\AppHumanResources\Attendance\Domain;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';

    protected $fillable = ['emp_id', 'check_in', 'check_out', 'status'];
}
