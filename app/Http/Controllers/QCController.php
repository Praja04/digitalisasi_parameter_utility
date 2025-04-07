<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QC\AfterCooling;
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
         return view('user.operator.dashboard_qc');
     }


     public function index()
     {
         $batches = AfterCooling::orderBy('created_at', 'desc')->get();
         return response()->json($batches);
     }
 
     // 🔹 Simpan Data Baru (Store)
     public function storeData(Request $request)
     {
         // Validasi input
         $request->validate([
             'viscositas' => 'required|numeric',
             'brix' => 'required|numeric',
             'ph' => 'required|numeric', // Gunakan numeric, karena pH bisa desimal
             'bj' => 'required|numeric',
             'aw' => 'required|numeric', // Gunakan numeric, karena aw bisa desimal
             'buih' => 'required|numeric',
             'endapan' => 'required|numeric',
         ]);
 
         try {
             // Gunakan session atau auth untuk mendapatkan nama user
             $nama_user = Session::get('username');
 
             // Simpan data baru
             $data = AfterCooling::create([
                 'user' => $nama_user,
                 'viscositas' => $request->viscositas,
                 'brix' => $request->brix,
                 'ph' => $request->ph,
                 'bj' => $request->bj,
                 'aw' => $request->aw,
                 'buih' => $request->buih,
                 'endapan' => $request->endapan,
             ]);
 
             return response()->json(['success' => true, 'data' => $data], 201);
         } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 500);
         }
     }
 
  
 
     // 🔹 Update Data (Update)
     public function update(Request $request, $id)
     {
         // Validasi input
         $request->validate([
             'viscositas' => 'required|numeric',
             'brix' => 'required|numeric',
             'ph' => 'required|numeric',
             'bj' => 'required|numeric',
             'aw' => 'required|numeric',
             'buih' => 'required|numeric',
             'endapan' => 'required|numeric',
         ]);
 
         $data = AfterCooling::find($id);
 
         if (!$data) {
             return response()->json(['error' => 'Data tidak ditemukan'], 404);
         }
 
         try {
             $data->update([
                 'viscositas' => $request->viscositas,
                 'brix' => $request->brix,
                 'ph' => $request->ph,
                 'bj' => $request->bj,
                 'aw' => $request->aw,
                 'buih' => $request->buih,
                 'endapan' => $request->endapan,
             ]);
 
             return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui!', 'data' => $data]);
         } catch (\Exception $e) {
             return response()->json(['error' => 'Gagal memperbarui data', 'message' => $e->getMessage()], 500);
         }
     }
 
     // 🔹 Hapus Data (Destroy)
     public function destroy($id)
     {
         $data = AfterCooling::find($id);
 
         if (!$data) {
             return response()->json(['error' => 'Data tidak ditemukan'], 404);
         }
 
         try {
             $data->delete();
             return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
         } catch (\Exception $e) {
             return response()->json(['error' => 'Gagal menghapus data', 'message' => $e->getMessage()], 500);
         }
     }
}
