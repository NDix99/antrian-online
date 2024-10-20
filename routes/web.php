<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

Route::get('/patients/create', [PatientController::class, 'create'])->name('patient.create');
Route::post('/patients', [PatientController::class, 'store'])->name('patient.store');
Route::get('/patients', [PatientController::class, 'index'])->name('patient.index');
Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patient.edit');
Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patient.update');
Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patient.destroy');
Route::get('/cekrm', [PatientController::class, 'showCheckRMForm'])->name('patient.cekrm');



Route::get('/admin/setting', function () {
    return view('admin.setting');
})->name('admin.setting')->middleware(['auth', 'admin']);

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
