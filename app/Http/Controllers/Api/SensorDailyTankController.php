<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyTank\DailyTankModel;

class SensorDailyTankController extends Controller
{
    public function getLatestData()
    {
        $latestData = DailyTankModel::orderBy('waktu', 'desc')
            ->first();

        return response()->json([
            'RO' => $latestData ? $latestData->DT_RO : 0,
            'salt' => $latestData ? $latestData->DT_Salt : 0,
            'sauceA' => $latestData ? $latestData->DT_SoySauceA : 0,
            'sauceB' => $latestData ? $latestData->DT_SoySauceB : 0,
            'sauceC' => $latestData ? $latestData->DT_SoySauceC : 0,
        ]);
    }



    public function getDailytankData()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data daily tank berhasil diambil',
            'data' => DailyTankModel::getLatestData(20)
        ]);
    }


    //filter
    public function getDailyTankDataHarian(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $data = DailyTankModel::whereDate('waktu', $tanggal)
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

    public function getDailyTankDataMingguan(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $data = DailyTankModel::whereBetween('waktu', [$tanggalMulai, $tanggalSelesai])
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
