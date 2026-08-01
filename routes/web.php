<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\IjinController;



Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard');
    })->name('home');

 Route::resource('user', UserController::class);
    
    // Ijin (izin) resource routes for users
    Route::resource('ijin', IjinController::class);

    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::get('/cuti/create', [CutiController::class, 'create'])->name('cuti.create');
    Route::post('/cuti', [CutiController::class, 'store'])->name('cuti.store');
    Route::get('/cuti/{cuti}', [CutiController::class, 'show'])->name('cuti.show');
    Route::get('/cuti/{cuti}/edit', [CutiController::class, 'edit'])->name('cuti.edit');
    Route::put('/cuti/{cuti}', [CutiController::class, 'update'])->name('cuti.update');
    Route::delete('/cuti/{cuti}', [CutiController::class, 'destroy'])->name('cuti.destroy');
    Route::post('/cuti/{cuti}/approve', [CutiController::class, 'approve'])->name('cuti.approve');
    Route::post('/cuti/{cuti}/reject', [CutiController::class, 'reject'])->name('cuti.reject');
    
});
Route::middleware(['auth'])->group(function () {

    
    Route::get('/payroll/export', [PayrollController::class, 'exportExcel'])
        ->name('payroll.export');

    Route::get('/payroll/{payroll}/slip', [PayrollController::class, 'downloadSlip'])
        ->name('payroll.slip');

    Route::resource('payroll', PayrollController::class);
});



Route::get('/absensi/masuk',[AbsensiController::class,'formMasuk'])
    ->name('absensi.formMasuk');

Route::post('/absensi/masuk',[AbsensiController::class,'masuk'])
    ->name('absensi.masuk');

Route::get('/absensi', [AbsensiController::class, 'index'])
    ->name('absensi.index');

Route::get('/absensi/export', [AbsensiController::class, 'export'])
    ->name('absensi.export');

Route::get('/absensi/pulang', [AbsensiController::class, 'formPulang'])
    ->name('absensi.formPulang');

Route::post('/absensi/pulang', [AbsensiController::class, 'pulang'])
    ->name('absensi.pulang');

    Route::get('/absensi/export', [AbsensiController::class, 'exportExcel'])
    ->name('absensi.export')
    ->middleware('auth');


