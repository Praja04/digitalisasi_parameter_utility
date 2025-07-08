<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Retail\retail_d8;
use Illuminate\Http\Request;
use Carbon\Carbon;
class RetailD8Controller extends Controller
{
    //
    //
    // buatkan fungsi ambil 1 data terakhir dari tabel retail_d8
    public function getLastData()
    {
        // Ambil data terakhir dari tabel retail_d8
        $data = retail_d8::orderBy('ts', 'desc')->first();

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

        $query = retail_d8::query();

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

        $periods = retail_d8::getMesinStopPeriods($filter, $start, $end);

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
        $uptime = retail_d8::getTotalMesinRunningMinutesByShift($filter, $start, $end);

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
        $uptime = retail_d8::getTotalMesinDowntimeByShift($filter, $start, $end);

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
        $data = retail_d8::getPerformanceOutput($tanggal);

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
        $data = retail_d8::getAllShiftPerformanceOutput($tanggal);

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
        $data = retail_d8::getPerformanceGagalFilling($tanggal);

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
            $durasi = retail_d8::getStartMesinDurasiPerShift($today);

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
            $durasi = retail_d8::getStartMesinDurasiPerShift($date);

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
                $durasi = retail_d8::getStartMesinDurasiPerShift($tanggal);

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
            $durasi = retail_d8::getOffMesinDurasiPerShift($hariIni);

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
            $durasi = retail_d8::getOffMesinDurasiPerShift($tgl);

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
                $durasi = retail_d8::getOffMesinDurasiPerShift($tgl);

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
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $hasil = [];

        if ($filter === 'realtime') {
            $now = Carbon::now('Asia/Jakarta');
            $tanggal = $now->toDateString(); // hari ini WIB
            $durasi = retail_d8::getStartMesinDurasiPerShift($tanggal);

            // Tentukan awal dan akhir shift dalam WIB
            $shift1_awal = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal 06:00:00", 'Asia/Jakarta');
            $shift2_awal = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal 14:00:01", 'Asia/Jakarta');
            $shift3_awal = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal 22:00:01", 'Asia/Jakarta');
            $shift3_akhir = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($tanggal)->addDay()->format('Y-m-d') . ' 05:59:59', 'Asia/Jakarta');

            // Hitung menit berjalan hanya jika sekarang berada dalam range shift-nya
            $menit_shift1 = ($now->between($shift1_awal, $shift2_awal)) ? $shift1_awal->diffInMinutes($now) : 420;
            $menit_shift2 = ($now->between($shift2_awal, $shift3_awal)) ? $shift2_awal->diffInMinutes($now) : 420;
            $menit_shift3 = ($now->between($shift3_awal, $shift3_akhir)) ? $shift3_awal->diffInMinutes($now) : 420;

            $hasil = [
                'shift1' => [
                    'menit_shift' => $menit_shift1,
                    'shift1_detik' => $durasi['shift1_detik'],
                    'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / max($menit_shift1, 1) : 0,
                ],
                'shift2' => [
                    'menit_shift' => $menit_shift2,
                    'shift2_detik' => $durasi['shift2_detik'],
                    'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / max($menit_shift2, 1) : 0,
                ],
                'shift3' => [
                    'menit_shift' => $menit_shift3,
                    'shift3_detik' => $durasi['shift3_detik'],
                    'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / max($menit_shift3, 1) : 0,
                ]
            ];
        }

        return response()->json([
            "result" => $hasil
        ]);
    }

    public function durasiStopMesinPerShiftRealtime(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|in:realtime,tanggal,range',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
        ]);

        $filter = $request->input('filter', 'realtime');
        $start = $request->input('start');
        $end = $request->input('end');

        $hasil = [];

        if ($filter === 'realtime') {
            $now = Carbon::now('Asia/Jakarta');
            $tanggal = $now->toDateString(); // hari ini WIB
            $durasi = retail_d8::getOffMesinDurasiPerShift($tanggal);

            // Tentukan awal dan akhir shift dalam WIB
            $shift1_awal = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal 06:00:00", 'Asia/Jakarta');
            $shift2_awal = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal 14:00:01", 'Asia/Jakarta');
            $shift3_awal = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal 22:00:01", 'Asia/Jakarta');
            $shift3_akhir = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($tanggal)->addDay()->format('Y-m-d') . ' 05:59:59', 'Asia/Jakarta');

            // Hitung menit berjalan hanya jika sekarang berada dalam range shift-nya
            $menit_shift1 = ($now->between($shift1_awal, $shift2_awal)) ? $shift1_awal->diffInMinutes($now) : 420;
            $menit_shift2 = ($now->between($shift2_awal, $shift3_awal)) ? $shift2_awal->diffInMinutes($now) : 420;
            $menit_shift3 = ($now->between($shift3_awal, $shift3_akhir)) ? $shift3_awal->diffInMinutes($now) : 420;

            $hasil = [
                'shift1' => [
                    'menit_shift' => $menit_shift1,
                    'shift1_detik' => $durasi['shift1_detik'],
                    'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / max($menit_shift1, 1) : 0,
                ],
                'shift2' => [
                    'menit_shift' => $menit_shift2,
                    'shift2_detik' => $durasi['shift2_detik'],
                    'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / max($menit_shift2, 1) : 0,
                ],
                'shift3' => [
                    'menit_shift' => $menit_shift3,
                    'shift3_detik' => $durasi['shift3_detik'],
                    'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / max($menit_shift3, 1) : 0,
                ]
            ];
        }

        return response()->json([
            "result" => $hasil
        ]);
    }
}
