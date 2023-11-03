<?php
namespace App\AppHumanResources\Attendance\Application;

use App\AppHumanResources\Attendance\Domain\Attendance;
use App\AppHumanResources\Attendance\Domain\AttendanceFault;
use App\AppHumanResources\Attendance\Domain\Employee;
use App\AppHumanResources\Attendance\Domain\Location;
use App\AppHumanResources\Attendance\Domain\Schedule;
use App\AppHumanResources\Attendance\Domain\Shift;

class AttendanceService
{
    public function uploadAttendanceData(array $data)
    {
        return Attendance::create($data);
    }

    public function uploadEmployeeData(array $data)
    {
        return Employee::create($data);
    }

    public function uploadAttendanceFaultData(array $data)
    {
        return AttendanceFault::create($data);
    }

    public function uploadLocationData(array $data)
    {
        return Location::create($data);
    }
    


    public function uploadScheduleData(array $data)
    {
        return Schedule::create($data);
    }

    public function uploadShiftData(array $data)
    {
        return Shift::create($data);
    }

}
