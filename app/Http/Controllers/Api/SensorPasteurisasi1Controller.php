<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Pasteurisasi1\Sensor_Pasteurisasi1;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

            // Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            //     'chat_id' => $channelId,
            //     'text' => $message,
            //     'parse_mode' => 'Markdown'
            // ]);

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

    //report

    public function generateDailyReport(Request $request)
    {
        try {
            set_time_limit(300);
            ini_set('memory_limit', '512M');

            $request->validate([
                'tanggal' => 'required|date|date_format:Y-m-d'
            ]);

            $tanggal = $request->tanggal;

            // 🔹 Ambil data hourly dari Golang
            $hourlyRes = Http::timeout(30)->get("http://localhost:8080/api/pasteur/by-hour", [
                'tanggal' => $tanggal
            ]);

            // 🔹 Ambil data abnormal dari Golang
            $abnormalRes = Http::timeout(30)->get("http://localhost:8080/api/pasteur/abnormal", [
                'tanggal' => $tanggal
            ]);

            // Cek response dan parse JSON
            $hourly = $hourlyRes->successful() ? $hourlyRes->json() : ['data' => []];
            $abnormal = $abnormalRes->successful() ? $abnormalRes->json() : ['data' => []];

            // Validasi minimal ada salah satu data
            if (empty($hourly['data']) && empty($abnormal['data'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data untuk tanggal ' . Carbon::parse($tanggal)->format('d F Y')
                ], 404);
            }

            // 🔹 Generate PDF dengan Blade
            $pdf = Pdf::loadView('reports.pasteurisasi-daily', [
                'tanggal'      => $tanggal,
                'hourlyData'   => $hourly['data'] ?? [],
                'abnormalData' => $abnormal['data'] ?? []
            ]);

            $pdf->setPaper('A3', 'landscape')->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'dpi' => 150,
                'defaultPaperSize' => 'A3',
                'isRemoteEnabled' => false
            ]);

            $fileName = 'Laporan_Pasteurisasi_' . Carbon::parse($tanggal)->format('Y-m-d') . '.pdf';

            return $pdf->download($fileName);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Format tanggal tidak valid. Gunakan format Y-m-d',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error("Error connecting to Golang API: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari server',
                'error' => 'Connection timeout atau server tidak tersedia'
            ], 503);
        } catch (\Exception $e) {
            Log::error("Error generateDailyReport: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());

            return response()->json([
                    'success' => false,
                    'message' => 'Gagal generate PDF',
                    'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
                ], 500);
        }
    }



}
