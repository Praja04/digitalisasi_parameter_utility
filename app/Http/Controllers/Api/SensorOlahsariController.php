<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Olahsari\OlahsariModel;
class SensorOlahsariController extends Controller
{
    public function getLatestData()
    {
        $latestData = OlahsariModel::orderBy('waktu', 'desc')
            ->first();
    
        return response()->json([
            'lc1' => $latestData ? $latestData->LC_Mixer1 : 0,
            'lc2' => $latestData ? $latestData->LC_Mixer2 : 0,
            'temp1' => $latestData ? $latestData->TempMixer1 : 0,
            'temp2' => $latestData ? $latestData->TempMixer2 : 0
        ]);
    }

    public function getOlahsariData()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data Olahsari berhasil diambil',
            'data' => OlahsariModel::getLatestData(20)
        ]);
    }

     //filter
     public function getOlahsariDataHarian(Request $request)
     {
         $tanggal = $request->input('tanggal');
 
         $data = OlahsariModel::whereDate('waktu', $tanggal)
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
 
     public function getOlahsariDataMingguan(Request $request)
     {
         $tanggalMulai = $request->input('tanggal_mulai');
         $tanggalSelesai = $request->input('tanggal_selesai');
 
         $data = OlahsariModel::whereBetween('waktu', [$tanggalMulai, $tanggalSelesai])
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
