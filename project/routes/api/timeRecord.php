<?php

use App\Http\Controllers\TimeRecord\TimeRecordController;
use Illuminate\Support\Facades\Route;




Route::post('/time-records', [TimeRecordController::class, 'store'])->middleware('auth:employee-api');
Route::get('/reports/time-records', [TimeRecordController::class, 'report'])->middleware('auth:admin-api');