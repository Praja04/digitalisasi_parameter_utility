<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasteurisasi2\Pasteurisasi2Model;
class SensorPasteurisasi2Controller extends Controller
{
    //
    public function getPasteurisasi2Data()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data Pasteurisasi2 berhasil diambil',
            'data' => Pasteurisasi2Model::getLatestData(20)
        ]);
    }

    public function getLatestData()
    {
        // Ambil data terbaru berdasarkan waktu
        $latestData = Pasteurisasi2Model::orderBy('Waktu', 'desc')->first();

        return response()->json($latestData);
    }
}
