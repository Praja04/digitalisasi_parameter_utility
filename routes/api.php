<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorPasteurisasi1Controller;
use App\Http\Controllers\Api\SensorBoilerController;

Route::prefix('pasteurisasi1')->group(function () {

// Daily report PDF
Route::post('/report/daily', [SensorPasteurisasi1Controller::class, 'generateDailyReport']);
});

Route::prefix('sensor')->group(function () {
    Route::get('/boiler/data-filter', [SensorBoilerController::class, 'getFilteredBoilerData']);
    Route::get('/boiler-data', [SensorBoilerController::class, 'getBoilerData']);

    Route::get('/boiler/data-harian', [SensorBoilerController::class, 'getBoilerDataHarian']);
    Route::get('/boiler/data-mingguan', [SensorBoilerController::class, 'getBoilerDataMingguan']);
    Route::get('/boiler-realtime', [SensorBoilerController::class, 'getSensorData']);
    Route::get('/rhtemp', [SensorBoilerController::class, 'getAbnormalPeriodsRHTemp']);
    Route::get('/lhtemp', [SensorBoilerController::class, 'getAbnormalPeriodsLHTemp']);
    Route::get('/pvsteam', [SensorBoilerController::class, 'getAbnormalPeriodsPVSteam']);
    Route::get('/levelfeedwater', [SensorBoilerController::class, 'getAbnormalPeriodsLevelFeedWater']);
});
