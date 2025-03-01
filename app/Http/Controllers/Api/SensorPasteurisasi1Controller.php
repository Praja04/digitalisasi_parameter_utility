<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasteurisasi1\Sensor_Pasteurisasi1;

class SensorPasteurisasi1Controller extends Controller
{
    //
    public function getLatestData()
    {
        // Ambil data terbaru berdasarkan waktu
        $latestData = Sensor_Pasteurisasi1::orderBy('Waktu', 'desc')->first();

        return response()->json($latestData);
    }

    public function getPasteurisasi1Data()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data Pasteurisasi1 berhasil diambil',
            'data' => Sensor_Pasteurisasi1::getLatestData(20)
        ]);
    }

     //filter
     public function getPasteurisasi1DataHarian(Request $request)
     {
         $tanggal = $request->input('tanggal');
 
         $data = Sensor_Pasteurisasi1::whereDate('waktu', $tanggal)
             ->orderBy('waktu', 'asc')
             ->get();
 
         if ($data->isEmpty()) {
             return response()->json([
                 'success' => false,
                 'message' => 'Data untuk tanggal ini tidak ditemukan',
                 'data' => []
             ]);
         }
 
         return response()->json([
             'success' => true,
             'message' => 'Data harian berhasil diambil',
             'data' => $data
         ]);
     }
 
     public function getPasteurisasi1DataMingguan(Request $request)
     {
         $tanggalMulai = $request->input('tanggal_mulai');
         $tanggalSelesai = $request->input('tanggal_selesai');
 
         $data = Sensor_Pasteurisasi1::whereBetween('waktu', [$tanggalMulai, $tanggalSelesai])
             ->orderBy('waktu', 'asc')
             ->get();
 
         if ($data->isEmpty()) {
             return response()->json([
                 'success' => false,
                 'message' => 'Data untuk rentang tanggal ini tidak ditemukan',
                 'data' => []
             ]);
         }
 
         return response()->json([
             'success' => true,
             'message' => 'Data mingguan berhasil diambil',
             'data' => $data
         ]);
     }
     //end filter
}
