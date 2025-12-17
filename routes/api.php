<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorPasteurisasi1Controller;
use App\Http\Controllers\Api\SensorBoilerController;

use App\Http\Controllers\Api\RetailD1Controller;
use App\Http\Controllers\Api\RetailD2Controller;
use App\Http\Controllers\Api\RetailD4Controller;
use App\Http\Controllers\Api\RetailD3Controller;
use App\Http\Controllers\Api\RetailD5Controller;
use App\Http\Controllers\Api\RetailD6Controller;
use App\Http\Controllers\Api\RetailD7Controller;
use App\Http\Controllers\Api\RetailD8Controller;
use App\Http\Controllers\Api\RetailD9Controller;
use App\Http\Controllers\Api\RetailD10Controller;
use App\Http\Controllers\Api\RetailD14Controller;
use App\Http\Controllers\Api\AllRetailController;
use App\Http\Controllers\Api\SensorDailyTankController;
use App\Http\Controllers\Api\SensorGlucoseController;
use App\Http\Controllers\Api\SensorOlahSariController;
use App\Http\Controllers\Api\SensorST53Controller;
use App\Http\Controllers\Api\SensorSTk400Controller;
use App\Http\Controllers\Api\SensorPasteurisasi2Controller;
use App\Http\Controllers\Api\SensorDissolverController;
Route::prefix('pasteurisasi1')->group(function () {

// Daily report PDF
Route::post('/report/daily', [SensorPasteurisasi1Controller::class, 'generateDailyReport']);
});


//// Mesin ///////
Route::prefix('sensor')->group(function () {

    Route::get('/pvsteamprd/data', [SensorBoilerController::class, 'getdataPVsteam_prd_boiler']);
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
Route::get('/kondensat/data', [SensorBoilerController::class, 'getKondensatData']);





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
    Route::get('/suhuheating', [SensorPasteurisasi1Controller::class, 'getAbnormalPeriodsSuhuHeating']);
    Route::get('/suhuholding', [SensorPasteurisasi1Controller::class, 'getAbnormalPeriodsSuhuHolding']);
    Route::get('/flowrate', [SensorPasteurisasi1Controller::class, 'getAbnormalPeriodsFlowRate']);
    Route::get('/status/divert', [SensorPasteurisasi1Controller::class, 'checkDivertStatus']);
    Route::post('/report/daily', [SensorPasteurisasi1Controller::class, 'generateDailyReport'])->name('report.pasteurisasi.daily');
});

Route::prefix('pasteurisasi2')->group(function () {
    Route::view('/realtime', 'pasteurisasi2.realtime');
    Route::view('/datatren', 'pasteurisasi2.datatren');
    Route::get('/data-harian', [SensorPasteurisasi2Controller::class, 'getPasteurisasi1DataHarian']);
    Route::get('/data-mingguan', [SensorPasteurisasi2Controller::class, 'getPasteurisasi1DataMingguan']);
    Route::get('/data-realtime', [SensorPasteurisasi2Controller::class, 'getLatestData']);
    Route::get('/data', [SensorPasteurisasi2Controller::class, 'getPasteurisasi1Data']);
    Route::get('/suhuheating', [SensorPasteurisasi2Controller::class, 'getAbnormalPeriodsSuhuHeating']);
    Route::get('/suhuholding', [SensorPasteurisasi2Controller::class, 'getAbnormalPeriodsSuhuHolding']);
    Route::get('/flowrate', [SensorPasteurisasi2Controller::class, 'getAbnormalPeriodsFlowRate']);
});

Route::prefix('st53')->group(function () {
    Route::view('/datatren', 'st53.datatren');
    Route::view('/realtime-tankA', 'st53.realtime-tankA');
    Route::view('/realtime-tankB', 'st53.realtime-tankB');
    Route::view('/realtime-tankC', 'st53.realtime-tankC');
    Route::view('/realtime-tankD', 'st53.realtime-tankD');
    Route::get('/data-realtime', [SensorST53Controller::class, 'getLatestData']);
    Route::get('/data', [SensorST53Controller::class, 'getST53Data']);
    Route::get('/data-harian', [SensorST53Controller::class, 'getST53DataHarian']);
    Route::get('/data-mingguan', [SensorST53Controller::class, 'getST53DataMingguan']);
});

Route::prefix('stk400')->group(function () {
    Route::view('/realtime', 'stk400.realtime');
    Route::view('/datatren', 'stk400.datatren');
    Route::get('/data-realtime', [SensorSTK400Controller::class, 'getLatestData']);
    Route::get('/data', [SensorSTk400Controller::class, 'getSTK400Data']);
    Route::get('/data-harian', [SensorSTk400Controller::class, 'getSTK400DataHarian']);
    Route::get('/data-mingguan', [SensorSTk400Controller::class, 'getSTK400DataMingguan']);
});

Route::prefix('dissolver')->group(function () {
    Route::view('/realtime', 'dissolver.realtime');
    Route::view('/datatren', 'dissolver.datatren');
    Route::get('/data-realtime', [SensorDissolverController::class, 'getLatestData']);
    Route::get('/data/{dissolver}', [SensorDissolverController::class, 'getData']);
});

//retail
Route::prefix('retail')->group(function () {
    //retail d1
    Route::get('/d1/last', [RetailD1Controller::class, 'getLastData']);
    Route::get('/d1/output/performance', [RetailD1Controller::class, 'getperformanceOutput']);
    Route::get('/d1/output/performance/all_shift', [RetailD1Controller::class, 'getperformanceOutputAllShift']);
    Route::get('/d1/mesin-stop-periods', [RetailD1Controller::class, 'getMesinStopPeriods']);
    Route::get('/d1/average-main-speed', [RetailD1Controller::class, 'getAverageMainSpeed']);
    Route::get('/d1/mesin/start/realtime', [RetailD1Controller::class, 'durasiStartMesinPerShiftRealtime']);
    Route::get('/d1/mesin/start', [RetailD1Controller::class, 'durasiStartMesinPerShift']);
    Route::get('/d1/mesin/stop/realtime', [RetailD1Controller::class, 'durasiStopMesinPerShiftRealtime']);
    Route::get('/d1/mesin/stop', [RetailD1Controller::class, 'durasiOffMesinPerShift']);
    Route::get('/d1/nozzle-count', [RetailD1Controller::class, 'getNozzleCount']);
    Route::get('/d1/output/gagal/filling', [RetailD1Controller::class, 'getGagalFilling']);

    //retail d2
    Route::get('/d2/last', [RetailD2Controller::class, 'getLastData']);
    Route::get('/d2/output/performance', [RetailD2Controller::class, 'getperformanceOutput']);
    Route::get('/d2/output/performance/all_shift', [RetailD2Controller::class, 'getperformanceOutputAllShift']);
    Route::get('/d2/mesin-stop-periods', [RetailD2Controller::class, 'getMesinStopPeriods']);
    Route::get('/d2/average-main-speed', [RetailD2Controller::class, 'getAverageMainSpeed']);
    Route::get('/d2/mesin/start/realtime', [RetailD2Controller::class, 'durasiStartMesinPerShiftRealtime']);
    Route::get('/d2/mesin/start', [RetailD2Controller::class, 'durasiStartMesinPerShift']);
    Route::get('/d2/mesin/stop/realtime', [RetailD2Controller::class, 'durasiStopMesinPerShiftRealtime']);
    Route::get('/d2/mesin/stop', [RetailD2Controller::class, 'durasiOffMesinPerShift']);
    Route::get('/d2/nozzle-count', [RetailD2Controller::class, 'getNozzleCount']);
    Route::get('/d2/output/gagal/filling', [RetailD2Controller::class, 'getGagalFilling']);


    //retail d4
    Route::get('/d4/last', [RetailD4Controller::class, 'getLastData']);
    Route::get('/d4/output/performance', [RetailD4Controller::class, 'getperformanceOutput']);
    Route::get('/d4/output/performance/all_shift', [RetailD4Controller::class, 'getperformanceOutputAllShift']);
    Route::get('/d4/mesin-stop-periods', [RetailD4Controller::class, 'getMesinStopPeriods']);
    Route::get('/d4/average-main-speed', [RetailD4Controller::class, 'getAverageMainSpeed']);
    Route::get('/d4/mesin/start/realtime', [RetailD4Controller::class, 'durasiStartMesinPerShiftRealtime']);
    Route::get('/d4/mesin/start', [RetailD4Controller::class, 'durasiStartMesinPerShift']);
    Route::get('/d4/mesin/stop/realtime', [RetailD4Controller::class, 'durasiStopMesinPerShiftRealtime']);
    Route::get('/d4/mesin/stop', [RetailD4Controller::class, 'durasiOffMesinPerShift']);
    Route::get('/d4/nozzle-count', [RetailD4Controller::class, 'getNozzleCount']);
    Route::get('/d4/output/gagal/filling', [RetailD4Controller::class, 'getGagalFilling']);


    //retaill d3
    Route::get('/d3/last', [RetailD3Controller::class, 'getLastData']);
    Route::get('/d3/output/performance', [RetailD3Controller::class, 'getperformanceOutput']);
    Route::get('/d3/output/performance/all_shift', [RetailD3Controller::class, 'getperformanceOutputAllShift']);
    Route::get('/d3/mesin-stop-periods', [RetailD3Controller::class, 'getMesinStopPeriods']);
    Route::get('/d3/average-main-speed', [RetailD3Controller::class, 'getAverageMainSpeed']);
    Route::get('/d3/mesin/start/realtime', [RetailD3Controller::class, 'durasiStartMesinPerShiftRealtime']);
    Route::get('/d3/mesin/start', [RetailD3Controller::class, 'durasiStartMesinPerShift']);
    Route::get('/d3/mesin/stop/realtime', [RetailD3Controller::class, 'durasiStopMesinPerShiftRealtime']);
    Route::get('/d3/mesin/stop', [RetailD3Controller::class, 'durasiOffMesinPerShift']);
    Route::get('/d3/nozzle-count', [RetailD3Controller::class, 'getNozzleCount']);
    Route::get('/d3/output/gagal/filling', [RetailD3Controller::class, 'getGagalFilling']);

    //retail d5
    Route::get('/d5/last', [RetailD5Controller::class, 'getLastData']);
    Route::get('/d5/output/performance', [RetailD5Controller::class, 'getperformanceOutput']);
    Route::get('/d5/output/performance/all_shift', [RetailD5Controller::class, 'getperformanceOutputAllShift']);
    Route::get('/d5/mesin-stop-periods', [RetailD5Controller::class, 'getMesinStopPeriods']);
    Route::get('/d5/average-main-speed', [RetailD5Controller::class, 'getAverageMainSpeed']);
    Route::get('/d5/mesin/start/realtime', [RetailD5Controller::class, 'durasiStartMesinPerShiftRealtime']);
    Route::get('/d5/mesin/start', [RetailD5Controller::class, 'durasiStartMesinPerShift']);
    Route::get('/d5/mesin/stop/realtime', [RetailD5Controller::class, 'durasiStopMesinPerShiftRealtime']);
    Route::get('/d5/mesin/stop', [RetailD5Controller::class, 'durasiOffMesinPerShift']);
    Route::get('/d5/nozzle-count', [RetailD5Controller::class, 'getNozzleCount']);
    Route::get('/d5/output/gagal/filling', [RetailD5Controller::class, 'getGagalFilling']);

    //retail d6
    Route::get('/d6/last', [RetailD6Controller::class, 'getLastData']);
    Route::get('/d6/output/performance', [RetailD6Controller::class, 'getperformanceOutput']);
    Route::get('/d6/output/performance/all_shift', [RetailD6Controller::class, 'getperformanceOutputAllShift']);
    Route::get('/d6/mesin-stop-periods', [RetailD6Controller::class, 'getMesinStopPeriods']);
    Route::get('/d6/average-main-speed', [RetailD6Controller::class, 'getAverageMainSpeed']);
    Route::get('/d6/mesin/start/realtime', [RetailD6Controller::class, 'durasiStartMesinPerShiftRealtime']);
    Route::get('/d6/mesin/start', [RetailD6Controller::class, 'durasiStartMesinPerShift']);
    Route::get('/d6/mesin/stop/realtime', [RetailD6Controller::class, 'durasiStopMesinPerShiftRealtime']);
    Route::get('/d6/mesin/stop', [RetailD6Controller::class, 'durasiOffMesinPerShift']);
    Route::get('/d6/nozzle-count', [RetailD6Controller::class, 'getNozzleCount']);
    Route::get('/d6/output/gagal/filling', [RetailD6Controller::class, 'getGagalFilling']);

    //retail d7
    Route::get('/d7/last', [RetailD7Controller::class, 'getLastData']);
    Route::get('/d7/output/performance', [RetailD7Controller::class, 'getperformanceOutput']);
    Route::get('/d7/output/performance/all_shift', [RetailD7Controller::class, 'getperformanceOutputAllShift']);
    Route::get('/d7/mesin-stop-periods', [RetailD7Controller::class, 'getMesinStopPeriods']);
    Route::get('/d7/average-main-speed', [RetailD7Controller::class, 'getAverageMainSpeed']);
    Route::get('/d7/mesin/start/realtime', [RetailD7Controller::class, 'durasiStartMesinPerShiftRealtime']);
    Route::get('/d7/mesin/start', [RetailD7Controller::class, 'durasiStartMesinPerShift']);
    Route::get('/d7/mesin/stop/realtime', [RetailD7Controller::class, 'durasiStopMesinPerShiftRealtime']);
    Route::get('/d7/mesin/stop', [RetailD7Controller::class, 'durasiOffMesinPerShift']);
    Route::get('/d7/nozzle-count', [RetailD7Controller::class, 'getNozzleCount']);
    Route::get('/d7/output/gagal/filling', [RetailD7Controller::class, 'getGagalFilling']);

    //retail d8
    Route::get('/d8/last', [RetailD8Controller::class, 'getLastData']);
    Route::get('/d8/output/performance', [RetailD8Controller::class, 'getperformanceOutput']);
    Route::get('/d8/output/performance/all_shift', [RetailD8Controller::class, 'getperformanceOutputAllShift']);
    Route::get('/d8/mesin-stop-periods', [RetailD8Controller::class, 'getMesinStopPeriods']);
    Route::get('/d8/average-main-speed', [RetailD8Controller::class, 'getAverageMainSpeed']);
    Route::get('/d8/mesin/start/realtime', [RetailD8Controller::class, 'durasiStartMesinPerShiftRealtime']);
    Route::get('/d8/mesin/start', [RetailD8Controller::class, 'durasiStartMesinPerShift']);
    Route::get('/d8/mesin/stop/realtime', [RetailD8Controller::class, 'durasiStopMesinPerShiftRealtime']);
    Route::get('/d8/mesin/stop', [RetailD8Controller::class, 'durasiOffMesinPerShift']);
    Route::get('/d8/nozzle-count', [RetailD8Controller::class, 'getNozzleCount']);
    Route::get('/d8/output/gagal/filling', [RetailD8Controller::class, 'getGagalFilling']);

    //retail d9
    Route::get('/d9/last', [RetailD9Controller::class, 'getLastData']);
    Route::get('/d9/output/performance', [RetailD9Controller::class, 'getperformanceOutput']);
    Route::get('/d9/output/performance/all_shift', [RetailD9Controller::class, 'getperformanceOutputAllShift']);
    Route::get('/d9/mesin-stop-periods', [RetailD9Controller::class, 'getMesinStopPeriods']);
    Route::get('/d9/average-main-speed', [RetailD9Controller::class, 'getAverageMainSpeed']);
    Route::get('/d9/mesin/start/realtime', [RetailD9Controller::class, 'durasiStartMesinPerShiftRealtime']);
    Route::get('/d9/mesin/start', [RetailD9Controller::class, 'durasiStartMesinPerShift']);
    Route::get('/d9/mesin/stop/realtime', [RetailD9Controller::class, 'durasiStopMesinPerShiftRealtime']);
    Route::get('/d9/mesin/stop', [RetailD9Controller::class, 'durasiOffMesinPerShift']);
    Route::get('/d9/nozzle-count', [RetailD9Controller::class, 'getNozzleCount']);
    Route::get('/d9/output/gagal/filling', [RetailD9Controller::class, 'getGagalFilling']);

    //retail d10
    Route::get('/d10/last', [RetailD10Controller::class, 'getLastData']);
    Route::get('/d10/output/performance', [RetailD10Controller::class, 'getperformanceOutput']);
    Route::get('/d10/output/performance/all_shift', [RetailD10Controller::class, 'getperformanceOutputAllShift']);
    Route::get('/d10/mesin-stop-periods', [RetailD10Controller::class, 'getMesinStopPeriods']);
    Route::get('/d10/average-main-speed', [RetailD10Controller::class, 'getAverageMainSpeed']);
    Route::get('/d10/mesin/start/realtime', [RetailD10Controller::class, 'durasiStartMesinPerShiftRealtime']);
    Route::get('/d10/mesin/start', [RetailD10Controller::class, 'durasiStartMesinPerShift']);
    Route::get('/d10/mesin/stop/realtime', [RetailD10Controller::class, 'durasiStopMesinPerShiftRealtime']);
    Route::get('/d10/mesin/stop', [RetailD10Controller::class, 'durasiOffMesinPerShift']);
    Route::get('/d10/nozzle-count', [RetailD10Controller::class, 'getNozzleCount']);
    Route::get('/d10/output/gagal/filling', [RetailD10Controller::class, 'getGagalFilling']);

    //retail d14
    Route::get('/d14/last', [RetailD14Controller::class, 'getLastData']);
    Route::get('/d14/output/performance', [RetailD14Controller::class, 'getperformanceOutput']);
    Route::get('/d14/output/performance/all_shift', [RetailD14Controller::class, 'getperformanceOutputAllShift']);
    Route::get('/d14/mesin-stop-periods', [RetailD14Controller::class, 'getMesinStopPeriods']);
    Route::get('/d14/average-main-speed', [RetailD14Controller::class, 'getAverageMainSpeed']);
    Route::get('/d14/mesin/start/realtime', [RetailD14Controller::class, 'durasiStartMesinPerShiftRealtime']);
    Route::get('/d14/mesin/start', [RetailD14Controller::class, 'durasiStartMesinPerShift']);
    Route::get('/d14/mesin/stop/realtime', [RetailD14Controller::class, 'durasiStopMesinPerShiftRealtime']);
    Route::get('/d14/mesin/stop', [RetailD14Controller::class, 'durasiOffMesinPerShift']);
    Route::get('/d14/nozzle-count', [RetailD14Controller::class, 'getNozzleCount']);
    Route::get('/d14/output/gagal/filling', [RetailD14Controller::class, 'getGagalFilling']);

    //
    Route::get('/data/all/retail', [AllRetailController::class, 'data_retail_all_varian']);
});