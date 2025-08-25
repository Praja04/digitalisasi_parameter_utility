<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Retail\retail_d5;
use App\Models\Retail\retail_d5_nozzle1;
use App\Models\Retail\retail_d5_nozzle2;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RetailD5Controller extends Controller
{
    //
    public function getperformanceOutputAllShift(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|in:realtime,tanggal',  // Filter yang dapat berisi 'realtime' atau 'tanggal'
            'tanggal' => 'nullable|date',                // Validasi input tanggal jika ada
        ]);

        // Ambil nilai filter dari request, default 'realtime' jika tidak ada
        $filter = $request->input('filter', 'realtime');

        // Ambil nilai tanggal dari request, jika tidak ada, set null
        $tanggal = $request->input('tanggal', null);

        // Menentukan logika berdasarkan filter yang dipilih
        if ($filter == 'realtime') {
            // Set tanggal ke hari ini menggunakan fungsi PHP `date`
            $tanggal = date('Y-m-d');  // Tanggal hari ini dalam format Y-m-d
        }

        // Ambil data berdasarkan tanggal yang sudah diset
        $data = retail_d5::getAllShiftPerformanceOutput($tanggal);

        // Kembalikan hasil dalam format JSON
        return response()->json($data);
    }

    public function getGagalFilling(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|in:realtime,tanggal',  // Filter yang dapat berisi 'realtime' atau 'tanggal'
            'tanggal' => 'nullable|date',                // Validasi input tanggal jika ada
        ]);

        // Ambil nilai filter dari request, default 'realtime' jika tidak ada
        $filter = $request->input('filter', 'realtime');

        // Ambil nilai tanggal dari request, jika tidak ada, set null
        $tanggal = $request->input('tanggal', null);

        // Menentukan logika berdasarkan filter yang dipilih
        if ($filter == 'realtime') {
            // Set tanggal ke hari ini menggunakan fungsi PHP `date`
            $tanggal = date('Y-m-d');  // Tanggal hari ini dalam format Y-m-d
        }

        // Ambil data berdasarkan tanggal yang sudah diset
        $data = retail_d5::getPerformanceGagalFilling($tanggal);

        // Kembalikan hasil dalam format JSON
        return response()->json($data);
    }
  public function getLastData()
    {
        // Ambil data terakhir dari tabel retail_d5
        $data = retail_d5::orderBy('ts', 'desc')->first();

        // Jika tidak ada data, set nilai default ke 0
        if (!$data) {
            $data = [
                "id" => 0,
                "ts" => now()->toDateTimeString(),
                "main_speed" => 0,
                "total_counter" => 0,
                "nozzle_1" => 0,
                "nozzle_2" => 0,
                "Start_Mesin" => 0
            ];
        }

        return response()->json($data);
    }

    public function getperformanceOutput(Request $request)
    {
        $tanggal = date('Y-m-d');
        // Pastikan timezone Asia/Jakarta
        $tanggal = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        // Ambil data berdasarkan tanggal yang sudah diset
        $data = retail_d5::getPerformanceOutput($tanggal);

        // Kembalikan hasil dalam format JSON
        return response()->json($data);
    }
    public function getMesinStopPeriods(Request $request)
    {
        // Ambil parameter langsung dari query string
        $filter = $request->query('filter', 'realtime');
        $tanggal = $request->query('tanggal'); // untuk filter 'tanggal'
        $start = $request->query('start_date');
        $end = $request->query('end_date');

        // Mapping untuk model
        if ($filter === 'tanggal') {
            $start = $tanggal;
        }

        $periods = retail_d5::getMesinStopPeriods($filter, $start, $end);

        $data = array_map(function ($item) {
            return [
                'ts_mulai' => $item->ts_mulai,
                'ts_akhir' => $item->ts_akhir,
            ];
        }, $periods);

        return response()->json([
            'total' => count($data),
            'data' => $data
        ]);
    }

    public function getAverageMainSpeed(Request $request)
    {
        // Validasi input
        // $request->validate([
        //     'filter' => 'required|in:realtime,tanggal,range',
        //     'tanggal' => 'nullable|date',
        //     'start_date' => 'nullable|date',
        //     'end_date' => 'nullable|date'
        // ]);

        $query = retail_d5::query();

        // Filter berdasarkan ts
        // if ($request->filter == 'realtime') {
        $query->whereDate('ts', now());
        // } elseif ($request->filter == 'tanggal') {
        //     $query->whereDate('ts', $request->tanggal);
        // } elseif ($request->filter == 'range') {
        //     $query->whereBetween('ts', [$request->start_date, $request->end_date]);
        // }

        // Hitung rata-rata main_speed, kembalikan 0 jika null
        $average = $query->avg('main_speed') ?? 0;

        return response()->json(['average_main_speed' => $average]);
    }


    public function durasiStartMesinPerShiftRealtime(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|in:realtime,tanggal,range',
            'tanggal' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $filter = $request->input('filter', 'realtime');
        $tanggal = $request->input('tanggal');
        $hasil = [];

        if ($filter === 'realtime') {
            $now = Carbon::now('Asia/Jakarta');
            $carbonDate = $tanggal ? Carbon::parse($tanggal, 'Asia/Jakarta') : $now->copy();
            $tanggalStr = $carbonDate->toDateString();

            $shifts = retail_d5::getShiftSchedule($carbonDate);
            $durasi = retail_d5::getStartMesinDurasiPerShift($tanggalStr);

            foreach ($shifts as $shift) {
                $shiftStart = $shift['start'];
                $shiftEnd = $shift['end'];

                $menitBerjalan = ($now->between($shiftStart, $shiftEnd))
                    ? $shiftStart->diffInMinutes($now)
                    : $shiftStart->diffInMinutes($shiftEnd);

                $key = strtolower(str_replace(' ', '', $shift['name']));
                $detik = $durasi[$shift['name'] . '_detik'] ?? 0;

                // Tentukan pembagi: jika belum akhir shift, pakai menitBerjalan
                $isSaturday = $carbonDate->dayOfWeek === Carbon::SATURDAY;
                $pembagi = $now->lt($shiftEnd) ? $menitBerjalan : ($isSaturday ? 300 : 420);

                $hasil[$key] = [
                    'menit_shift' => $menitBerjalan,
                    'detik' => $detik,
                    'hasil' => $detik > 0 ? ($detik / 60) / max($pembagi, 1) : 0,
                ];
            }
        }

        return response()->json(["result" => $hasil]);
    }


    public function durasiStopMesinPerShiftRealtime(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|in:realtime,tanggal,range',
            'tanggal' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $filter = $request->input('filter', 'realtime');
        $tanggal = $request->input('tanggal');
        $hasil = [];

        if ($filter === 'realtime') {
            $now = Carbon::now('Asia/Jakarta');
            $carbonDate = $tanggal ? Carbon::parse($tanggal, 'Asia/Jakarta') : $now->copy();
            $tanggalStr = $carbonDate->toDateString();

            $shifts = retail_d5::getShiftSchedule($carbonDate);
            $durasi = retail_d5::getOffMesinDurasiPerShift($tanggalStr);

            foreach ($shifts as $shift) {
                $shiftStart = $shift['start'];
                $shiftEnd = $shift['end'];

                $menitBerjalan = ($now->between($shiftStart, $shiftEnd))
                    ? $shiftStart->diffInMinutes($now)
                    : $shiftStart->diffInMinutes($shiftEnd);

                $key = strtolower(str_replace(' ', '', $shift['name']));
                $detik = $durasi[$shift['name'] . '_detik'] ?? 0;

                // Tentukan pembagi sesuai hari
                $isSaturday = $carbonDate->dayOfWeek === Carbon::SATURDAY;
                $pembagi = $isSaturday ? 300 : 420;

                $hasil[$key] = [
                    'menit_shift' => $menitBerjalan,
                    'detik' => $detik,
                    'hasil' => $detik > 0 ? ($detik / 60) / max($pembagi, 1) : 0,
                ];
            }
        }

        return response()->json(["result" => $hasil]);
    }
    public function durasiOffMesinPerShift(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|in:realtime,tanggal,range',
            'tanggal' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $filter = $request->input('filter', 'realtime');
        $hasil = [];

        if ($filter === 'realtime') {
            $tanggal = Carbon::now()->toDateString();
            $hasil = retail_d5::getOffMesinDurasiPerShift($tanggal);
        } elseif ($filter === 'tanggal' && $request->filled('tanggal')) {
            $tanggal = Carbon::parse($request->input('tanggal'))->toDateString();
            $hasil = retail_d5::getOffMesinDurasiPerShift($tanggal);
        } elseif ($filter === 'range' && $request->filled(['start_date', 'end_date'])) {
            $start = Carbon::parse($request->input('start_date'));
            $end = Carbon::parse($request->input('end_date'));
            $periode = [];

            while ($start->lte($end)) {
                $tanggal = $start->toDateString();
                $periode[$tanggal] = retail_d5::getOffMesinDurasiPerShift($tanggal);
                $start->addDay();
            }

            $hasil = $periode;
        }

        return response()->json(['result' => $hasil]);
    }

    public function durasiStartMesinPerShift(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|in:realtime,tanggal,range',
            'tanggal' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $filter = $request->input('filter', 'realtime');
        $hasil = [];

        if ($filter === 'realtime') {
            $tanggal = Carbon::now()->toDateString();
            $hasil = retail_d5::getStartMesinDurasiPerShift($tanggal);
        } elseif ($filter === 'tanggal' && $request->filled('tanggal')) {
            $tanggal = Carbon::parse($request->input('tanggal'))->toDateString();
            $hasil = retail_d5::getStartMesinDurasiPerShift($tanggal);
        } elseif ($filter === 'range' && $request->filled(['start_date', 'end_date'])) {
            $start = Carbon::parse($request->input('start_date'));
            $end = Carbon::parse($request->input('end_date'));
            $periode = [];

            while ($start->lte($end)) {
                $tanggal = $start->toDateString();
                $periode[$tanggal] = retail_d5::getStartMesinDurasiPerShift($tanggal);
                $start->addDay();
            }

            $hasil = $periode;
        }

        return response()->json(['result' => $hasil]);
    }
}
