<?php

use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\SensorBoilerController;
use App\Http\Controllers\Api\SensorDailyTankController;
use App\Http\Controllers\Api\SensorGlucoseController;
use App\Http\Controllers\Api\SensorOlahSariController;
use App\Http\Controllers\Api\SensorST53Controller;
use App\Http\Controllers\Api\SensorSTk400Controller;
use App\Http\Controllers\Api\SensorPasteurisasi1Controller;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\CustomerController;
// use App\Models\Customer;
// use Illuminate\Container\Attributes\Auth;

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


Route::prefix('boiler')->group(function () {
    Route::view('/realtime', 'boiler.realtime');
    Route::view('/datatren', 'boiler.datatren');
});



Route::middleware('web')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});


Route::prefix('sensor')->group(function () {
    Route::get('batubara_fk', [SensorBoilerController::class, 'getBatubaraFk']);
    Route::get('bbsteam', [SensorBoilerController::class, 'getBbSteam']);
    Route::get('co2', [SensorBoilerController::class, 'getCO2']);
    Route::get('level_feed_water', [SensorBoilerController::class, 'getLevelFeedWater']);
    Route::get('idfan', [SensorBoilerController::class, 'getIDFan']);
    Route::get('steam_fk', [SensorBoilerController::class, 'getSteamFk']);
    Route::get('rhs_toker', [SensorBoilerController::class, 'getRHStoker']);
    Route::get('rh_guiloutine', [SensorBoilerController::class, 'getRHGuiloutine']);
    Route::get('rhfd_fan', [SensorBoilerController::class, 'getRHFDFan']);
    Route::get('rhtemp', [SensorBoilerController::class, 'getRHTemp']);
    Route::get('pvsteam1', [SensorBoilerController::class, 'getPVSteam1']);
    Route::get('pvsteam', [SensorBoilerController::class, 'getPVSteam']);
    Route::get('waterpump2', [SensorBoilerController::class, 'getWaterPump2']);
    Route::get('waterpump1', [SensorBoilerController::class, 'getWaterPump1']);
    Route::get('o2', [SensorBoilerController::class, 'getO2']);
    Route::get('lhstoker', [SensorBoilerController::class, 'getLHStoker']);
    Route::get('lhguil', [SensorBoilerController::class, 'getLHGuiloutine']);
    Route::get('lhfd', [SensorBoilerController::class, 'getLHFDFan']);
    Route::get('lhtemp', [SensorBoilerController::class, 'getLHTemp']);
    Route::get('/boiler-data', [SensorBoilerController::class, 'getBoilerData']);
});

Route::prefix('daily-tank')->group(function () {
    Route::get('/ro', [SensorDailyTankController::class, 'getLatestRO']);
    Route::get('/salt', [SensorDailyTankController::class, 'getLatestSalt']);
    Route::get('/sauceA', [SensorDailyTankController::class, 'getLatestSoySauceA']);
    Route::get('/sauceB', [SensorDailyTankController::class, 'getLatestSoySauceB']);
    Route::get('/sauceC', [SensorDailyTankController::class, 'getLatestSoySauceC']);
});
Route::prefix('glucose')->group(function () {
    Route::get('/gst1', [SensorGlucoseController::class, 'getLatestGST1']);
    Route::get('/gst2', [SensorGlucoseController::class, 'getLatestGST2']);
    Route::get('/gst3', [SensorGlucoseController::class, 'getLatestGST3']);
    Route::get('/gst4', [SensorGlucoseController::class, 'getLatestGST4']);
    Route::get('/gst5', [SensorGlucoseController::class, 'getLatestGST5']);
});


Route::prefix('olahsari')->group(function () {
    Route::get('/lc1', [SensorOlahsariController::class, 'getLatestLC1']);
    Route::get('/lc2', [SensorOlahsariController::class, 'getLatestLC2']);
    Route::get('/temp1', [SensorOlahsariController::class, 'getLatestTemp1']);
    Route::get('/temp2', [SensorOlahsariController::class, 'getLatestTemp2']);
});

Route::get('/st53/{column}', [SensorST53Controller::class, 'getLatestData']);
Route::get('/stk400/{column}', [SensorSTK400Controller::class, 'getLatestData']);
Route::get('/pasteurisasi1/{field}', [SensorPasteurisasi1Controller::class, 'getLatestData']);