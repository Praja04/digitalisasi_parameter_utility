<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasteurisasi1\Sensor_Pasteurisasi1;

class SensorPasteurisasi1Controller extends Controller
{
    //
    public function getLatestData()
    {
        // Ambil data terbaru berdasarkan waktu
        $latestData = Sensor_Pasteurisasi1::orderBy('Waktu', 'desc')->first();

        return response()->json($latestData);
    }

    public function getPasteurisasi1Data()
    {
        $data = Sensor_Pasteurisasi1::whereRaw('SECOND(waktu) = 0')
            ->latest('waktu')
            ->take(120)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Pasteurisasi1 berhasil diambil',
            'data' => $data
        ]);
       
    }

    //filter
    public function getPasteurisasi1DataHarian(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $data = Sensor_Pasteurisasi1::whereDate('waktu', $tanggal)
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

    public function getPasteurisasi1DataMingguan(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $data = Sensor_Pasteurisasi1::whereBetween('waktu', [$tanggalMulai, $tanggalSelesai])
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


    public function getAbnormalPeriodsSuhuHeating(Request $request)
    {

        $filter = $request->input('filter'); // 'today', 'date', 'range'
        $start = $request->input('start');   // jika date/range
        $end   = $request->input('end');     // jika range

        $periods = Sensor_Pasteurisasi1::getAbnormalSuhuHeatingPeriods($filter, $start, $end);

        $data = array_map(function ($item) {
            return [
                'waktu_mulai' => $item->Waktu_mulai,
                'waktu_akhir' => $item->Waktu_akhir,
            ];
        }, $periods);

        return response()->json([
            'total' => count($data),
            'data' => $data
        ]);
    }

    public function getAbnormalPeriodsSuhuHolding(Request $request)
    {

        $filter = $request->input('filter'); // 'today', 'date', 'range'
        $start = $request->input('start');   // jika date/range
        $end   = $request->input('end');     // jika range

        $periods = Sensor_Pasteurisasi1::getAbnormalSuhuHoldingPeriods($filter, $start, $end);

        $data = array_map(function ($item) {
            return [
                'waktu_mulai' => $item->Waktu_mulai,
                'waktu_akhir' => $item->Waktu_akhir,
            ];
        }, $periods);

        return response()->json([
            'total' => count($data),
            'data' => $data
        ]);
    }

    public function getAbnormalPeriodsFlowrate(Request $request)
    {

        $filter = $request->input('filter'); // 'today', 'date', 'range'
        $start = $request->input('start');   // jika date/range
        $end   = $request->input('end');     // jika range

        $periods = Sensor_Pasteurisasi1::getAbnormalFlowratePeriods($filter, $start, $end);

        $data = array_map(function ($item) {
            return [
                'waktu_mulai' => $item->Waktu_mulai,
                'waktu_akhir' => $item->Waktu_akhir,
            ];
        }, $periods);

        return response()->json([
            'total' => count($data),
            'data' => $data
        ]);
    }
}
