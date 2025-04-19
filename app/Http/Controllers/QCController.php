<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QC\AfterCooling;
use App\Models\QC\AfterCoolingDetail;
use Illuminate\Support\Facades\Session;

class QCController extends Controller
{
    //
    // 🔹 Dashboard untuk Dept Head
    public function dashboardQC()
    {
        if (Session::get('jabatan') !== 'dept_head') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.dept_head.dashboard_qc');
    }

    // 🔹 Dashboard untuk Operator
    public function dashboardOperatorQC()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'qc') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.qc.dashboard_qc');
    }

    public function detailAfterCoolingOperatorQC($id)
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'qc') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $data = AfterCooling::with('details')->findOrFail($id);
        return view('user.operator.qc.detail_after_cooling',compact('data'));
    }

    public function listAfterCoolingOperatorQC(){
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'qc') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.qc.list_after_cooling');
    }

    public function index()
    {
        $data = AfterCooling::withCount('details') // hitung jumlah detail
            ->having('details_count', '<', 3)      // hanya yang kurang dari 3 detail
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($data);
    }

    // 🔹 Simpan Data Baru (Store)
    public function storeData(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        try {
            // Simpan batch baru
            $nama_user = Session::get('username');
            $data = AfterCooling::create([
                'tanggal' => $request->tanggal,
                'created_by_user' => $nama_user,
            ]);

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showData()
    {
        $data = AfterCooling::with('details')->get();
        return response()->json($data);
    }

    public function deleteData(Request $request, $id)
    {
        $data = AfterCooling::findOrFail($id);
        $data->details()->delete();
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus!'
        ]);
    }



    public function storeDetail(Request $request, $id)
    {
        $data = AfterCooling::findOrFail($id);
        $request->validate([
            'viscositas' => 'required|numeric',
            'brix' => 'required|numeric',
            'ph' => 'required|numeric',
            'bj' => 'required|numeric',
            'aw' => 'required|numeric',
            'buih' => 'required|numeric',
            'endapan' => 'required',
            'organo' => 'required',
            'warna' => 'required',
            'shift' => 'required|integer|min:1|max:3',
        ]);
        // Cek apakah shift sudah ada
        $existingShift = AfterCoolingDetail::where('id_after_cooling', $data->id)
            ->where('shift', $request->shift)
            ->exists();

        if ($existingShift) {
            return response()->json([
                'message' => 'Sudah ada dalam shift tersebut!',
                'status' => 'error'
            ], 400);
        }

        $dataDetail = AfterCoolingDetail::create([
            'id_after_cooling' => $data->id,
            'viscositas' => $request->viscositas,
            'brix' => $request->brix,
            'ph' => $request->ph,
            'bj' => $request->bj,
            'aw' => $request->aw,
            'buih' => $request->buih,
            'endapan' => $request->endapan,
            'organo' => $request->organo,
            'warna' => $request->warna,
            'shift' => $request->shift,
            'created_by_user' => session('username')
        ]);

         // Cek apakah semua shift (1,2,3) sudah ada
         $totalShifts = AfterCoolingDetail::where('id_after_cooling', $id)->count();

         if ($totalShifts === 3) {
             // Update status batch menjadi completed
             AfterCooling::where('id', $id)->update(['status' => 'completed']);
         }

        return response()->json([
            'success' => true,
            'message' => 'Data After Cooling shift ini berhasil ditambahkan!',
            'data' => $dataDetail
        ]);
    }

    public function getDetail($id)
    {
        $shifts = AfterCoolingDetail::where('id_after_cooling', $id)->get();
        return response()->json($shifts);
    }

    public function updateDetail(Request $request, $id_detail)
    {
        $request->validate([
            'viscositas' => 'required|numeric',
            'brix' => 'required|numeric',
            'ph' => 'required|numeric',
            'bj' => 'required|numeric',
            'aw' => 'required|numeric',
            'buih' => 'required|numeric',
            'endapan' => 'required|numeric',
            'organo' => 'required|string',
            'shift' => 'required|integer|min:1|max:3',
        ]);

        $detail = AfterCoolingDetail::findOrFail($id_detail);
        $detail->update([
            'viscositas' => $request->viscositas,
            'brix' => $request->brix,
            'ph' => $request->ph,
            'bj' => $request->bj,
            'aw' => $request->aw,
            'buih' => $request->buih,
            'endapan' => $request->endapan,
            'organo' => $request->organo,
            'shift' => $request->shift,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data detail berhasil diupdate!',
            'data' => $detail
        ]);
    }

    public function deleteDetail($id_detail)
    {
        $detail = AfterCoolingDetail::findOrFail($id_detail);
        $detail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Detail berhasil dihapus!'
        ]);
    }

    public function AfterCoolingCompleted()
    {
        $completedCount = AfterCooling::where('status', 'completed')->count();
        $notCompletedCount = AfterCooling::where('status', '!=', 'completed')->count();

        return response()->json([
            'completed' => $completedCount,
            'not_completed' => $notCompletedCount
        ]);
    }
}
