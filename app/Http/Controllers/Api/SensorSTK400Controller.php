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
}
