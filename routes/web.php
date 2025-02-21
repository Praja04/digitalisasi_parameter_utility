<?php
// Route Group untuk autentikasi
// Route::middleware('guest')->group(function () {
//     Route::post('/login', [AuthController::class, 'login'])->name('login');
// });

// Route::middleware(['auth'])->get('/get-username', [AuthController::class, 'get_username']);
// Route::get('username', [AuthController::class, 'get_username'])->name('users.username');
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Models\Customer;
use Illuminate\Container\Attributes\Auth;

Route::get('/', function () {
    return view('signin/login');
});
Route::get('dashboard', function () {
    return view('dashboard');
});

Route::get('menu', function () {
    return view('menu/menu');
});

Route::get('menu-utama', function () {
    return view('menu/menu-utama');
});

Route::middleware('web')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});