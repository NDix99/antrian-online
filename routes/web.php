<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PatientController;
use App\Http\Middleware\Role;

Route::get('/patients/create', [PatientController::class, 'create'])->name('patient.create');
Route::post('/patients', [PatientController::class, 'store'])->name('patient.store');
Route::get('/patients', [PatientController::class, 'index'])->name('patient.index');
Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patient.edit');
Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patient.update');
Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patient.destroy');
Route::get('/cekrm', [PatientController::class, 'showCheckRMForm'])->name('patient.cekrm');
Route::get('antrian/{noantrian}', [PatientController::class, 'showAntrian'])->name('patient.antrian');


Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::get('/admin/setting', function () {
        return view('admin.setting');
    })->name('admin.setting');

    Route::get('/admin/user', function () {
        return view('admin.user');
    })->name('admin.user');

    Route::get('/admin/dataantrian', function () {
        return view('admin.dataantrian');
    })->name('admin.dataantrian');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:loket'
])->group(function () {
    Route::get('/loket', function () {
        return view('loket.home');
    })->name('loket.home');
});