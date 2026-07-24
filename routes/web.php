<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\AbsensiController;



// Route::get('/login', function () {
//     return view('auth.auth-login');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard');
    })->name('home');

 Route::resource('user', UserController::class);

    
});
Route::middleware(['auth', 'role:admin|manager'])->group(function () {

    Route::resource('payroll', PayrollController::class);

});

Route::get('/absensi/masuk',[AbsensiController::class,'formMasuk'])
    ->name('absensi.formMasuk');

Route::post('/absensi/masuk',[AbsensiController::class,'masuk'])
    ->name('absensi.masuk');

Route::get('/absensi', [AbsensiController::class, 'index'])
    ->name('absensi.index');

Route::get('/absensi/pulang', [AbsensiController::class, 'formPulang'])
    ->name('absensi.formPulang');

Route::post('/absensi/pulang', [AbsensiController::class, 'pulang'])
    ->name('absensi.pulang');

