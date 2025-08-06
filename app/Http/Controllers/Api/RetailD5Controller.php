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
    // buatkan fungsi ambil 1 data terakhir dari tabel retail_d5
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


    // buatkan fungsi menghitung rata-rata dari main_speed saja berdasarkan ts, dengan 3 filter yaitu realtime hari ini, lalu pilih tanggal, dan range tanggal
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



    public function getNozzleCount(Request $request)
    {
        $request->validate([
            'filter' => 'required|in:realtime,tanggal,range',
            'tanggal' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $dates = [];

        if ($request->filter === 'realtime') {
            $dates[] = Carbon::today()->toDateString();
        } elseif ($request->filter === 'tanggal') {
            $dates[] = Carbon::parse($request->tanggal)->toDateString();
        } elseif ($request->filter === 'range') {
            $start = Carbon::parse($request->start_date);
            $end = Carbon::parse($request->end_date);
            for (
                $date = $start;
                $date->lte($end);
                $date->addDay()
            ) {
                $dates[] = $date->toDateString();
            }
        }

        $shiftCounts = retail_d5_nozzle1::getNozzleCountPerShift($dates);
        $shiftCounts2 = retail_d5_nozzle2::getNozzleCountPerShift($dates);

        return response()->json([
            'total_nozzle_1' => $shiftCounts['shift_1']['nozzle_1'] + $shiftCounts['shift_2']['nozzle_1'] + $shiftCounts['shift_3']['nozzle_1'],
            'total_nozzle_2' => $shiftCounts2['shift_1']['nozzle_2'] + $shiftCounts2['shift_2']['nozzle_2'] + $shiftCounts2['shift_3']['nozzle_2'],
            'shift_1' => [
                'nozzle_1' => $shiftCounts['shift_1']['nozzle_1'],
                'nozzle_2' => $shiftCounts2['shift_1']['nozzle_2'],
            ],
            'shift_2' => [
                'nozzle_1' => $shiftCounts['shift_2']['nozzle_1'],
                'nozzle_2' => $shiftCounts2['shift_2']['nozzle_2'],
            ],
            'shift_3' => [
                'nozzle_1' => $shiftCounts['shift_3']['nozzle_1'],
                'nozzle_2' => $shiftCounts2['shift_3']['nozzle_2'],
            ],
        ]);
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


    //performance mesin

    public function getTotalMesinRunningMinutes(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|in:realtime,tanggal,range',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
        ]);

        $filter = $request->input('filter', 'realtime');
        $start = $request->input('start');
        $end = $request->input('end');

        // Ambil total menit dan uptime untuk masing-masing shift
        $uptime = retail_d5::getTotalMesinRunningMinutesByShift($filter, $start, $end);

        return response()->json([
            'shift1_uptime' => $uptime['shift1_uptime'],
            'shift2_uptime' => $uptime['shift2_uptime'],
            'shift3_uptime' => $uptime['shift3_uptime'],
        ]);
    }

    public function getTotalMesinStopMinutes(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|in:realtime,tanggal,range',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
        ]);

        $filter = $request->input('filter', 'realtime');
        $start = $request->input('start');
        $end = $request->input('end');

        // Ambil total menit dan uptime untuk masing-masing shift
        $uptime = retail_d5::getTotalMesinDowntimeByShift($filter, $start, $end);

        return response()->json([
            'shift1_downtime' => $uptime['shift1_downtime'],
            'shift2_downtime' => $uptime['shift2_downtime'],
            'shift3_downtime' => $uptime['shift3_downtime'],
        ]);
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



    /////test



    public function durasiStartMesinPerShift(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|in:realtime,tanggal,range',
            'tanggal' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $filter = $request->input('filter', 'realtime');
        $tanggal = $request->input('tanggal');
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $hasil = [];

        if ($filter === 'realtime') {
            $today = Carbon::now()->toDateString();
            $durasi = retail_d5::getStartMesinDurasiPerShift($today);

            $hasil = [
                'shift1' => [
                    'shift1_detik' => $durasi['shift1_detik'],
                    'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / 420 : 0,
                ],
                'shift2' => [
                    'shift2_detik' => $durasi['shift2_detik'],
                    'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / 420 : 0,
                ],
                'shift3' => [
                    'shift3_detik' => $durasi['shift3_detik'],
                    'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / 420 : 0,
                ]
            ];
        } elseif ($filter === 'tanggal' && $tanggal) {
            $date = Carbon::parse($tanggal)->toDateString();
            $durasi = retail_d5::getStartMesinDurasiPerShift($date);

            $hasil = [
                'shift1' => [
                    'shift1_detik' => $durasi['shift1_detik'],
                    'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / 420 : 0,
                ],
                'shift2' => [
                    'shift2_detik' => $durasi['shift2_detik'],
                    'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / 420 : 0,
                ],
                'shift3' => [
                    'shift3_detik' => $durasi['shift3_detik'],
                    'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / 420 : 0,
                ]
            ];
        } elseif ($filter === 'range' && $start && $end) {
            $periode = [];
            $mulai = Carbon::parse($start);
            $selesai = Carbon::parse($end);

            while ($mulai->lte($selesai)) {
                $tanggal = $mulai->toDateString();
                $durasi = retail_d5::getStartMesinDurasiPerShift($tanggal);

                $periode[$tanggal] = [
                    'shift1' => [
                        'shift1_detik' => $durasi['shift1_detik'],
                        'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / 420 : 0,
                    ],
                    'shift2' => [
                        'shift2_detik' => $durasi['shift2_detik'],
                        'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / 420 : 0,
                    ],
                    'shift3' => [
                        'shift3_detik' => $durasi['shift3_detik'],
                        'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / 420 : 0,
                    ]
                ];

                $mulai->addDay();
            }

            $hasil = $periode;
        }

        return response()->json([
            'result' => $hasil
        ]);
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
        $tanggal = $request->input('tanggal');
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $hasil = [];

        if ($filter === 'realtime') {
            $hariIni = Carbon::now()->toDateString();
            $durasi = retail_d5::getOffMesinDurasiPerShift($hariIni);

            $hasil = [
                'shift1' => [
                    'shift1_detik' => $durasi['shift1_detik'],
                    'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / 420 : 0,
                ],
                'shift2' => [
                    'shift2_detik' => $durasi['shift2_detik'],
                    'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / 420 : 0,
                ],
                'shift3' => [
                    'shift3_detik' => $durasi['shift3_detik'],
                    'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / 420 : 0,
                ]
            ];
        } elseif ($filter === 'tanggal' && $tanggal) {
            $tgl = Carbon::parse($tanggal)->toDateString();
            $durasi = retail_d5::getOffMesinDurasiPerShift($tgl);

            $hasil = [
                'shift1' => [
                    'shift1_detik' => $durasi['shift1_detik'],
                    'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / 420 : 0,
                ],
                'shift2' => [
                    'shift2_detik' => $durasi['shift2_detik'],
                    'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / 420 : 0,
                ],
                'shift3' => [
                    'shift3_detik' => $durasi['shift3_detik'],
                    'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / 420 : 0,
                ]
            ];
        } elseif ($filter === 'range' && $start && $end) {
            $periode = [];
            $mulai = Carbon::parse($start);
            $selesai = Carbon::parse($end);

            while ($mulai->lte($selesai)) {
                $tgl = $mulai->toDateString();
                $durasi = retail_d5::getOffMesinDurasiPerShift($tgl);

                $periode[$tgl] = [
                    'shift1' => [
                        'shift1_detik' => $durasi['shift1_detik'],
                        'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / 420 : 0,
                    ],
                    'shift2' => [
                        'shift2_detik' => $durasi['shift2_detik'],
                        'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / 420 : 0,
                    ],
                    'shift3' => [
                        'shift3_detik' => $durasi['shift3_detik'],
                        'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / 420 : 0,
                    ]
                ];

                $mulai->addDay();
            }

            $hasil = $periode;
        }

        return response()->json([
            'result' => $hasil
        ]);
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
}
