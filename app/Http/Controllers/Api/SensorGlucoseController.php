<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Glucose\GlucoseModel;
class SensorGlucoseController extends Controller
{
    public function getLatestData()
    {
        $latestData = GlucoseModel::orderBy('waktu', 'desc')
            ->first();

        return response()->json([
            'GST1'  => $latestData ? $latestData->GST1 : 0,
            'GST2'  => $latestData ? $latestData->GST2 : 0,
            'GST3'  => $latestData ? $latestData->GST3 : 0,
            'GST4'  => $latestData ? $latestData->GST4 : 0,
            'GST5'  => $latestData ? $latestData->GST5 : 0,
        
           
        ]);
    }

    public function getGlucoseData()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data Glucose berhasil diambil',
            'data' => GlucoseModel::getLatestData(20)
        ]);
    }

    //filter
    public function getGlucoseDataHarian(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $data = GlucoseModel::whereDate('waktu', $tanggal)
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

    public function getGlucoseDataMingguan(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $data = GlucoseModel::whereBetween('waktu', [$tanggalMulai, $tanggalSelesai])
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
