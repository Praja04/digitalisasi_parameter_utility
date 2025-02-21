<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ST53\ST53Model;
class SensorST53Controller extends Controller
{
    public function getLatestData($column)
    {
        // Pastikan kolom yang diminta ada dalam model
        $allowedColumns = [
            'A1', 'A2', 'A3', 'A4', 'A5',
            'B1', 'B2', 'B3', 'B4', 'B5',
            'C1', 'C2', 'C3', 'C4', 'C5',
            'D1', 'D2', 'D3', 'D4', 'D5'
        ];

        if (!in_array($column, $allowedColumns)) {
            return response()->json(['error' => 'Kolom tidak valid'], 400);
        }

        // Ambil data terbaru berdasarkan waktu
        $latestData = ST53Model::orderBy('id', 'desc')->first();

        if ($latestData) {
            return response()->json([$column => $latestData->$column / 1000]);
        }

        return response()->json([$column => 0]); // Default jika tidak ada data
    }
}
