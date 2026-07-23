<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



// Route::get('/login', function () {
//     return view('auth.auth-login');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard');
    })->name('home');

 Route::resource('user', UserController::class);

    
});

