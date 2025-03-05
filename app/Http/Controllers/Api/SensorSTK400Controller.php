<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\STK400\STK400Model;
class SensorSTK400Controller extends Controller
{
    //
    public function getLatestData()
    {
      
        // Ambil data terbaru berdasarkan waktu
        $latestData = STK400Model::orderBy('id', 'desc')->first();

        return response()->json([
            'Tank_Glucose'  => $latestData ? $latestData->Tank_Glucose : 0,
            'Flowrate'  => $latestData ? $latestData->Flowrate: 0
           
        ]);
    }

    public function getSTK400Data()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data STK400 berhasil diambil',
            'data' => STK400Model::getLatestData(20)
        ]);
    }

     //filter
     public function getSTK400DataHarian(Request $request)
     {
         $tanggal = $request->input('tanggal');
 
         $data = STK400Model::whereDate('waktu', $tanggal)
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
 
     public function getSTK400DataMingguan(Request $request)
     {
         $tanggalMulai = $request->input('tanggal_mulai');
         $tanggalSelesai = $request->input('tanggal_selesai');
 
         $data = STK400Model::whereBetween('waktu', [$tanggalMulai, $tanggalSelesai])
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
