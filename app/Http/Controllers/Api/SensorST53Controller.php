<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ST53\ST53Model;
class SensorST53Controller extends Controller
{
    public function getLatestData()
{
    $latestData = ST53Model::orderBy('id', 'desc')->first();

    if (!$latestData) {
        return response()->json(['error' => 'No data found'], 404);
    }

    return response()->json([
        'A1' => $latestData->A1 / 1000,
        'A2' => $latestData->A2 / 1000,
        'A3' => $latestData->A3 / 1000,
        'A4' => $latestData->A4 / 1000,
        'A5' => $latestData->A5 / 1000,
        'B1' => $latestData->B1 / 1000,
        'B2' => $latestData->B2 / 1000,
        'B3' => $latestData->B3 / 1000,
        'B4' => $latestData->B4 / 1000,
        'B5' => $latestData->B5 / 1000,
        'C1' => $latestData->C1 / 1000,
        'C2' => $latestData->C2 / 1000,
        'C3' => $latestData->C3 / 1000,
        'C4' => $latestData->C4 / 1000,
        'C5' => $latestData->C5 / 1000,
        'D1' => $latestData->D1 / 1000,
        'D2' => $latestData->D2 / 1000,
        'D3' => $latestData->D3 / 1000,
        'D4' => $latestData->D4 / 1000,
        'D5' => $latestData->D5 / 1000,
    ]);
}
    public function getST53Data()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data ST53 berhasil diambil',
            'data' => ST53Model::getLatestData(20)
        ]);
    }

     //filter
     public function getST53DataHarian(Request $request)
     {
         $tanggal = $request->input('tanggal');
 
         $data = ST53Model::whereDate('waktu', $tanggal)
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
 
     public function getST53DataMingguan(Request $request)
     {
         $tanggalMulai = $request->input('tanggal_mulai');
         $tanggalSelesai = $request->input('tanggal_selesai');
 
         $data = ST53Model::whereBetween('waktu', [$tanggalMulai, $tanggalSelesai])
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
