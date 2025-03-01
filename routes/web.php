<?php

use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorBoilerController;
use App\Http\Controllers\Api\SensorDailyTankController;
use App\Http\Controllers\Api\SensorGlucoseController;
use App\Http\Controllers\Api\SensorOlahSariController;
use App\Http\Controllers\Api\SensorST53Controller;
use App\Http\Controllers\Api\SensorSTk400Controller;
use App\Http\Controllers\Api\SensorPasteurisasi1Controller;
use App\Http\Controllers\Api\SensorPasteurisasi2Controller;
use App\Http\Controllers\Api\SensorDissolverController;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('signin/login');
});

Route::get('menu', function () {
    return view('menu/menu');
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
    Route::get('/boiler/data-filter', [SensorBoilerController::class, 'getFilteredBoilerData']);
    Route::get('/boiler-data', [SensorBoilerController::class, 'getBoilerData']);

    Route::get('/boiler/data-harian', [SensorBoilerController::class, 'getBoilerDataHarian']);
    Route::get('/boiler/data-mingguan', [SensorBoilerController::class, 'getBoilerDataMingguan']);
    Route::get('/boiler-realtime', [SensorBoilerController::class, 'getSensorData']);
});

Route::prefix('daily-tank')->group(function () {
    Route::view('/realtime', 'dailytank.realtime');
    Route::view('/datatren', 'dailytank.datatren');
    Route::get('/data-harian', [SensorDailyTankController::class, 'getDailyTankDataHarian']);
    Route::get('/data-mingguan', [SensorDailyTankController::class, 'getDailyTankDataMingguan']);
    Route::get('/data-realtime', [SensorDailyTankController::class, 'getLatestData']);
    Route::get('/data', [SensorDailyTankController::class, 'getDailytankData']);
});
Route::prefix('glucose')->group(function () {
    Route::view('/realtime', 'glucose.realtime');
    Route::view('/datatren', 'glucose.datatren');
    Route::get('/data-harian', [SensorGlucoseController::class, 'getGlucoseDataHarian']);
    Route::get('/data-mingguan', [SensorGlucoseController::class, 'getGlucoseDataMingguan']);
    Route::get('/data-realtime', [SensorGlucoseController::class, 'getLatestData']);
    Route::get('/data', [SensorGlucoseController::class, 'getGlucoseData']);
});


Route::prefix('olahsari')->group(function () {
    Route::view('/realtime', 'olahsari.realtime');
    Route::view('/datatren', 'olahsari.datatren');
    Route::get('/data-harian', [SensorOlahsariController::class, 'getOlahsariDataHarian']);
    Route::get('/data-mingguan', [SensorOlahsariController::class, 'getOlahsariDataMingguan']);
    Route::get('/data-realtime', [SensorOlahsariController::class, 'getLatestData']);
    Route::get('/data', [SensorOlahsariController::class, 'getOlahsariData']);
});
Route::prefix('pasteurisasi1')->group(function () {
    Route::view('/realtime-pasteurizer', 'pasteurisasi1.realtimePasteurizer');
    Route::view('/realtime-vacuum', 'pasteurisasi1.realtimeVacuum');
    Route::view('/realtime-mixing', 'pasteurisasi1.realtimeMixing');
    Route::view('/datatren', 'pasteurisasi1.datatren');
    Route::get('/data-harian', [SensorPasteurisasi1Controller::class, 'getPasteurisasi1DataHarian']);
    Route::get('/data-mingguan', [SensorPasteurisasi1Controller::class, 'getPasteurisasi1DataMingguan']);
    Route::get('/data-realtime', [SensorPasteurisasi1Controller::class, 'getLatestData']);
    Route::get('/data', [SensorPasteurisasi1Controller::class, 'getPasteurisasi1Data']);
});
Route::prefix('pasteurisasi2')->group(function () {
    Route::view('/realtime', 'pasteurisasi2.realtime');
    Route::view('/datatren', 'pasteurisasi2.datatren');
    Route::get('/data-realtime', [SensorPasteurisasi2Controller::class, 'getLatestData']);
    Route::view('/datatren', 'pasteurisasi2.datatren');
    Route::get('/data', [SensorPasteurisasi2Controller::class, 'getPasteurisasi2Data']);
});
Route::prefix('st53')->group(function () {
    Route::view('/datatren', 'st53.datatren');
    Route::view('/realtime-tankA', 'st53.realtime-tankA');
    Route::view('/realtime-tankB', 'st53.realtime-tankB');
    Route::view('/realtime-tankC', 'st53.realtime-tankC');
    Route::view('/realtime-tankD', 'st53.realtime-tankD');
    Route::get('/data-realtime', [SensorST53Controller::class, 'getLatestData']);
    Route::get('/data', [SensorST53Controller::class, 'getST53Data']);
});
Route::prefix('stk400')->group(function () {
    Route::view('/realtime', 'stk400.realtime');
    Route::view('/datatren', 'stk400.datatren');
    Route::get('/data-realtime', [SensorSTK400Controller::class, 'getLatestData']);
    Route::get('/data', [SensorSTk400Controller::class, 'getSTK400Data']);
});

Route::prefix('dissolver')->group(function () {
    Route::view('/realtime', 'dissolver.realtime');
    Route::view('/datatren', 'dissolver.datatren');
    Route::get('/data-realtime', [SensorDissolverController::class, 'getLatestData']);
    Route::get('/data/{dissolver}', [SensorDissolverController::class, 'getData']);
});
