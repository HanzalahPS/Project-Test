<?php

namespace App\AppHumanResources\Attendance\Domain;

use Illuminate\Database\Eloquent\Model;

class Schedule  extends Model
{
    protected $table = 'schedules';

    protected $fillable = ['loc_id', 'days', 'status'];

}
