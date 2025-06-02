<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\produksi\AchievementBatch;
use App\Models\produksi\StatusRunning;
use App\Models\produksi\AchievementBatchDetail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ProduksiController extends Controller
{
    // 🔹 Dashboard untuk Dept Head
    public function dashboardProduksi()
    {
        if (Session::get('jabatan') == 'dept_head') {
            return view('user.dept_head.dashboard_produksi');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    public function dashboardProduksi_retaild4()
    {
        if (Session::get('jabatan') == 'dept_head') {
            return view('user.dept_head.Retail.dashboard_retaild4');  
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    public function dashboardProduksi_retaild3()
    {
        if (Session::get('jabatan') == 'dept_head') {
            return view('user.dept_head.Retail.dashboard_retaild3');  
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    public function dashboardProduksi_retaild5()
    {
        if (Session::get('jabatan') == 'dept_head') {
            return view('user.dept_head.Retail.dashboard_retaild5');  
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    public function dashboardProduksi_retaild6()
    {
        if (Session::get('jabatan') == 'dept_head') {
            return view('user.dept_head.Retail.dashboard_retaild6');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    public function Menu_retail()
    {
        if (Session::get('jabatan') == 'dept_head') {
            return view('user.dept_head.Retail.menu');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    ///////////End View Dept Head ///////////////////

    // 🔹 Dashboard untuk Supervisor
    public function dashboardSupervisorProduksi()
    {
        if (Session::get('jabatan') == 'supervisor') {
            return view('user.supervisor.prd.dashboard_produksi');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    ///////////End View Supervisor ///////////////////


    // 🔹 Dashboard untuk foreman
    public function dashboardForemanProduksi()
    {
        if (Session::get('jabatan') == 'foreman') {
            return view('user.foreman.prd.dashboard_prd');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    ///////////End View foreman ///////////////////

    /////////////// 🔹 Dashboard untuk Operator //////////////////
    public function dashboardOperatorProduksi()
    {
        if (Session::get('jabatan') == 'operator') {
            return view('user.operator.prd.dashboard_prd');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    public function showOperatorProduksi($id)
    {
        if (Session::get('jabatan') == 'operator' || Session::get('jabatan') == 'foreman') {
            $batch = AchievementBatch::with('details')->findOrFail($id);
            return view('user.operator.prd.show_prd', compact('batch'));
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    ////////////End View Operator /////////////////










    // Menampilkan data history batch status completed
    public function historyBatch()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'produksi') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.prd.history_batch_prd');
    }

    public function statusRunning()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'produksi') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.prd.status_running');
    }

    //////////////////End operator layout/////////
    // 🔹 Menampilkan Semua Batch
    public function index()
    {

        $batches = AchievementBatch::with(['details' => function ($query) {
            $query->selectRaw('achievement_batch_id, SUM(batch_count) as total_batch_count')
                ->groupBy('achievement_batch_id');
        }])
            ->orderBy('batch_date', 'desc')
            ->get();

        // Menambahkan total_batch_count langsung di collection
        $batches->each(function ($batch) {
            $batch->total_batch_count = $batch->details->sum('total_batch_count');
            unset($batch->details); // Jika tidak ingin menampilkan details
        });

        return response()->json($batches);
    }

    // Menampilkan data master dengan status completed
    public function indexCompleted()
    {
        $completedCount = AchievementBatch::where('status', 'completed')->count();
        $notCompletedCount = AchievementBatch::where('status', '!=', 'completed')->count();

        return response()->json([
            'completed' => $completedCount,
            'not_completed' => $notCompletedCount
        ]);
    }

    // 🔹 Simpan Batch Baru
    public function storeBatch(Request $request)
    {
        // Validasi input
        $request->validate([
            'batch_date' => 'required|date',
            'target_batch' => 'required|integer|min:1',
        ]);

        try {
            // Simpan batch baru
            $nama_user = Session::get('username');
            $batch = AchievementBatch::create([
                'batch_code' => 'BATCH-' . now()->format('Ymd') . '-' . rand(100, 999),
                'batch_date' => $request->batch_date,
                'target_batch' => $request->target_batch,
                'status' => 'pending',
                'created_by_user' => $nama_user,  // Gantilah dengan user yang login
                'updated_by_user' => $nama_user
            ]);

            return response()->json(['success' => true, 'data' => $batch]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 🔹 Menampilkan Detail Batch
    public function show($id)
    {
        $batch = AchievementBatch::with('details')->findOrFail($id);
        return response()->json($batch);
    }

    // 🔹 Update Status Batch
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $batch = AchievementBatch::findOrFail($id);
        $batch->update(['status' => $request->status, 'updated_by_user' => session('username')]);

        return response()->json([
            'success' => true,
            'message' => 'Status batch diperbarui!',
            'data' => $batch
        ]);
    }

    // 🔹 Hapus Batch
    public function destroy($id)
    {
        $batch = AchievementBatch::findOrFail($id);
        $batch->details()->delete();
        $batch->delete();

        return response()->json([
            'success' => true,
            'message' => 'Batch berhasil dihapus!'
        ]);
    }

    // 🔹 Simpan Shift untuk Batch
    public function storeBatchDetail(Request $request, $batch_id)
    {

        $batch = AchievementBatch::findOrFail($batch_id);

        $request->validate([
            'shift' => 'required|integer|min:1|max:3',
            'batch_count' => 'required|integer|min:1',
        ]);

        // Cek apakah shift sudah ada
        $existingShift = AchievementBatchDetail::where('achievement_batch_id', $batch->id)
            ->where('shift', $request->shift)
            ->exists();

        if ($existingShift) {
            return response()->json([
                'message' => 'Shift ini sudah ada dalam batch ini!',
                'status' => 'error'
            ], 400);
        }

        $batchDetail = AchievementBatchDetail::create([
            'achievement_batch_id' => $batch_id,
            'shift' => $request->shift,
            'batch_count' => $request->batch_count,
            'created_by_user' => session('username')
        ]);

        // Cek apakah semua shift (1,2,3) sudah ada
        $totalShifts = AchievementBatchDetail::where('achievement_batch_id', $batch_id)->count();

        if ($totalShifts === 3) {
            // Update status batch menjadi completed
            AchievementBatch::where('id', $batch_id)->update(['status' => 'completed']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data batch shift berhasil ditambahkan!',
            'data' => $batchDetail
        ]);
    }


    // 🔹 Ambil Data Shift
    public function getShiftData($batch_id)
    {
        $shifts = AchievementBatchDetail::where('achievement_batch_id', $batch_id)->get();
        return response()->json($shifts);
    }

    // 🔹 Hapus Shift
    public function deleteShift($id)
    {
        $shift = AchievementBatchDetail::findOrFail($id);
        $shift->delete();

        return response()->json([
            'success' => true,
            'message' => 'Shift berhasil dihapus!'
        ]);
    }

    // update shift
    public function updateShift(Request $request, $shiftId)
    {
        $shift = AchievementBatchDetail::findOrFail($shiftId);

        $request->validate([
            'batch_count' => 'required|integer|min:1',
        ]);

        $shift->update([
            'batch_count' => $request->batch_count
        ]);

        return response()->json([
            'message' => 'Jumlah produksi berhasil diperbarui!',
            'updated_count' => $shift->batch_count
        ]);
    }


    // Api data achievement batch harian, mingguan, bulanan
    public function AchievementBatchHarian()
    {
        $today = now()->toDateString(); // atau bisa pakai Carbon::today()->format('Y-m-d');

        $data_harian = AchievementBatch::whereDate('batch_date', $today)
            ->with(['details' => function ($query) {
                $query->selectRaw('achievement_batch_id, SUM(batch_count) as total_batch_count')
                    ->groupBy('achievement_batch_id');
            }])
            ->get();

        $total_target_batch = $data_harian->sum('target_batch');
        $total_batch_count = $data_harian->map(function ($item) {
            return $item->details->sum('total_batch_count');
        })->sum();

        $achievement_percentage = $total_target_batch > 0
            ? round(($total_batch_count / $total_target_batch) * 100, 2)
            : 0;

        return response()->json([
            'date' => $today,
            'total_target_batch' => $total_target_batch,
            'total_batch_count' => $total_batch_count,
            'achievement_percentage' => $achievement_percentage
        ]);
    }

    public function AchievementBatchMingguan()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $data_mingguan = AchievementBatch::whereBetween('batch_date', [$startOfWeek, $endOfWeek])
            ->with(['details' => function ($query) {
                $query->selectRaw('achievement_batch_id, SUM(batch_count) as total_batch_count')
                    ->groupBy('achievement_batch_id');
            }])
            ->get();

        $total_target_batch = $data_mingguan->sum('target_batch');
        $total_batch_count = $data_mingguan->map(function ($item) {
            return $item->details->sum('total_batch_count');
        })->sum();

        $achievement_percentage = $total_target_batch > 0
            ? round(($total_batch_count / $total_target_batch) * 100, 2)
            : 0;

        return response()->json([
            'start_of_week' => $startOfWeek->toDateString(),
            'end_of_week' => $endOfWeek->toDateString(),
            'total_target_batch' => $total_target_batch,
            'total_batch_count' => $total_batch_count,
            'achievement_percentage' => $achievement_percentage
        ]);
    }

    public function AchievementBatchBulanan()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $data_bulanan = AchievementBatch::whereBetween('batch_date', [$startOfMonth, $endOfMonth])
            ->with(['details' => function ($query) {
                $query->selectRaw('achievement_batch_id, SUM(batch_count) as total_batch_count')
                    ->groupBy('achievement_batch_id');
            }])
            ->get();

        $total_target_batch = $data_bulanan->sum('target_batch');
        $total_batch_count = $data_bulanan->map(function ($item) {
            return $item->details->sum('total_batch_count');
        })->sum();

        $achievement_percentage = $total_target_batch > 0
            ? round(($total_batch_count / $total_target_batch) * 100, 2)
            : 0;

        return response()->json([
            'month' => now()->format('Y-m'),
            'start_of_month' => $startOfMonth->toDateString(),
            'end_of_month' => $endOfMonth->toDateString(),
            'total_target_batch' => $total_target_batch,
            'total_batch_count' => $total_batch_count,
            'achievement_percentage' => $achievement_percentage
        ]);
    }

   

    public function AchievementBatch(Request $request)
    {
        $filter = $request->get('filter', 'today');
        $startDate = null;
        $endDate = null;

        switch ($filter) {
            case 'date':
                $startDate = Carbon::parse($request->get('start_date'))->startOfDay();
                $endDate = Carbon::parse($request->get('start_date'))->endOfDay();
                break;
            case 'range':
                $startDate = Carbon::parse($request->get('start_date'))->startOfDay();
                $endDate = Carbon::parse($request->get('end_date'))->endOfDay();
                break;
            case 'today':
            default:
                $startDate = now()->startOfDay();
                $endDate = now()->endOfDay();
                break;
        }

        $data = AchievementBatch::whereBetween('batch_date', [$startDate, $endDate])
            ->with(['details'])
            ->get();

        $total_target_batch = $data->sum('target_batch');

        $total_batch_count = 0;
        $shift_counts = [
            'shift_1' => 0,
            'shift_2' => 0,
            'shift_3' => 0
        ];

        foreach ($data as $batch) {
            foreach ($batch->details as $detail) {
                $total_batch_count += $detail->batch_count;

                if ($detail->shift == 1) {
                    $shift_counts['shift_1'] += $detail->batch_count;
                } elseif ($detail->shift == 2) {
                    $shift_counts['shift_2'] += $detail->batch_count;
                } elseif ($detail->shift == 3) {
                    $shift_counts['shift_3'] += $detail->batch_count;
                }
            }
        }

        $achievement_percentage = $total_target_batch > 0
            ? round(($total_batch_count / $total_target_batch) * 100, 2)
            : 0;

        return response()->json([
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'total_target_batch' => $total_target_batch,
            'total_batch_count' => $total_batch_count,
            'achievement_percentage' => $achievement_percentage,
            'shift_counts' => $shift_counts,
        ]);
    }




    ///////////////////Status Running Produksi//////////////////
    public function getLastData_statusRunning()
    {
        $lastData = StatusRunning::orderBy('created_at', 'desc')->first();

        if ($lastData) {
            return response()->json($lastData);
        } else {
            return response()->json(['message' => 'Tidak ada data status running.'], 404);
        }
    }

    public function StatusRunningList()
    {
        $batches = StatusRunning::orderBy('created_at', 'desc')
            ->get();

        return response()->json($batches);
    }

    public function storeStatusRunning(Request $request)
    {
        // Validasi input
        $request->validate([
            'mode' => 'required|string',
            'varian' => 'required|string',
            'batch' => 'required|string',
            'storage' => 'required|string',
        ]);

        try {
            // Simpan batch baru
            $nama_user = Session::get('username');
            $data = StatusRunning::create([
                'mode' => $request->mode,
                'varian' => $request->varian,
                'batch' => $request->batch,
                'created_by' => $nama_user,  // Gantilah dengan user yang login
                'storage' => $request->storage
            ]);

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 🔹 Update Status Running
    public function updateStatusRunning(Request $request, $id)
    {
        $request->validate([
            'mode' => 'required|string',
            'varian' => 'required|string',
            'batch' => 'required|string',
            'storage' => 'required|string',
        ]);

        $data = StatusRunning::findOrFail($id);
        $data->update([
            'mode' => $request->mode,
            'varian' => $request->varian,
            'batch' => $request->batch,
            'storage' => $request->storage,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status running diperbarui!',
            'data' => $data
        ]);
    }

    // 🔹 Hapus StatusRunning
    public function destroyStatusRunning($id)
    {
        $data = StatusRunning::findOrFail($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Status running berhasil dihapus!'
        ]);
    }
}
