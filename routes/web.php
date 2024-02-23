<?php

use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/create', [WorkerController::class, 'create'])->name('workers.create');
Route::get('/calculateWeeklySalary/{id}', [WorkerController::class, 'calculateWeeklySalary'])->name('calculateWeeklySalary');
Route::get('/calculateMonthlySalary/{id}', [WorkerController::class, 'calculateMonthlySalary'])->name('calculateMonthlySalary');
Route::post('/workers', [WorkerController::class, 'store'])->name('workers.store');
Route::get('/payroll/report', [WorkerController::class, 'generatePayrollReport'])->name('payroll.report');
