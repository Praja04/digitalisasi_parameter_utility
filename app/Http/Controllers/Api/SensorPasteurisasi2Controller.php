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
        $data = Pasteurisasi2Model::whereRaw('SECOND(waktu) = 0')
            ->latest('waktu')
            ->take(120)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Pasteurisasi2 berhasil diambil',
            'data' => $data
        ]);

        
    }

    public function getLatestData()
    {
        // Ambil data terbaru berdasarkan waktu
        $latestData = Pasteurisasi2Model::orderBy('Waktu', 'desc')->first();

        return response()->json($latestData);
    }


    //filter
    public function getPasteurisasi2DataHarian(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $data = Pasteurisasi2Model::whereDate('waktu', $tanggal)
            ->whereRaw('SECOND(waktu) = 0')
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

    public function getPasteurisasi2DataMingguan(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $data = Pasteurisasi2Model::whereBetween('waktu', [$tanggalMulai, $tanggalSelesai])
            ->whereRaw('SECOND(waktu) = 0')
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
