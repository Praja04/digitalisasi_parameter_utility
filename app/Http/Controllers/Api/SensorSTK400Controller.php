<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\STK400\STK400Model;
class SensorSTK400Controller extends Controller
{
    //
    public function getLatestData($column)
    {
        // Pastikan hanya kolom yang diperbolehkan yang dapat diakses
        $allowedColumns = ['Flowrate', 'Tank_Glucose'];

        if (!in_array($column, $allowedColumns)) {
            return response()->json(['error' => 'Kolom tidak valid'], 400);
        }

        // Ambil data terbaru berdasarkan waktu
        $latestData = STK400Model::orderBy('id', 'desc')->first();

        if ($latestData) {
            return response()->json([$column => $latestData->$column]);
        }

        return response()->json([$column => 0]); // Jika tidak ada data, set default ke 0
    }
}
