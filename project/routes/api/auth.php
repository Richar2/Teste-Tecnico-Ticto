<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\EmployeeController;
use App\Http\Controllers\Auth\AdministratorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('auth')->group(function () {
    Route::post('/employee', [EmployeeController::class, 'login'])->name('login-employee');
    Route::post('/employee/change-password', [EmployeeController::class, 'changePassword'])->name('change-employee')->middleware('auth:employee-api');
});

Route::prefix('auth')->group(function () {
    Route::post('/administrator', [AdministratorController::class, 'login'])->name('login-administrator');
});
