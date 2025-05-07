<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Retail\retail_d4;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RetailController extends Controller
{
    // buatkan fungsi ambil 1 data terakhir dari tabel retail_d4
    public function getLastData()
    {
        // Ambil data terakhir dari tabel retail_d4
        $data = retail_d4::orderBy('waktu', 'desc')->first();

        // Jika tidak ada data, set nilai default ke 0
        if (!$data) {
            $data = [
                "id" => 0,
                "waktu" => now()->toDateTimeString(),
                "main_speed" => 0,
                "total_counter" => 0,
                "nozzle_1" => 0,
                "nozzle_2" => 0,
                "Start_Mesin" => 0
            ];
        }

        return response()->json($data);
    }

    //ambil data dari tabel retail_d4 berdasarkan waktu sebanyak 100 data
    public function getData()
    {
        // Ambil data dari tabel retail_d4 berdasarkan waktu sebanyak 100 data
        $data = retail_d4::orderBy('waktu', 'desc')->take(100)->get();

        // Jika tidak ada data, set nilai default ke 0
        if ($data->isEmpty()) {
            $data = [
                "id" => 0,
                "waktu" => now()->toDateTimeString(),
                "main_speed" => 0,
                "total_counter" => 0,
                "nozzle_1" => 0,
                "nozzle_2" => 0,
                "Start_Mesin" => 0
            ];
        }

        return response()->json($data);
    }
    // buatkan fungsi menghitung rata-rata dari main_speed saja berdasarkan waktu, dengan 3 filter yaitu realtime hari ini, lalu pilih tanggal, dan range tanggal
    public function getAverageMainSpeed(Request $request)
    {
        // Validasi input
        // $request->validate([
        //     'filter' => 'required|in:realtime,tanggal,range',
        //     'tanggal' => 'nullable|date',
        //     'start_date' => 'nullable|date',
        //     'end_date' => 'nullable|date'
        // ]);

        $query = retail_d4::query();

        // Filter berdasarkan waktu
        // if ($request->filter == 'realtime') {
        $query->whereDate('waktu', now());
        // } elseif ($request->filter == 'tanggal') {
        //     $query->whereDate('waktu', $request->tanggal);
        // } elseif ($request->filter == 'range') {
        //     $query->whereBetween('waktu', [$request->start_date, $request->end_date]);
        // }

        // Hitung rata-rata main_speed, kembalikan 0 jika null
        $average = $query->avg('main_speed') ?? 0;

        return response()->json(['average_main_speed' => $average]);
    }

    // buatkan fungsi menghitung jumlah keseluruhan dari total_counter saja berdasarkan waktu, dengan 3 filter yaitu realtime hari ini, lalu pilih tanggal, dan range tanggal. dan juga dibagi menjadi 3 shift, shift 1 dari 06.00 sampai 14.00, shift 2 dari 14.01 sampai 22.00,dan shift 3 dari 22.01 sampai 05.59 tanggal berikutnya
    public function getTotalCounter(Request $request)
    {
        $request->validate([
            'filter' => 'required|in:realtime,tanggal,range',
            'tanggal' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $data = retail_d4::getTotalCounterWithShifts(
            $request->filter,
            $request->tanggal,
            $request->start_date,
            $request->end_date
        );

        return response()->json($data);
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

        $shiftCounts = retail_d4::getNozzleCountPerShift($dates);

        return response()->json([
            'total_nozzle_1' => $shiftCounts['shift_1']['nozzle_1'] + $shiftCounts['shift_2']['nozzle_1'] + $shiftCounts['shift_3']['nozzle_1'],
            'total_nozzle_2' => $shiftCounts['shift_1']['nozzle_2'] + $shiftCounts['shift_2']['nozzle_2'] + $shiftCounts['shift_3']['nozzle_2'],
            'shift_1' => $shiftCounts['shift_1'],
            'shift_2' => $shiftCounts['shift_2'],
            'shift_3' => $shiftCounts['shift_3'],
        ]);
    }

    public function getMesinStartPeriods(Request $request)
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

        $periods = retail_d4::getMesinStartPeriods($filter, $start, $end);

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
        $uptime = retail_d4::getTotalMesinRunningMinutesByShift($filter, $start, $end);

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
        $uptime = retail_d4::getTotalMesinDowntimeByShift($filter, $start, $end);

        return response()->json([
            'shift1_downtime' => $uptime['shift1_downtime'],
            'shift2_downtime' => $uptime['shift2_downtime'],
            'shift3_downtime' => $uptime['shift3_downtime'],
        ]);
    }

    public function getStartPeriods(Request $request)
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
        $data = retail_d4::getDurasiMesinPerShift($tanggal);

        // Kembalikan hasil dalam format JSON
        return response()->json($data);
    }

    public function getuptime(Request $request)
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
        $data = retail_d4::getUptime($tanggal);

        // Kembalikan hasil dalam format JSON
        return response()->json($data);
    }

    public function getdowntime(Request $request)
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
        $data = retail_d4::getDownTime($tanggal);

        // Kembalikan hasil dalam format JSON
        return response()->json($data);
    }

    public function getperformanceActual(Request $request)
    {

        $tanggal = date('Y-m-d');


        // Ambil data berdasarkan tanggal yang sudah diset
        $data = retail_d4::getUptimeWithRealtime($tanggal);

        // Kembalikan hasil dalam format JSON
        return response()->json($data);
    }

    public function getperformanceOutput(Request $request)
    {
        $tanggal = date('Y-m-d');
        // Pastikan timezone Asia/Jakarta
        $tanggal = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        // Ambil data berdasarkan tanggal yang sudah diset
        $data = retail_d4::getPerformanceOutput($tanggal);

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
        $data = retail_d4::getAllShiftPerformanceOutput($tanggal);

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
        $data = retail_d4::getPerformanceGagalFilling($tanggal);

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
            $durasi = retail_d4::getStartMesinDurasiPerShift($today);

            $hasil = [
                'shift1' => [
                    'shift1_detik' => $durasi['shift1_detik'],
                    'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / 480 : 0,
                ],
                'shift2' => [
                    'shift2_detik' => $durasi['shift2_detik'],
                    'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / 480 : 0,
                ],
                'shift3' => [
                    'shift3_detik' => $durasi['shift3_detik'],
                    'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / 480 : 0,
                ]
            ];
        } elseif ($filter === 'tanggal' && $tanggal) {
            $date = Carbon::parse($tanggal)->toDateString();
            $durasi = retail_d4::getStartMesinDurasiPerShift($date);

            $hasil = [
                'shift1' => [
                    'shift1_detik' => $durasi['shift1_detik'],
                    'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / 480 : 0,
                ],
                'shift2' => [
                    'shift2_detik' => $durasi['shift2_detik'],
                    'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / 480 : 0,
                ],
                'shift3' => [
                    'shift3_detik' => $durasi['shift3_detik'],
                    'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / 480 : 0,
                ]
            ];
        } elseif ($filter === 'range' && $start && $end) {
            $periode = [];
            $mulai = Carbon::parse($start);
            $selesai = Carbon::parse($end);

            while ($mulai->lte($selesai)) {
                $tanggal = $mulai->toDateString();
                $durasi = retail_d4::getStartMesinDurasiPerShift($tanggal);

                $periode[$tanggal] = [
                    'shift1' => [
                        'shift1_detik' => $durasi['shift1_detik'],
                        'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / 480 : 0,
                    ],
                    'shift2' => [
                        'shift2_detik' => $durasi['shift2_detik'],
                        'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / 480 : 0,
                    ],
                    'shift3' => [
                        'shift3_detik' => $durasi['shift3_detik'],
                        'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / 480 : 0,
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
            $durasi = retail_d4::getOffMesinDurasiPerShift($hariIni);

            $hasil = [
                'shift1' => [
                    'shift1_detik' => $durasi['shift1_detik'],
                    'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / 480 : 0,
                ],
                'shift2' => [
                    'shift2_detik' => $durasi['shift2_detik'],
                    'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / 480 : 0,
                ],
                'shift3' => [
                    'shift3_detik' => $durasi['shift3_detik'],
                    'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / 480 : 0,
                ]
            ];
        } elseif ($filter === 'tanggal' && $tanggal) {
            $tgl = Carbon::parse($tanggal)->toDateString();
            $durasi = retail_d4::getOffMesinDurasiPerShift($tgl);

            $hasil = [
                'shift1' => [
                    'shift1_detik' => $durasi['shift1_detik'],
                    'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / 480 : 0,
                ],
                'shift2' => [
                    'shift2_detik' => $durasi['shift2_detik'],
                    'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / 480 : 0,
                ],
                'shift3' => [
                    'shift3_detik' => $durasi['shift3_detik'],
                    'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / 480 : 0,
                ]
            ];
        } elseif ($filter === 'range' && $start && $end) {
            $periode = [];
            $mulai = Carbon::parse($start);
            $selesai = Carbon::parse($end);

            while ($mulai->lte($selesai)) {
                $tgl = $mulai->toDateString();
                $durasi = retail_d4::getOffMesinDurasiPerShift($tgl);

                $periode[$tgl] = [
                    'shift1' => [
                        'shift1_detik' => $durasi['shift1_detik'],
                        'hasil' => $durasi['shift1_detik'] > 0 ? ($durasi['shift1_detik'] / 60) / 480 : 0,
                    ],
                    'shift2' => [
                        'shift2_detik' => $durasi['shift2_detik'],
                        'hasil' => $durasi['shift2_detik'] > 0 ? ($durasi['shift2_detik'] / 60) / 480 : 0,
                    ],
                    'shift3' => [
                        'shift3_detik' => $durasi['shift3_detik'],
                        'hasil' => $durasi['shift3_detik'] > 0 ? ($durasi['shift3_detik'] / 60) / 480 : 0,
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
            $durasi = retail_d4::getStartMesinDurasiPerShift($tanggal);

            // Tentukan awal dan akhir shift dalam WIB
            $shift1_awal = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal 06:00:00", 'Asia/Jakarta');
            $shift2_awal = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal 14:01:00", 'Asia/Jakarta');
            $shift3_awal = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal 22:01:00", 'Asia/Jakarta');
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
            $durasi = retail_d4::getOffMesinDurasiPerShift($tanggal);

            // Tentukan awal dan akhir shift dalam WIB
            $shift1_awal = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal 06:00:00", 'Asia/Jakarta');
            $shift2_awal = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal 14:01:00", 'Asia/Jakarta');
            $shift3_awal = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal 22:01:00", 'Asia/Jakarta');
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
