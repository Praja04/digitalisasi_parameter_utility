<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\produksi\AchievementBatch;
use App\Models\produksi\AchievementBatchDetail;
use Illuminate\Support\Facades\Session;

class ProduksiController extends Controller
{
    // 🔹 Dashboard untuk Dept Head
    public function dashboardProduksi()
    {
        if (Session::get('jabatan') !== 'dept_head') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.dept_head.dashboard_produksi');
    }

    // 🔹 Dashboard untuk Operator
    public function dashboardOperatorProduksi()
    {
        if (Session::get('jabatan') !== 'operator') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.dashboard_prd');
    }

    public function showOperatorProduksi($id)
    {
        if (Session::get('jabatan') !== 'operator') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $batch = AchievementBatch::with('details')->findOrFail($id);
        return view('user.operator.show_prd', compact('batch'));
    }

    // Menampilkan data history batch status completed
    public function historyBatch()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'produksi') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.history_batch_prd');
    }

    // 🔹 Menampilkan Semua Batch
    public function index()
    {
        $batches = AchievementBatch::all();
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
}
