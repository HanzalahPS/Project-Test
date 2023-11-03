<?php

use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\DuplicateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/find-duplicates', [DuplicateController::class, 'findDuplicates']);
Route::post('/upload-employee', [AttendanceController::class, 'uploadEmployee']);
Route::post('/upload-attendance', [AttendanceController::class, 'uploadAttendance']);
Route::post('/upload-location', [AttendanceController::class, 'uploadLocation']);
Route::post('/upload-attendance-fault', [AttendanceController::class, 'uploadAttendanceFault']);
Route::post('/upload-schedule', [AttendanceController::class, 'uploadSchedule']);
Route::post('/upload-shift', [AttendanceController::class, 'uploadShift']);
