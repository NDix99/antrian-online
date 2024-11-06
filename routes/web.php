<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PatientController;
use App\Http\Middleware\Role;
use App\Http\Controllers\AntrianController;

//Route::get('/patients/create', [PatientController::class, 'create'])->name('patient.create');
//Route::post('/patients', [PatientController::class, 'store'])->name('patient.store');
//Route::get('/patients', [PatientController::class, 'index'])->name('patient.index');
//Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patient.edit');
//Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patient.update');
//Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patient.destroy');
Route::get('/cekrm', [PatientController::class, 'showCheckRMForm'])->name('patient.cekrm');
Route::post('/cek-rm', [PatientController::class, 'checkRM'])->name('cekrm.check');
Route::post('/cek-rm/check', [PatientController::class, 'checkRM'])->name('check.rm');
Route::get('antrian/{noantrian}', [PatientController::class, 'showAntrian'])->name('patient.antrian');
Route::post('/antrians', [AntrianController::class, 'store'])->name('antrian.store');
Route::post('/antrian', [AntrianController::class, 'store']);


// Route untuk memproses pengambilan nomor antrian
Route::post('/antrian/ambil', [AntrianController::class, 'ambil'])->name('antrian.ambil');

Route::get('/', function () {
    return view('welcome');
});

//route admin
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



//route loket
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'), 
    'verified',
    'role:loket'
])->group(function () {
    Route::get('/home', function () {
        return view('loket.home');
    })->name('loket.home');
});
Route::get('/antrian/data', [AntrianController::class, 'getData'])->name('antrian.data');

Route::group(['prefix' => 'antrian'], function() {
    Route::post('/ambil', [AntrianController::class, 'ambil'])->name('antrian.ambil');
    Route::put('/panggil/{no_antrian}', [AntrianController::class, 'panggilAntrian']);
    Route::put('/selesai/{no_antrian}', [AntrianController::class, 'selesaiAntrian']);
});

// Tambahkan rute untuk mendapatkan total antrian
Route::get('/antrian/total', [AntrianController::class, 'getTotal'])->name('antrian.total');
