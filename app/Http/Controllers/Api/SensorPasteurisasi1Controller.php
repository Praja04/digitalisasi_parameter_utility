<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasteurisasi1\Sensor_Pasteurisasi1;
class SensorPasteurisasi1Controller extends Controller
{
    //
    public function getLatestData($field)
    {
        // Pastikan field yang diminta ada dalam database
        $allowedFields = [
            'Batch', 'LevelBT1', 'BT1AM', 'LevelBT2', 'SuhuCooling',
            'TimeDivert', 'Flowrate', 'SuhuHeating', 'SuhuHolding',
            'MixingAM', 'Mode', 'PCV1', 'SpeedPompaMixing',
            'SuhuPrecooling', 'SuhuPreheating','PressToPasteur', 'PressureBT2', 'PressureMixing',
            'SpeedPumpBT1', 'SpeedPumpBT2', 'SpeedPumpVD',
            'Storage', 'Varian', 'LevelVD', 'VDAM',
            'PressVDHH', 'PressVDLL'
        ];

        if (!in_array($field, $allowedFields)) {
            return response()->json(['error' => 'Invalid field'], 400);
        }

        // Ambil data terbaru berdasarkan waktu
        $data = Sensor_Pasteurisasi1::select($field)
            ->orderBy('Waktu', 'desc')
            ->first();

        return response()->json([$field => $data ? $data->$field : 0]);
    }
}
