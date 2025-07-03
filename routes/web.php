<?php

use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\QCController;
use App\Http\Controllers\EngineeringController;
use App\Http\Controllers\Api\RetailD1Controller;
use App\Http\Controllers\Api\RetailD2Controller;
use App\Http\Controllers\Api\RetailD4Controller;
use App\Http\Controllers\Api\RetailD3Controller;
use App\Http\Controllers\Api\RetailD5Controller;
use App\Http\Controllers\Api\RetailD6Controller;
use App\Http\Controllers\Api\RetailD7Controller;
use App\Http\Controllers\Api\AllRetailController;
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
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('signin/login');
});

Route::get('menu', function () {
    return view('menu/menu');
});
Route::get('form', function () {
    return view('pemakaian_air');
});


//PRD
Route::prefix('prd')->middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dept_head/dashboard', [ProduksiController::class, 'dashboardProduksi']);
    Route::get('/dept_head/dashboard_retaild1', [ProduksiController::class, 'dashboardProduksi_retaild1']);
    Route::get('/dept_head/dashboard_retaild2', [ProduksiController::class, 'dashboardProduksi_retaild2']);
    Route::get('/dept_head/dashboard_retaild4', [ProduksiController::class, 'dashboardProduksi_retaild4']);
    Route::get('/dept_head/dashboard_retaild3', [ProduksiController::class, 'dashboardProduksi_retaild3']);
    Route::get('/dept_head/dashboard_retaild5', [ProduksiController::class, 'dashboardProduksi_retaild5']);
    Route::get('/dept_head/dashboard_retaild6', [ProduksiController::class, 'dashboardProduksi_retaild6']);
    Route::get('/dept_head/dashboard_retaild7', [ProduksiController::class, 'dashboardProduksi_retaild7']);
    Route::get('/dept_head/menu_retail', [ProduksiController::class, 'Menu_retail']);
    Route::get('/dept_head/menu_variant', [ProduksiController::class, 'Menu_all_variant']);
    Route::get('/dept_head/all/retail', [ProduksiController::class, 'Dashboard_all_retail']);
    Route::get('/supervisor/dashboard', [ProduksiController::class, 'dashboardSupervisorProduksi']);
    Route::get('/foreman/dashboard', [ProduksiController::class, 'dashboardForemanProduksi']);
    Route::get('/operator/dashboard', [ProduksiController::class, 'dashboardOperatorProduksi']);


    Route::get('/operator/detailbatch', [ProduksiController::class, 'showOperatorProduksi']);
    Route::get('/operator/form_retail', [ProduksiController::class, 'Form_Retail']);

    Route::get('/operator/history', [ProduksiController::class, 'historyBatch']);
    Route::get('/operator/status_running', [ProduksiController::class, 'statusRunning']);

    // Data Achievement batch
    Route::get('/achievement', [ProduksiController::class, 'AchievementBatch'])->name('achievement.batch');
    Route::get('/achievement/harian', [ProduksiController::class, 'AchievementBatchHarian'])->name('achievement.harian');
    Route::get('/achievement/mingguan', [ProduksiController::class, 'AchievementBatchMingguan'])->name('achievement.mingguan');
    Route::get('/achievement/bulanan', [ProduksiController::class, 'AchievementBatchBulanan'])->name('achievement.bulanan');

    // CRUD Batch Produksi
    Route::get('/batch', [ProduksiController::class, 'index'])->name('batch.index'); // Menampilkan semua batch
    Route::get('/batch-completed', [ProduksiController::class, 'indexCompleted'])->name('batch.index-completed'); // Menampilkan semua batch
    Route::post('/batch/store', [ProduksiController::class, 'storeBatch'])->name('batch.store'); // Simpan batch baru
    Route::get('/operator/batch/{id}', [ProduksiController::class, 'showOperatorProduksi'])->name('operator.batch.show');
    Route::put('/batch/{id}/update-status', [ProduksiController::class, 'updateStatus'])->name('batch.updateStatus'); // Update status batch
    Route::delete('/delete/batch/{id}', [ProduksiController::class, 'destroy'])->name('batch.destroy'); // Hapus batch

    // CRUD Shift untuk setiap Batch
    Route::post('/batch/{batch_id}/shift/store', [ProduksiController::class, 'storeBatchDetail'])->name('batch.shift.store'); // Tambah shift
    Route::get('/batch/{batch_id}/shift', [ProduksiController::class, 'getShiftData'])->name('batch.shift.get'); // Ambil data shift
    Route::delete('/batch/shift/{id}', [ProduksiController::class, 'deleteShift'])->name('batch.shift.delete'); // Hapus shift
    Route::put('/batch/shift/update/{shiftId}', [ProduksiController::class, 'updateShift'])->name('batch.shift.update');

    // CRUD Status Running
    Route::get('/status-running', [ProduksiController::class, 'StatusRunningList'])->name('statusrunning.read');
    Route::get('/data/status-running', [ProduksiController::class, 'getLastData_statusRunning'])->name('statusrunning.data');
    Route::post('/status-running/store', [ProduksiController::class, 'storeStatusRunning'])->name('statusrunning.store');
    Route::delete('/status-running/delete/{id}', [ProduksiController::class, 'destroyStatusRunning'])->name('statusrunning.destroy');
    Route::put('/status-running/update/{id}', [ProduksiController::class, 'updateStatusRunning'])->name('statusrunning.update');

    //crud form retail
    Route::post('/store/varian/retail', [ProduksiController::class, 'store_retail_varian']);
    Route::post('/store/shift/retail', [ProduksiController::class, 'store_data_shift']);
});
//End PRD

//QC
Route::prefix('qc')->middleware('auth')->group(function () {
    // Dashboard 
    Route::get('/dept_head/dashboard', [QCController::class, 'dashboardQC']);
    Route::get('/supervisor/dashboard', [QCController::class, 'dashboardSupervisorQC']);
    Route::get('/foreman/dashboard', [QCController::class, 'dashboardForemanQC']);
    Route::get('/operator/dashboard', [QCController::class, 'dashboardOperatorQC']);

    Route::get('/operator/detail/{id}', [QCController::class, 'detailAfterCoolingOperatorQC']);
    Route::get('/operator/list', [QCController::class, 'listAfterCoolingOperatorQC']);
    Route::get('/data/status', [QCController::class, 'AfterCoolingCompleted']);

    // CRUD 
    Route::get('/data', [QCController::class, 'index'])->name('aftercooling.index'); // Ambil semua data
    Route::get('/all/data', [QCController::class, 'showData'])->name('aftercooling.show'); // Ambil semua data
    Route::post('/data/store', [QCController::class, 'storeData'])->name('aftercooling.store'); // Simpan data baru
    Route::delete('/data/{id}', [QCController::class, 'deleteData'])->name('aftercooling.destroy'); // Hapus data

    // CRDU Detail
    Route::get('/detail/{id}', [QCController::class, 'getDetail'])->name('aftercoolingdetail.show');
    Route::post('/detail/store/{id}', [QCController::class, 'storeDetail'])->name('aftercoolingdetail.store');
    Route::put('/detail/update/{id}', [QCController::class, 'updateDetail'])->name('aftercoolingdetail.update');
    Route::delete('/detail/delete/{id}', [QCController::class, 'deleteDetail'])->name('aftercoolingdetail.delete');

    //Api after cooling
    Route::get('/api/olahaftercooling', [QCController::class, 'olahAfterCooling'])->name('aftercooling.olah');
    Route::get('/api/statistikaftercooling', [QCController::class, 'statistik'])->name('aftercooling.statistik');
    Route::get('/api/chartaftercooling', [QCController::class, 'getChartData'])->name('aftercooling.chart');
});
//End QC


//Eng
Route::prefix('eng')->middleware('auth')->group(function () {

    Route::get('/dept_head/dashboard', [EngineeringController::class, 'dashboardEng']);
    Route::get('/dept_head/todo', [EngineeringController::class, 'todoListEng']);
    Route::get('/supervisor/dashboard', [EngineeringController::class, 'dashboardSupervisorEng']);
    Route::get('/supervisor/dashboard/utility', [EngineeringController::class, 'DashboardUtilitySupervisor']);
    Route::get('/supervisor/data/utility', [EngineeringController::class, 'DataUtilitySupervisor']);
    Route::get('/foreman/dashboard', [EngineeringController::class, 'DashboardForeman']);
    Route::get('/foreman/data/utility', [EngineeringController::class, 'DataUtilityForeman']);
    Route::get('/foreman/form', [EngineeringController::class, 'formUtilityForeman']);

    //operator
    Route::get('/operator/form', [EngineeringController::class, 'formUtility']);
    Route::get('/operator/data/utility', [EngineeringController::class, 'DataUtility']);

    // CRUD air
    Route::post('/data/air/store', [EngineeringController::class, 'storeAir'])->name('air.store'); // Simpan data baru
    Route::get('/air-area', [EngineeringController::class, 'getAirAreas']);
    Route::get('api/air/{mode}', [EngineeringController::class, 'getPemakaianAir']);
    Route::get('data/air', [EngineeringController::class, 'getPemakaianAirData']);
    Route::get('/trend-pemakaian-air', [EngineeringController::class, 'getTrendPemakaianAir']);
    Route::get('/trend-pemakaian-listrik', [EngineeringController::class, 'getTrendPemakaianListrik']);
    Route::get('/trend-pemakaian-chemical', [EngineeringController::class, 'getTrendPemakaianChemical']);
    Route::get('/top5/air', [EngineeringController::class, 'getTopJenisPemakaianAir']);
    Route::get('/top5/listrik', [EngineeringController::class, 'getTopJenisPemakaianListrik']);
    Route::get('/top5/operator/air', [EngineeringController::class, 'getTopOperatorPemakaianAir']);
    Route::get('/top5/operator/listrik', [EngineeringController::class, 'getTopOperatorPemakaianListrik']);
    Route::get('/top5/operator/chemical', [EngineeringController::class, 'getTopOperatorPemakaianChemical']);

    // CRUD chemical
    Route::post('/store/chemical', [EngineeringController::class, 'store_chemical'])->name('chemical.store'); // Simpan data baru
    Route::get('/chemical-types/{area_id}', [EngineeringController::class, 'getTypesByArea']);
    Route::get('/chemical-area', [EngineeringController::class, 'getChemicalAreas']);
    Route::get('/data/chemical', [EngineeringController::class, 'getPemakaianChemicalData']);
    // CRUD listrik
    Route::post('/data/listrik/store', [EngineeringController::class, 'storeListrik'])->name('listrik.store'); // Simpan data baru
    Route::get('/data/listrik', [EngineeringController::class, 'getPemakaianListrikData']); // Hapus data
    Route::post('/update-panel-listrik', [EngineeringController::class, 'updateListrik']);
    Route::post('/update-pemakaian-air', [EngineeringController::class, 'updateAir']);
    Route::post('/update-pemakaian-chemical', [EngineeringController::class, 'updateChemical']);

    Route::get('/export-pemakaian-listrik', [EngineeringController::class, 'exportPemakaianListrikSpreadsheet']);

    //send tele bot
    Route::get('send/tele', [EngineeringController::class, 'Notif_boiler']);
});
//End eng
Route::get('/export-pemakaian-listrik', [EngineeringController::class, 'exportPemakaianListrikSpreadsheet']);


//Warehouse
Route::prefix('wh')->group(function () {
    //dept head
    Route::get('/dept_head/dashboard', [WarehouseController::class, 'DashboardDeptHeadWarehouse']);
    //Supervisor
    Route::get('/supervisor/dashboard', [WarehouseController::class, 'DashboardSupervisorWarehouse']);
    Route::get('/supervisor/detail/p2h', [WarehouseController::class, 'DetailP2HSupervisorWarehouse']);
    //Foreman
    Route::get('/foreman/dashboard', [WarehouseController::class, 'DashboardForemanWarehouse']);
    Route::get('/foreman/form/p2h', [WarehouseController::class, 'FormP2HForeman']);
    Route::get('/foreman/detail/p2h', [WarehouseController::class, 'DetailP2HForemanWarehouse']);
    Route::get('/foreman/detail/p2h/{id}', [WarehouseController::class, 'DetailP2HForeman']);

    //forklift
    Route::get('/p2h', [WarehouseController::class, 'data_master']);
    Route::post('/p2h/store', [WarehouseController::class, 'storeP2h']);
    Route::put('/p2h/update-detail/{id}', [WarehouseController::class, 'updateDetail']);
    Route::delete('/p2h/delete/{id}', [WarehouseController::class, 'destroyP2h']);
    Route::get('/p2h/{id}/detail', [WarehouseController::class, 'formDetailP2h'])->name('p2h.detail.form');
    Route::post('/p2h/{id}/detail', [WarehouseController::class, 'storeDetailP2h'])->name('p2h.detail.store');

    //pallet
    Route::post('/p2h/store/pallet', [WarehouseController::class, 'storeP2hPalletMover']);
    Route::put('/p2h/update-detail/{id}', [WarehouseController::class, 'updateDetailPalletMover']);
    Route::delete('/p2h/delete/{id}', [WarehouseController::class, 'destroyP2hPalletMover']);

    //api
    Route::get('/p2h/summary', [WarehouseController::class, 'summary']);
    Route::get('/p2h/kelayakan', [WarehouseController::class, 'kelayakanSummary']);
    Route::get('/p2h/masalah-terbanyak', [WarehouseController::class, 'topMasalah']);
    Route::get('/p2h/operator', [WarehouseController::class, 'operatorStat']);
    Route::get('/p2h/shift', [WarehouseController::class, 'shiftDistribusi']);
    Route::get('/p2h/unit-progress', [WarehouseController::class, 'unitProgress']);
    Route::get('/p2h/masalah-berulang', [WarehouseController::class, 'masalahBerulang']);
    Route::get('/p2h/hari-ini', [WarehouseController::class, 'pemeriksaanHariIni']);
    Route::get('/p2h/data', [WarehouseController::class, 'getP2HGroupedDetail']);
    Route::get('/p2h/data/pallet/mover', [WarehouseController::class, 'getP2HGroupedDetailPalletMover']);



    Route::get('/operator/dashboard', [WarehouseController::class, 'DashboardOperatorWarehouse']);
    Route::get('/operator/detail/p2h', [WarehouseController::class, 'DetailP2HOperatorWarehouse']);


    Route::get('/check-forms', [WarehouseController::class, 'index']);
    Route::get('/check-forms/form-data', [WarehouseController::class, 'fetchFormData']);
    Route::post('/check-forms', [WarehouseController::class, 'store']);
    Route::get('/check-forms/{checkForm}', [WarehouseController::class, 'show']);
    Route::put('/check-forms/{checkForm}', [WarehouseController::class, 'update']);
    Route::delete('/check-forms/{checkForm}', [WarehouseController::class, 'destroy']);
    //

});
//end Warehouse

Route::prefix('dept_head')->group(function () {
    Route::view('/manajemen_user', 'user.dept_head.manage_user');
});

Route::prefix('users')->as('users.')->group(function () {
    Route::get('/data', [UserController::class, 'getUsers'])->name('get'); // API untuk DataTables
    Route::post('/', [UserController::class, 'store'])->name('store'); // Simpan user baru
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit'); // Ambil data user untuk edit
    Route::post('/{id}', [UserController::class, 'update'])->name('update'); // Update user
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy'); // Hapus user
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
    Route::get('/rhtemp', [SensorBoilerController::class, 'getAbnormalPeriodsRHTemp']);
    Route::get('/lhtemp', [SensorBoilerController::class, 'getAbnormalPeriodsLHTemp']);
    Route::get('/pvsteam', [SensorBoilerController::class, 'getAbnormalPeriodsPVSteam']);
    Route::get('/levelfeedwater', [SensorBoilerController::class, 'getAbnormalPeriodsLevelFeedWater']);
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
    Route::get('/suhuheating', [SensorPasteurisasi1Controller::class, 'getAbnormalPeriodsSuhuHeating']);
    Route::get('/suhuholding', [SensorPasteurisasi1Controller::class, 'getAbnormalPeriodsSuhuHolding']);
    Route::get('/flowrate', [SensorPasteurisasi1Controller::class, 'getAbnormalPeriodsFlowRate']);
});

Route::prefix('pasteurisasi2')->group(function () {
    Route::view('/realtime', 'pasteurisasi2.realtime');
    Route::get('/data-realtime', [SensorPasteurisasi2Controller::class, 'getLatestData']);
    Route::get('/data-harian', [SensorPasteurisasi2Controller::class, 'getPasteurisasi2DataHarian']);
    Route::get('/data-mingguan', [SensorPasteurisasi2Controller::class, 'getPasteurisasi2DataMingguan']);
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

    //
    Route::get('/data/all/retail', [AllRetailController::class, 'data_retail_all_varian']);
});
