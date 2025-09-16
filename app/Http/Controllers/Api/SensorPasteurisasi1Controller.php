<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

    public function checkDivertStatus()
    {
        $latestData = Sensor_Pasteurisasi1::orderByDesc('Waktu')->first();

        if (!$latestData) {
            return response()->json(['message' => 'Data sensor tidak ditemukan'], 404);
        }

        $suhuHeating = $latestData->SuhuHeating;
        $suhuHolding = $latestData->SuhuHolding;
        $waktu = $latestData->Waktu;

        $divert = false;
        $reason = '';

        if ($suhuHeating < 105 || $suhuHeating > 120) {
            $divert = true;
            $reason = 'Suhu Heating di luar batas normal';
        } elseif ($suhuHolding < 105 || $suhuHolding > 120) {
            $divert = true;
            $reason = 'Suhu Holding di luar batas normal';
        }

        if ($divert) {
            // Kirim notifikasi ke Telegram channel
            $botToken = env('TELEGRAM_BOT_TOKEN');
            $channelId = env('TELEGRAM_CHANNEL_ID');

            $message = "🚨 *DIVERT TERDETEKSI - Pasteurisasi Line 1*\n"
            . "📅 *Waktu:* {$waktu}\n"
            . "📌 *Status:* {$reason}\n"
            . "🌡️ *Suhu Heating:* {$suhuHeating}°C\n"
            . "🌡️ *Suhu Holding:* {$suhuHolding}°C\n"
            . "🔍 *Tindakan:* Periksa parameter pasteurisasi dan pastikan suhu kembali ke rentang aman (105–120°C)";

            Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $channelId,
                'text' => $message,
                'parse_mode' => 'Markdown'
            ]);

            return response()->json([
                'divert' => true,
                'waktu' => $waktu,
                'reason' => $reason,
                'telegram_sent' => true,
                'suhuHeating' => $suhuHeating,
                'suhuHolding' => $suhuHolding,
            ]);
        }

        return response()->json([
            'divert' => false,
            'waktu' => $waktu,
            'message' => 'Semua suhu dalam batas normal',
        ]);
    }

}
