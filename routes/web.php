<?php

use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\QCController;
use App\Http\Controllers\EngineeringController;
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


Route::prefix('eng')->group(function () {
    Route::get('/dept_head/dashboard', [AuthController::class, 'dashboardEng']);
   // Route::get('/operator/dashboard', [AuthController::class, 'dashboardOperatorEng']);
    Route::get('/dept_head/todo', [AuthController::class, 'todoListEng']);
});

Route::prefix('qc')->group(function () {
    Route::get('/dept_head/dashboard', [AuthController::class, 'dashboardQc']);
    Route::get('/operator/dashboard', [AuthController::class, 'dashboardOperatorQc']);
});

//PRD
Route::prefix('prd')->middleware('auth')->group(function () {
    // Dashboard untuk Dept Head dan Operator
    Route::get('/dept_head/dashboard', [ProduksiController::class, 'dashboardProduksi']);
    Route::get('/operator/dashboard', [ProduksiController::class, 'dashboardOperatorProduksi']);
    Route::get('/operator/detailbatch', [ProduksiController::class, 'showOperatorProduksi']);
    Route::get('/operator/history', [ProduksiController::class, 'historyBatch']);
    Route::get('/operator/status_running', [ProduksiController::class, 'statusRunning']);

    // Data Achievement batch
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
    // Dashboard untuk Dept Head dan Operator
    Route::get('/dept_head/dashboard', [QCController::class, 'dashboardQC']);
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

});
//End QC


//Eng
Route::prefix('eng')->middleware('auth')->group(function () {
    Route::get('/operator/pemakaian_air', [EngineeringController::class, 'formPemakaianAir']);
    Route::get('/operator/pemakaian_listrik', [EngineeringController::class, 'formPemakaianListrik']);
    Route::get('/operator/pemakaian_chemical', [EngineeringController::class, 'formPemakaianChemical']);

    // CRUD air
    Route::get('/data/air', [EngineeringController::class, 'indexAir'])->name('air.index'); // Ambil semua data
    Route::post('/data/air/store', [EngineeringController::class, 'storeAir'])->name('air.store'); // Simpan data baru
    Route::put('/data/air/{id}/update', [EngineeringController::class, 'updateAir'])->name('air.update'); // Update status
    Route::delete('/data/air/{id}', [EngineeringController::class, 'destroyAir'])->name('air.destroy'); // Hapus data

    // CRUD listrik
    Route::get('/data/listrik', [EngineeringController::class, 'indexListrik'])->name('listrik.index'); // Ambil semua data
    Route::post('/data/listrik/store', [EngineeringController::class, 'storeListrik'])->name('listrik.store'); // Simpan data baru
    Route::put('/data/listrik/{id}/update', [EngineeringController::class, 'updateListrik'])->name('listrik.update'); // Update status
    Route::delete('/data/listrik/{id}', [EngineeringController::class, 'destroyListrik'])->name('listrik.destroy'); // Hapus data

    // CRUD chemical
    Route::get('/data/chemical', [EngineeringController::class, 'indexChemical'])->name('chemical.index'); // Ambil semua data
    Route::post('/data/chemical/store', [EngineeringController::class, 'storeChemical'])->name('chemical.store'); // Simpan data baru
    Route::put('/data/chemical/{id}/update', [EngineeringController::class, 'updateChemical'])->name('chemical.update'); // Update status
    Route::delete('/data/chemical/{id}', [EngineeringController::class, 'destroyChemical'])->name('chemical.destroy'); // Hapus data

    // api pemakaian chemical
    Route::get('/api/chemical/harian', [EngineeringController::class, 'ApiChemicalPerHari']);
    Route::get('/api/chemical/mingguan', [EngineeringController::class, 'ApiChemicalPerMinggu']);
    Route::get('/api/chemical/bulanan', [EngineeringController::class, 'ApiChemicalPerBulan']);

    //api pemakaian air
    Route::get('api/air/{mode}', [EngineeringController::class, 'getPemakaianAir']);
    Route::get('api/listrik/{mode}', [EngineeringController::class, 'getPemakaianListrik']);


});
//End eng


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
