<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorPasteurisasi1Controller;

Route::prefix('pasteurisasi1')->group(function () {

// Daily report PDF
Route::post('/report/daily', [SensorPasteurisasi1Controller::class, 'generateDailyReport']);
});