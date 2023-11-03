<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\AppHumanResources\Attendance\Application\AttendanceService;
use App\AppHumanResources\Attendance\Domain\Employee;
use App\AppHumanResources\Attendance\Domain\Location;
use App\AppHumanResources\Attendance\Domain\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function uploadEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid file format'], 400);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json(['error' => 'Invalid file'], 400);
        }

        $uploadedData = array_map('str_getcsv', file($file));

        foreach ($uploadedData as $data) {
            $dob = date('Y-m-d', strtotime(str_replace('/', '-', $data[2])));

            $employeeData = [
                'name' => $data[0],
                'email' => $data[1],
                'dob' => $dob,
                'nic' => $data[3],
                'image' => $data[4] ?? null,
            ];

            $this->attendanceService->uploadEmployeeData($employeeData);
        }

        return response()->json(['message' => 'Employee data uploaded successfully', 'data' => $employeeData]);
    }

    public function uploadLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid file format'], 400);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json(['error' => 'Invalid file'], 400);
        }

        $uploadedData = array_map('str_getcsv', file($file));

        foreach ($uploadedData as $data) {

            $LocationData = [
                'name' => $data[0],
                'address' => $data[1],
            ];

            $this->attendanceService->uploadLocationData($LocationData);
        }

        return response()->json(['message' => 'Location data uploaded successfully']);
    }



    public function uploadAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid file format'], 400);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json(['error' => 'Invalid file'], 400);
        }

        $uploadedData = array_map('str_getcsv', file($file));

        foreach ($uploadedData as $data) {
            $employeeId = preg_replace('/[^\x20-\x7E]/', '', trim($data[0]));

            $employee = Employee::where('id', $employeeId)->first();

            if (!$employee) {
                return response()->json(['error' => 'Employee with ID ' . $employeeId . ' does not exist'], 400);
            }

            $checkInDateTime = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $data[1])));
            $checkOutDateTime = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $data[2])));

            $attendanceData = [
                'emp_id' => $employeeId,
                'check_in' => $checkInDateTime,
                'check_out' => $checkOutDateTime,
                'status' => $data[3] ?? null,
            ];

            $this->attendanceService->uploadAttendanceData($attendanceData);
        }

        return response()->json(['message' => 'Attendance data uploaded successfully']);
    }

    public function uploadAttendanceFault(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid file format'], 400);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json(['error' => 'Invalid file'], 400);
        }

        $uploadedData = array_map('str_getcsv', file($file));

        foreach ($uploadedData as $data) {

            $employeeId = preg_replace('/[^\x20-\x7E]/', '', trim($data[0]));
            $locationId = preg_replace('/[^\x20-\x7E]/', '', trim($data[1]));


            $employee = Employee::where('id', $employeeId)->first();
            $location = Location::where('id', $locationId)->first();


            if (!$employee) {
                return response()->json(['error' => 'Employee with ID ' . $employeeId . ' does not exist'], 400);
            }

            if (!$location) {
                return response()->json(['error' => 'Location with ID ' . $locationId . ' does not exist'], 400);
            }

            $employeeData = [
                'emp_id' => $employee->id,
                'attendance_id' => $location->id,
                'reason' => $data[2]
            ];
            $this->attendanceService->uploadAttendanceFaultData($employeeData);
        }

        return response()->json(['message' => 'Attendance Fault data uploaded successfully']);
    }

    public function uploadSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid file format'], 400);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json(['error' => 'Invalid file'], 400);
        }

        $uploadedData = array_map('str_getcsv', file($file));

        foreach ($uploadedData as $data) {
            $locationId = preg_replace('/[^\x20-\x7E]/', '', trim($data[0]));
            $location = Location::where('id', $locationId)->first();

            if (!$location) {
                return response()->json(['error' => 'Schedule with ID ' . $locationId . ' does not exist'], 400);
            }
            $scheduleData = [
                'loc_id' => $location->id,
                'days' => $data[1],
                'status' => $data[2],

            ];

            $this->attendanceService->uploadScheduleData($scheduleData);
        }

        return response()->json(['message' => 'Schedule data uploaded successfully']);
    }

    public function uploadShift(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid file format'], 400);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json(['error' => 'Invalid file'], 400);
        }

        $uploadedData = array_map('str_getcsv', file($file));

        foreach ($uploadedData as $data) {
            $scheduleId = preg_replace('/[^\x20-\x7E]/', '', trim($data[0]));


            $schedule = Schedule::where('id', $scheduleId)->first();

            if (!$schedule) {
                return response()->json(['error' => 'Shift with ID ' . $scheduleId . ' does not exist'], 400);
            }

            $scheduleId = $data[0];
            $checkIn = strtotime($data[1]);
            $checkOut = strtotime($data[2]);

            if ($checkIn === false || $checkOut === false) {
                return response()->json(['error' => 'Invalid time format in the CSV'], 400);
            }

            $shiftData = [
                'schedule_id' => $schedule->id,
                'check_in' => date('H:i:s', $checkIn),
                'check_out' => date('H:i:s', $checkOut),
            ];

            $this->attendanceService->uploadShiftData($shiftData);
        }


        return response()->json(['message' => 'Shift data uploaded successfully']);
    }
}
