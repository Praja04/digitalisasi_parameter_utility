<?php

use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\QCController;
use App\Http\Controllers\EngineeringController;
use App\Http\Controllers\Api\RetailD4Controller;
use App\Http\Controllers\Api\RetailD3Controller;
use App\Http\Controllers\Api\RetailD5Controller;
use App\Http\Controllers\Api\RetailD6Controller;
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
    Route::get('/dept_head/dashboard_retaild4', [ProduksiController::class, 'dashboardProduksi_retaild4']);
    Route::get('/dept_head/dashboard_retaild3', [ProduksiController::class, 'dashboardProduksi_retaild3']);
    Route::get('/dept_head/dashboard_retaild5', [ProduksiController::class, 'dashboardProduksi_retaild5']);
    Route::get('/dept_head/dashboard_retaild6', [ProduksiController::class, 'dashboardProduksi_retaild6']);
    Route::get('/dept_head/menu_retail', [ProduksiController::class, 'Menu_retail']);
    Route::get('/dept_head/all/retail', [ProduksiController::class, 'Dashboard_all_retail']);
    Route::get('/supervisor/dashboard', [ProduksiController::class, 'dashboardSupervisorProduksi']);
    Route::get('/foreman/dashboard', [ProduksiController::class, 'dashboardForemanProduksi']);
    Route::get('/operator/dashboard', [ProduksiController::class, 'dashboardOperatorProduksi']);


    Route::get('/operator/detailbatch', [ProduksiController::class, 'showOperatorProduksi']);
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
    Route::get('/foreman/dashboard', [EngineeringController::class, 'dashboardForemanEng']);
    Route::get('/foreman/data_listrik', [EngineeringController::class, 'dataPemakaianListrikForemanEng']);
    Route::get('/foreman/data_chemical', [EngineeringController::class, 'dataPemakaianChemicalForemanEng']);

    //foreman
    Route::get('/foreman/menu/air', [EngineeringController::class, 'menu_PemakaianAirforeman']);
    Route::get('/foreman/data_air', [EngineeringController::class, 'dataPemakaianAirforeman']);
    Route::get('/foreman/pemakaian_air', [EngineeringController::class, 'formPemakaianAirforeman']);
    Route::get('/foreman/pemakaian_listrik', [EngineeringController::class, 'formPemakaianListrikforeman']);
    Route::get('/foreman/pemakaian_chemical', [EngineeringController::class, 'formPemakaianChemicalforeman']);
    //operato
    Route::get('/operator/menu/air', [EngineeringController::class, 'menu_PemakaianAir']);
    Route::get('/operator/data_air', [EngineeringController::class, 'dataPemakaianAir']);
    Route::get('/operator/pemakaian_air', [EngineeringController::class, 'formPemakaianAir']);
    Route::get('/operator/pemakaian_listrik', [EngineeringController::class, 'formPemakaianListrik']);
    Route::get('/operator/pemakaian_chemical', [EngineeringController::class, 'formPemakaianChemical']);

    // CRUD air
    Route::get('/data/air', [EngineeringController::class, 'indexAir'])->name('air.index'); // Ambil semua data
    Route::post('/data/air/store', [EngineeringController::class, 'storeAir'])->name('air.store'); // Simpan data baru
    Route::put('/data/air/{id}/update', [EngineeringController::class, 'updateAir'])->name('air.update'); // Update status
    Route::delete('/data/air/{id}', [EngineeringController::class, 'destroyAir'])->name('air.destroy'); // Hapus data

    // CRUD chemical
    Route::get('/data/chemical', [EngineeringController::class, 'indexChemical'])->name('chemical.index'); // Ambil semua data
    Route::post('/data/chemical/store', [EngineeringController::class, 'storeChemical'])->name('chemical.store'); // Simpan data baru
    Route::put('/data/chemical/{id}/update', [EngineeringController::class, 'updateChemical'])->name('chemical.update'); // Update status
    Route::delete('/data/chemical/{id}', [EngineeringController::class, 'destroyChemical'])->name('chemical.destroy'); // Hapus data

    // CRUD listrik
    Route::get('/data/listrik', [EngineeringController::class, 'data_listrik'])->name('listrik.data'); // Ambil semua data
    Route::post('/data/listrik/store', [EngineeringController::class, 'storeListrik'])->name('listrik.store'); // Simpan data baru
    Route::put('/data/listrik/update/{id}', [EngineeringController::class, 'updateListrik'])->name('listrik.update');
    Route::get('/data/listrik/detail/{id}', [EngineeringController::class, 'DetailPemakaianListrik'])->name('listrik.data_detail'); // Ambil semua data
    Route::get('/api/listrik/detail/{id}', [EngineeringController::class, 'data_listrik_detail'])->name('listrik.data_detail_api'); // Ambil semua data
    Route::post('/data/listrik/store/detail/{id}', [EngineeringController::class, 'storeListrikDetail'])->name('listrik.store_detail'); // Simpan data baru
    Route::post('/data/listrik/update/detail/{id}', [EngineeringController::class, 'updatelistrikDetail'])->name('listrik.update_detail'); // Update status
    Route::delete('/data/listrik/delete/detail/{id}', [EngineeringController::class, 'deletelistrikDetail'])->name('listrik.destroy_detail'); // Hapus data

    // api pemakaian chemical
    Route::get('/api/chemical/harian', [EngineeringController::class, 'ApiChemicalPerHari']);
    Route::get('/api/chemical/mingguan', [EngineeringController::class, 'ApiChemicalPerMinggu']);
    Route::get('/api/chemical/bulanan', [EngineeringController::class, 'ApiChemicalPerBulan']);

    //api pemakaian air
    Route::get('api/air/{mode}', [EngineeringController::class, 'getPemakaianAir']);
    //api pemakaian listrik
    Route::get('api/listrik/{mode}', [EngineeringController::class, 'ApiListrikPerHari']);

    //send tele bot
    Route::get('send/tele', [EngineeringController::class, 'Notif_boiler']);
});
//End eng


//Warehouse
Route::prefix('wh')->group(function () {
    //dept head
    Route::get('/dept_head/dashboard', [WarehouseController::class, 'DashboardDeptHeadWarehouse']);
    //Supervisor
    Route::get('/supervisor/dashboard', [WarehouseController::class, 'DashboardSupervisorWarehouse']);
    //Foreman
    Route::get('/foreman/dashboard', [WarehouseController::class, 'DashboardForemanWarehouse']);
    Route::get('/foreman/form/p2h', [WarehouseController::class, 'FormP2HForeman']);
    Route::get('/foreman/detail/p2h/{id}', [WarehouseController::class, 'DetailP2HForeman']);

    Route::get('/p2h', [WarehouseController::class, 'data_master']);
    Route::post('/p2h/store', [WarehouseController::class, 'storeP2h']);
    Route::put('/p2h/update/{id}', [WarehouseController::class, 'updateP2h']);
    Route::delete('/p2h/delete/{id}', [WarehouseController::class, 'destroyP2h']);
    Route::get('/p2h/{id}/detail', [WarehouseController::class, 'formDetailP2h'])->name('p2h.detail.form');
    Route::post('/p2h/{id}/detail', [WarehouseController::class, 'storeDetailP2h'])->name('p2h.detail.store');

    //api
    Route::get('/p2h/summary', [WarehouseController::class, 'summary']);
    Route::get('/p2h/kelayakan', [WarehouseController::class, 'kelayakanSummary']);
    Route::get('/p2h/masalah-terbanyak', [WarehouseController::class, 'topMasalah']);
    Route::get('/p2h/operator', [WarehouseController::class, 'operatorStat']);
    Route::get('/p2h/shift', [WarehouseController::class, 'shiftDistribusi']);
    Route::get('/p2h/unit-progress', [WarehouseController::class, 'unitProgress']);
    Route::get('/p2h/masalah-berulang', [WarehouseController::class, 'masalahBerulang']);
    Route::get('/p2h/hari-ini', [WarehouseController::class, 'pemeriksaanHariIni']);



    Route::get('/operator/dashboard', [WarehouseController::class, 'DashboardOperatorWarehouse']);
    Route::get('/operator/detail/p2h/{id}', [WarehouseController::class, 'DetailP2HOperatorWarehouse']);


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
});
