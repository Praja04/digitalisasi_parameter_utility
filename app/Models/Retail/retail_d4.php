<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use App\Models\Retail\retail_d4_nozzle;

class retail_d4 extends Model
{
    //
    use HasFactory;

    protected $table = 'retail_d4';
    protected $primaryKey = 'id';
    public $timestamps = false; // Karena sudah ada kolom `ts` yang otomatis

    protected $fillable = [
        'ts', 'main_speed', 'total_counter', 'start_mesin'
    ];

    // public static function getMesinStartPeriods($filterType = 'realtime', $startDate = null, $endDate = null)
    // {
    //     $bindings = [];
    //     $whereClause = "";

    //     // Normalisasi nilai filter agar lebih fleksibel
    //     $filterType = strtolower($filterType);
    //     if ($filterType === 'tanggal') {
    //         $filterType = 'date';
    //     }

    //     // Bangun WHERE clause berdasarkan filter
    //     if ($filterType === 'realtime') {
    //         $whereClause = "WHERE DATE(ts) = CURDATE()";
    //     } elseif ($filterType === 'date' && $startDate) {
    //         $whereClause = "WHERE DATE(ts) = ?";
    //         $bindings[] = $startDate;
    //     } elseif ($filterType === 'range' && $startDate && $endDate) {
    //         $whereClause = "WHERE DATE(ts) BETWEEN ? AND ?";
    //         $bindings[] = $startDate;
    //         $bindings[] = $endDate;
    //     }

    //     $query = "
    //     WITH flagged_status AS (
    //         SELECT 
    //             ts,
    //             start_mesin,
    //             CASE 
    //                 WHEN start_mesin = 1 THEN 1 ELSE 0
    //             END AS is_running
    //         FROM retail_d4
    //         {$whereClause}
    //     ),
    //     grouped_blocks AS (
    //         SELECT *,
    //             ROW_NUMBER() OVER (ORDER BY ts)
    //           - ROW_NUMBER() OVER (PARTITION BY is_running ORDER BY ts) AS group_id
    //         FROM flagged_status
    //     )
    //     SELECT 
    //         MIN(ts) AS ts_mulai,
    //         MAX(ts) AS ts_akhir
    //     FROM grouped_blocks
    //     WHERE is_running = 1
    //     GROUP BY group_id
    //     ORDER BY ts_mulai
    //  ";

    //     return DB::select($query, $bindings);
    // }

    public static function getMesinStartPeriods($filterType = 'realtime', $startDate = null, $endDate = null)
    {
        $bindings = [];
        $whereClause = "";

        $filterType = strtolower($filterType);
        if ($filterType === 'tanggal') {
            $filterType = 'date';
        }

        // Generate time boundaries based on shift definition (06:00 to 05:59 next day)
        if ($filterType === 'realtime') {
            $start = Carbon::now('Asia/Jakarta')->startOfDay()->addHours(6);
            $end = (clone $start)->addDay()->subSecond();
            $whereClause = "WHERE ts BETWEEN ? AND ?";
            $bindings[] = $start->toDateTimeString();
            $bindings[] = $end->toDateTimeString();
        } elseif ($filterType === 'date' && $startDate) {
            $start = Carbon::parse($startDate)->startOfDay()->addHours(6);
            $end = (clone $start)->addDay()->subSecond();
            $whereClause = "WHERE ts BETWEEN ? AND ?";
            $bindings[] = $start->toDateTimeString();
            $bindings[] = $end->toDateTimeString();
        } elseif ($filterType === 'range' && $startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay()->addHours(6);
            $end = Carbon::parse($endDate)->startOfDay()->addDays(1)->addHours(5)->addMinutes(59)->addSeconds(59);
            $whereClause = "WHERE ts BETWEEN ? AND ?";
            $bindings[] = $start->toDateTimeString();
            $bindings[] = $end->toDateTimeString();
        }

        $query = "
            WITH flagged_status AS (
                SELECT 
                    ts,
                    start_mesin,
                    CASE 
                        WHEN start_mesin = 1 THEN 1 ELSE 0
                    END AS is_running
                FROM retail_d4
                {$whereClause}
            ),
            grouped_blocks AS (
                SELECT *,
                    ROW_NUMBER() OVER (ORDER BY ts)
                  - ROW_NUMBER() OVER (PARTITION BY is_running ORDER BY ts) AS group_id
                FROM flagged_status
            )
            SELECT 
                MIN(ts) AS ts_mulai,
                MAX(ts) AS ts_akhir
            FROM grouped_blocks
            WHERE is_running = 1
            GROUP BY group_id
            ORDER BY ts_mulai
        ";

        return DB::select($query, $bindings);
    }

    public static function getMesinStopPeriods($filterType = 'realtime', $startDate = null, $endDate = null)
    {
        $bindings = [];
        $whereClause = "";

        $filterType = strtolower($filterType);
        if ($filterType === 'tanggal') {
            $filterType = 'date';
        }

        // Generate time boundaries based on shift definition (06:00 to 05:59 next day)
        if ($filterType === 'realtime') {
            $start = Carbon::now('Asia/Jakarta')->startOfDay()->addHours(6);
            $end = (clone $start)->addDay()->subSecond();
            $whereClause = "WHERE ts BETWEEN ? AND ?";
            $bindings[] = $start->toDateTimeString();
            $bindings[] = $end->toDateTimeString();
        } elseif ($filterType === 'date' && $startDate) {
            $start = Carbon::parse($startDate)->startOfDay()->addHours(6);
            $end = (clone $start)->addDay()->subSecond();
            $whereClause = "WHERE ts BETWEEN ? AND ?";
            $bindings[] = $start->toDateTimeString();
            $bindings[] = $end->toDateTimeString();
        } elseif ($filterType === 'range' && $startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay()->addHours(6);
            $end = Carbon::parse($endDate)->startOfDay()->addDays(1)->addHours(5)->addMinutes(59)->addSeconds(59);
            $whereClause = "WHERE ts BETWEEN ? AND ?";
            $bindings[] = $start->toDateTimeString();
            $bindings[] = $end->toDateTimeString();
        }

        $query = "
            WITH flagged_status AS (
                SELECT 
                    ts,
                    start_mesin,
                    CASE 
                        WHEN start_mesin = 1 THEN 1 ELSE 0
                    END AS is_running
                FROM retail_d4
                {$whereClause}
            ),
            grouped_blocks AS (
                SELECT *,
                    ROW_NUMBER() OVER (ORDER BY ts)
                  - ROW_NUMBER() OVER (PARTITION BY is_running ORDER BY ts) AS group_id
                FROM flagged_status
            )
            SELECT 
                MIN(ts) AS ts_mulai,
                MAX(ts) AS ts_akhir
            FROM grouped_blocks
            WHERE is_running = 0
            GROUP BY group_id
            ORDER BY ts_mulai
        ";

        return DB::select($query, $bindings);
    }
    


    public static function getTotalCounterWithShifts($filter, $tanggal = null, $start = null, $end = null)
    {
        $query = self::query();

        // Dapatkan daftar tanggal yang relevan
        if ($filter === 'realtime') {
            $dates = [now()->toDateString()];
        } elseif ($filter === 'tanggal') {
            $dates = [$tanggal];
        } elseif ($filter === 'range' && $start && $end) {
            $dates = [];
            $startDate = \Carbon\Carbon::parse($start);
            $endDate = \Carbon\Carbon::parse($end);
            while ($startDate->lte($endDate)) {
                $dates[] = $startDate->toDateString();
                $startDate->addDay();
            }
        } else {
            return [
                'total_counter' => 0,
                'total_shift_1' => 0,
                'total_shift_2' => 0,
                'total_shift_3' => 0
            ];
        }

        $total = 0;
        $totalShift1 = 0;
        $totalShift2 = 0;
        $totalShift3 = 0;

        foreach ($dates as $date) {
            $carbonDate = Carbon::parse($date);

            $start1 = $carbonDate->copy()->setTime(6, 0, 0);
            $end1 = $carbonDate->copy()->setTime(14, 0, 0);

            $start2 = $carbonDate->copy()->setTime(14, 0, 1);
            $end2 = $carbonDate->copy()->setTime(22, 0, 0);

            // 🔥 Shift 3: Mulai dari hari sebelumnya jam 22:01 sampai hari ini jam 05:59
            $start3 = $carbonDate->copy()->subDay()->setTime(22, 0, 1);
            $end3 = $carbonDate->copy()->setTime(5, 59, 59);

            $totalShift1 += self::whereBetween('ts', [$start1, $end1])->sum('total_counter');
            $totalShift2 += self::whereBetween('ts', [$start2, $end2])->sum('total_counter');
            $totalShift3 += self::whereBetween('ts', [$start3, $end3])->sum('total_counter');
        }


        $total = $totalShift1 + $totalShift2 + $totalShift3;

        return [
            'total_counter' => $total,
            'total_shift_1' => $totalShift1,
            'total_shift_2' => $totalShift2,
            'total_shift_3' => $totalShift3
        ];
    }

    public static function getNozzleCountPerShift($dates)
    {
        $result = [
            'shift_1' => ['nozzle_1' => 0, 'nozzle_2' => 0],
            'shift_2' => ['nozzle_1' => 0, 'nozzle_2' => 0],
            'shift_3' => ['nozzle_1' => 0, 'nozzle_2' => 0],
        ];

        foreach ($dates as $date) {
            $carbonDate = Carbon::parse($date);

            // Shift 1: 06:00 - 14:00
            $start1 = $carbonDate->copy()->setTime(6, 0, 0);
            $end1 = $carbonDate->copy()->setTime(14, 0, 0);

            // Shift 2: 14:01 - 22:00
            $start2 = $carbonDate->copy()->setTime(14, 0, 1);
            $end2 = $carbonDate->copy()->setTime(22, 0, 0);

            // Shift 3: 22:01 (hari sebelumnya) - 05:59 (hari ini)
            $start3 = $carbonDate->copy()->setTime(22, 0, 1);
            $end3 = $carbonDate->copy()->addDay()->setTime(5, 59, 59);

            // Hitung setiap shift
            $result['shift_1']['nozzle_1'] += self::whereBetween('ts', [$start1, $end1])->sum('nozzle_1');
            $result['shift_1']['nozzle_2'] += self::whereBetween('ts', [$start1, $end1])->sum('nozzle_2');

            $result['shift_2']['nozzle_1'] += self::whereBetween('ts', [$start2, $end2])->sum('nozzle_1');
            $result['shift_2']['nozzle_2'] += self::whereBetween('ts', [$start2, $end2])->sum('nozzle_2');

            $result['shift_3']['nozzle_1'] += self::whereBetween('ts', [$start3, $end3])->sum('nozzle_1');
            $result['shift_3']['nozzle_2'] += self::whereBetween('ts', [$start3, $end3])->sum('nozzle_2');
        }

        return $result;
    }



    public static function getTotalMesinRunningMinutesByShift($filterType = 'realtime', $startDate = null, $endDate = null)
    {
        $bindings = [];
        $whereClause = "";

        if ($filterType === 'realtime') {
            $whereClause = "WHERE DATE(ts) = CURDATE()";
        } elseif ($filterType === 'date' && $startDate) {
            $whereClause = "WHERE DATE(ts) = ?";
            $bindings[] = $startDate;
        } elseif ($filterType === 'range' && $startDate && $endDate) {
            $whereClause = "WHERE DATE(ts) BETWEEN ? AND ?";
            $bindings[] = $startDate;
            $bindings[] = $endDate;
        }

        $query = "
            WITH flagged_status AS (
                SELECT 
                    ts,
                    start_mesin,
                    CASE 
                        WHEN start_mesin = 1 THEN 1 ELSE 0
                    END AS is_running
                FROM retail_d4
                {$whereClause}
            ),
            grouped_blocks AS (
                SELECT *,
                    ROW_NUMBER() OVER (ORDER BY ts)
                    - ROW_NUMBER() OVER (PARTITION BY is_running ORDER BY ts) AS group_id
                FROM flagged_status
            )
            SELECT 
                MIN(ts) AS ts_mulai,
                MAX(ts) AS ts_akhir
            FROM grouped_blocks
            WHERE is_running = 1
            GROUP BY group_id
            ORDER BY ts_mulai
            ";

        $periods = DB::select($query, $bindings);

        // Menghitung total menit per shift
        $shift1 = $shift2 = $shift3 = 0;

        foreach ($periods as $period) {
            $start = \Carbon\Carbon::parse($period->ts_mulai);
            $end = \Carbon\Carbon::parse($period->ts_akhir);
            $minutes = $start->diffInMinutes($end); // Menghitung selisih dalam menit

            // Menghitung durasi mesin menyala dalam setiap shift
            while ($start < $end) {
                $currentTime = \Carbon\Carbon::parse($start);
                if ($currentTime->between(\Carbon\Carbon::parse('06:00:00'), \Carbon\Carbon::parse('14:00:00'))) {
                    // Shift 1 (06:00 - 14:00)
                    $shift1 += 1;
                } elseif ($currentTime->between(\Carbon\Carbon::parse('14:00:01'), \Carbon\Carbon::parse('22:00:00'))) {
                    // Shift 2 (14:01 - 22:00)
                    $shift2 += 1;
                } else {
                    // Shift 3 (22:01 - 05:59)
                    $shift3 += 1;
                }
                $start->addMinute();
            }
        }

        // Menghitung uptime untuk masing-masing shift dalam persen
        $uptimeShift1 = (min(420, $shift1) / 420) * 100; // Uptime Shift 1
        $uptimeShift2 = (min(420, $shift2) / 420) * 100; // Uptime Shift 2
        $uptimeShift3 = (min(420, $shift3) / 420) * 100; // Uptime Shift 3

        return [
            'shift1_uptime' => $uptimeShift1,
            'shift2_uptime' => $uptimeShift2,
            'shift3_uptime' => $uptimeShift3
        ];
    }



    public static function getTotalMesinDowntimeByShift($filterType = 'realtime', $startDate = null, $endDate = null)
    {
        $bindings = [];
        $whereClause = "";

        if ($filterType === 'realtime') {
            $whereClause = "WHERE DATE(ts) = CURDATE()";
        } elseif ($filterType === 'date' && $startDate) {
            $whereClause = "WHERE DATE(ts) = ?";
            $bindings[] = $startDate;
        } elseif ($filterType === 'range' && $startDate && $endDate) {
            $whereClause = "WHERE DATE(ts) BETWEEN ? AND ?";
            $bindings[] = $startDate;
            $bindings[] = $endDate;
        }

        $query = "
        WITH flagged_status AS (
            SELECT 
                ts,
                start_mesin,
                CASE 
                    WHEN start_mesin = 0 THEN 1 ELSE 0
                END AS is_down
            FROM retail_d4
            {$whereClause}
        ),
        grouped_blocks AS (
            SELECT * ,
                ROW_NUMBER() OVER (ORDER BY ts)
                - ROW_NUMBER() OVER (PARTITION BY is_down ORDER BY ts) AS group_id
            FROM flagged_status
        )
        SELECT 
            MIN(ts) AS ts_mulai,
            MAX(ts) AS ts_akhir
        FROM grouped_blocks
        WHERE is_down = 1
        GROUP BY group_id
        ORDER BY ts_mulai
        ";

        $periods = DB::select($query, $bindings);

        // Menghitung total menit downtime
        $shift1 = $shift2 = $shift3 = 0; // Variabel untuk menyimpan menit downtime per shift

        foreach ($periods as $period) {
            $start = \Carbon\Carbon::parse($period->ts_mulai);
            $end = \Carbon\Carbon::parse($period->ts_akhir);
            $minutes = $start->diffInMinutes($end); // Menghitung selisih dalam menit

            // Memecah ts downtime ke dalam 3 shift
            while ($start < $end) {
                $currentTime = \Carbon\Carbon::parse($start);
                if ($currentTime->between(\Carbon\Carbon::parse('06:00:00'), \Carbon\Carbon::parse('14:00:00'))) {
                    // Shift 1 (06:00 - 14:00)
                    $shift1 += 1;
                } elseif ($currentTime->between(\Carbon\Carbon::parse('14:00:01'), \Carbon\Carbon::parse('22:00:00'))) {
                    // Shift 2 (14:01 - 22:00)
                    $shift2 += 1;
                } else {
                    // Shift 3 (22:01 - 05:59)
                    $shift3 += 1;
                }
                $start->addMinute();
            }
        }

        // Menghitung downtime untuk masing-masing shift
        $downtimeShift1 = min(420, $shift1) / 420 * 100; // Downtime Shift 1
        $downtimeShift2 = min(420, $shift2) / 420 * 100; // Downtime Shift 2
        $downtimeShift3 = min(420, $shift3) / 420 * 100; // Downtime Shift 3

        return [
            'shift1_downtime' => $downtimeShift1,
            'shift2_downtime' => $downtimeShift2,
            'shift3_downtime' => $downtimeShift3
        ];
    }

    public static function getTotalMesinStartTime($filterType = 'realtime', $startDate = null, $endDate = null)
    {
        // Mendapatkan data periode start mesin
        $data = self::getMesinStartPeriods($filterType, $startDate, $endDate);

        // Variabel untuk menyimpan total ts
        $totalts = 0;

        // Menjumlahkan durasi untuk setiap periode
        foreach ($data as $item) {
            $tsMulai = \Carbon\Carbon::parse($item->ts_mulai);
            $tsAkhir = \Carbon\Carbon::parse($item->ts_akhir);

            // Pastikan ts akhir selalu lebih besar dari ts mulai
            if ($tsAkhir < $tsMulai) {
                // Tukar posisi jika ts akhir lebih kecil
                $temp = $tsMulai;
                $tsMulai = $tsAkhir;
                $tsAkhir = $temp;
            }

            // Menghitung selisih ts dalam menit
            $durasi = Carbon::parse($tsMulai)->diffInMinutes($tsAkhir);

            // Menambahkan durasi ke total ts
            $totalts += $durasi;

            // Optional: return data per item untuk debugging
            // Bisa mengembalikan detail setiap item dan durasi per item
            $item->durasi = $durasi; // Menyimpan durasi di item untuk debugging
        }

        // Return array data beserta total ts untuk debugging
        return [
            'totalts' => $totalts,
            'data' => $data // Mengembalikan data yang diproses
        ];
    }

    //berhasil


    public static function getDurasiMesinPerShift($tanggal = null)
    {
        if (!$tanggal) {
            $tanggal = Carbon::now()->toDateString();
        }

        return DB::select("
        WITH status_dengan_shift AS (
            SELECT 
                ts,
                start_mesin,
                CASE
                    WHEN TIME(ts) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                    WHEN TIME(ts) BETWEEN '14:00:01' AND '22:00:00' THEN 'Shift 2'
                    WHEN TIME(ts) >= '22:00:01' THEN 'Shift 3'
                    WHEN TIME(ts) <= '05:59:59' THEN 'Shift 3'
                END AS shift,
                LAG(start_mesin) OVER (
                    PARTITION BY 
                        CASE
                            WHEN TIME(ts) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                            WHEN TIME(ts) BETWEEN '14:00:01' AND '22:00:00' THEN 'Shift 2'
                            WHEN TIME(ts) >= '22:00:01' THEN 'Shift 3'
                            WHEN TIME(ts) <= '05:59:59' THEN 'Shift 3'
                        END
                    ORDER BY ts
                ) AS prev_status
            FROM retail_d4
            WHERE DATE(ts) = ? OR DATE(ts) = DATE_SUB(?, INTERVAL 1 DAY)
        ),
        blok AS (
            SELECT 
                ts,
                shift,
                start_mesin,
                SUM(CASE 
                    WHEN start_mesin = 1 AND (prev_status = 0 OR prev_status IS NULL) THEN 1 
                    ELSE 0 
                END) OVER (
                    PARTITION BY shift 
                    ORDER BY ts 
                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                ) AS group_id
            FROM status_dengan_shift
        ),
        durasi_per_shift AS (
            SELECT 
                shift,
                MIN(ts) AS ts_mulai,
                MAX(ts) AS ts_akhir,
                TIMESTAMPDIFF(SECOND, MIN(ts), MAX(ts)) AS durasi_detik
            FROM blok
            WHERE start_mesin = 1
            GROUP BY shift, group_id
        )
        SELECT 
            shift,
            SEC_TO_TIME(SUM(durasi_detik)) AS total_durasi
        FROM durasi_per_shift
        GROUP BY shift
        ORDER BY FIELD(shift, 'Shift 1', 'Shift 2', 'Shift 3')
    ", [$tanggal, $tanggal]);
    }




    public static function getUptime($tanggal = null)
    {
        if (!$tanggal) {
            $tanggal = Carbon::now()->toDateString();
        }

        $data = DB::select("
        WITH status_dengan_shift AS (
            SELECT 
                ts,
                start_mesin,
                CASE
                    WHEN TIME(ts) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                    WHEN TIME(ts) BETWEEN '14:00:01' AND '22:00:00' THEN 'Shift 2'
                    WHEN TIME(ts) >= '22:00:01' THEN 'Shift 3'
                    WHEN TIME(ts) <= '05:59:59' THEN 'Shift 3'
                END AS shift,
                LAG(start_mesin) OVER (PARTITION BY 
                    CASE
                        WHEN TIME(ts) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                        WHEN TIME(ts) BETWEEN '14:00:01' AND '22:00:00' THEN 'Shift 2'
                        WHEN TIME(ts) >= '22:00:01' THEN 'Shift 3'
                        WHEN TIME(ts) <= '05:59:59' THEN 'Shift 3'
                    END
                    ORDER BY ts) AS prev_status
            FROM retail_d4
            WHERE DATE(ts) = ? OR DATE(ts) = DATE_SUB(?, INTERVAL 1 DAY)
        ),
        blok AS (
            SELECT 
                ts,
                shift,
                start_mesin,
                SUM(CASE 
                    WHEN start_mesin = 1 AND (prev_status = 0 OR prev_status IS NULL) THEN 1 
                    ELSE 0 
                END) OVER (PARTITION BY shift ORDER BY ts ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) AS group_id
            FROM status_dengan_shift
        ),
        durasi_per_shift AS (
            SELECT 
                shift,
                MIN(ts) AS ts_mulai,
                MAX(ts) AS ts_akhir,
                TIMESTAMPDIFF(SECOND, MIN(ts), MAX(ts)) AS durasi_detik
            FROM blok
            WHERE start_mesin = 1
            GROUP BY shift, group_id
        )
        SELECT 
            shift,
            SUM(durasi_detik) AS total_detik_menyala,
            SEC_TO_TIME(SUM(durasi_detik)) AS durasi_menyala
        FROM durasi_per_shift
        GROUP BY shift
        ORDER BY FIELD(shift, 'Shift 1', 'Shift 2', 'Shift 3')
        ", [$tanggal, $tanggal]);

        // Siapkan struktur default untuk semua shift
        $allShifts = ['Shift 1', 'Shift 2', 'Shift 3'];
        $result = [];

        // Ubah hasil query ke array asosiatif berdasarkan shift
        $dataByShift = collect($data)->keyBy('shift');

        foreach ($allShifts as $shift) {
            if ($dataByShift->has($shift)) {
                $detikMenyala = $dataByShift[$shift]->total_detik_menyala;
                $menitMenyala = $detikMenyala / 60;
                $mesinRunPerShift = $menitMenyala / 420; // 7 jam per shift

                $result[] = [
                    'shift' => $shift,
                    'durasi' => round($menitMenyala, 2),
                    'mesin_uptime' => round($mesinRunPerShift * 100, 2),
                ];
            } else {
                $result[] = [
                    'shift' => $shift,
                    'durasi' => 0,
                    'mesin_uptime' => 0,
                ];
            }
        }

        return $result;
    }





    public static function getDownTime($tanggal = null)
    {
        if (!$tanggal) {
            $tanggal = Carbon::now()->toDateString();
        }

        $data = DB::select("
        WITH status_dengan_shift AS (
            SELECT 
                ts,
                start_mesin,
                CASE
                    WHEN TIME(ts) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                    WHEN TIME(ts) BETWEEN '14:00:01' AND '22:00:00' THEN 'Shift 2'
                    WHEN TIME(ts) >= '22:00:01' THEN 'Shift 3'
                    WHEN TIME(ts) <= '05:59:59' THEN 'Shift 3'
                END AS shift,
                LAG(start_mesin) OVER (
                    PARTITION BY 
                        CASE
                            WHEN TIME(ts) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                            WHEN TIME(ts) BETWEEN '14:00:01' AND '22:00:00' THEN 'Shift 2'
                            WHEN TIME(ts) >= '22:00:01' THEN 'Shift 3'
                            WHEN TIME(ts) <= '05:59:59' THEN 'Shift 3'
                        END
                    ORDER BY ts
                ) AS prev_status
            FROM retail_d4
            WHERE DATE(ts) = ? OR DATE(ts) = DATE_SUB(?, INTERVAL 1 DAY)
        ),
        blok AS (
            SELECT 
                ts,
                shift,
                start_mesin,
                SUM(CASE 
                    WHEN start_mesin = 0 AND (prev_status = 1 OR prev_status IS NULL) THEN 1 
                    ELSE 0 
                END) OVER (
                    PARTITION BY shift 
                    ORDER BY ts 
                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                ) AS group_id
            FROM status_dengan_shift
        ),
        durasi_per_shift AS (
            SELECT 
                shift,
                MIN(ts) AS ts_mulai,
                MAX(ts) AS ts_akhir,
                TIMESTAMPDIFF(SECOND, MIN(ts), MAX(ts)) AS durasi_detik
            FROM blok
            WHERE start_mesin = 0
            GROUP BY shift, group_id
        )
        SELECT 
            shift,
            SUM(durasi_detik) AS total_detik_mati,
            SEC_TO_TIME(SUM(durasi_detik)) AS durasi_mati
        FROM durasi_per_shift
        GROUP BY shift
        ORDER BY FIELD(shift, 'Shift 1', 'Shift 2', 'Shift 3')
     ", [$tanggal, $tanggal]);

        // Default untuk ketiga shift
        $default = [
            'Shift 1' => ['durasi' => 0, 'mesin_downtime' => 0],
            'Shift 2' => ['durasi' => 0, 'mesin_downtime' => 0],
            'Shift 3' => ['durasi' => 0, 'mesin_downtime' => 0],
        ];

        foreach ($data as $item) {
            $detikMati = $item->total_detik_mati;
            $menitMati = $detikMati / 60;
            $mesinDowntimePercent = ($menitMati / 420) * 100;

            $default[$item->shift] = [
                'durasi' => round($menitMati, 2),
                'mesin_downtime' => round($mesinDowntimePercent, 2),
            ];
        }

        // Ubah jadi array numerik berurutan
        $result = [];
        foreach (['Shift 1', 'Shift 2', 'Shift 3'] as $shift) {
            $result[] = [
                'shift' => $shift,
                'durasi' => $default[$shift]['durasi'],
                'tanggal_shift' => $tanggal,
                'mesin_downtime' => $default[$shift]['mesin_downtime'],
            ];
        }

        return $result;
    }


    public static function getUptimeWithRealtime($tanggal = null)
    {
        // Pastikan menggunakan zona ts Asia/Jakarta (WIB)
        $currentTime = Carbon::now('Asia/Jakarta');  // Menggunakan WIB untuk ts sekarang

        // Jika tidak ada tanggal diberikan, gunakan hari ini
        if (!$tanggal) {
            $tanggal = $currentTime->toDateString();
        }

        $tanggalKemarin = Carbon::parse($tanggal)->subDay()->toDateString();

        // SQL query menggunakan CTE
        $data = DB::select(" 
        WITH status_dengan_shift AS (
            SELECT 
                ts,
                start_mesin,
                CASE
                    WHEN TIME(ts) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                    WHEN TIME(ts) BETWEEN '14:00:01' AND '22:00:00' THEN 'Shift 2'
                    WHEN TIME(ts) >= '22:00:01' THEN 'Shift 3'
                    WHEN TIME(ts) <= '05:59:59' THEN 'Shift 3'
                END AS shift,
                LAG(start_mesin) OVER (
                    PARTITION BY CASE
                        WHEN TIME(ts) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                        WHEN TIME(ts) BETWEEN '14:00:01' AND '22:00:00' THEN 'Shift 2'
                        WHEN TIME(ts) >= '22:00:01' THEN 'Shift 3'
                        WHEN TIME(ts) <= '05:59:59' THEN 'Shift 3'
                    END
                    ORDER BY ts
                ) AS prev_status
            FROM retail_d4
            WHERE DATE(ts) IN (?, ?)
        ),
        blok AS (
            SELECT 
                ts,
                shift,
                start_mesin,
                SUM(
                    CASE 
                        WHEN start_mesin = 1 AND (prev_status = 0 OR prev_status IS NULL) THEN 1 
                        ELSE 0 
                    END
                ) OVER (PARTITION BY shift ORDER BY ts ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) AS group_id
            FROM status_dengan_shift
        ),
        durasi_per_shift AS (
            SELECT 
                shift,
                MIN(ts) AS ts_mulai,
                MAX(ts) AS ts_akhir,
                TIMESTAMPDIFF(SECOND, MIN(ts), MAX(ts)) AS durasi_detik
            FROM blok
            WHERE start_mesin = 1
            GROUP BY shift, group_id
        )
        SELECT 
            shift,
            SUM(durasi_detik) AS total_detik,
            SEC_TO_TIME(SUM(durasi_detik)) AS total_durasi
        FROM durasi_per_shift
        GROUP BY shift
        ORDER BY FIELD(shift, 'Shift 1', 'Shift 2', 'Shift 3')
     ", [$tanggal, $tanggalKemarin]);

        $result = [];

        foreach ($data as $row) {
            $durasiDetik = $row->total_detik;
            $shift = $row->shift;

            $shiftStart = null;
            if ($shift == 'Shift 1') {
                $shiftStart = Carbon::createFromTimeString("$tanggal 06:00:00", 'Asia/Jakarta'); // Set timezone WIB
            } elseif ($shift == 'Shift 2') {
                $shiftStart = Carbon::createFromTimeString("$tanggal 14:00:01", 'Asia/Jakarta');
            } elseif ($shift == 'Shift 3') {
                $shiftStart = Carbon::createFromTimeString("$tanggal 22:00:01", 'Asia/Jakarta');
            }

            // Jika ts sekarang lebih kecil dari ts mulai shift, set durasi berjalan ke 0
            $durasiBerjalan = $currentTime->greaterThanOrEqualTo($shiftStart)
                ? $currentTime->diffInMinutes($shiftStart)  // Jika shift sudah dimulai
                : 0;  // Jika shift belum dimulai
            $durasihasil  = $durasiBerjalan * (-1);
            // Hitung uptime mesin jika durasi berjalan lebih besar dari 0
            $uptimePercent = ($durasihasil > 0) ? ($durasiDetik / 60) / $durasihasil * 100 : 0;

            // Menambahkan informasi yang diperlukan ke dalam hasil
            $result[] = [
                'shift' => $shift,
                'durasiberjalan' => $durasihasil,  // Tanpa * -1
                'durasi_menit' => round($durasiDetik / 60, 2),
                'mesin_uptime_akumulasi' => round($uptimePercent, 2)
            ];
        }

        return $result;
    }







    public static function getPerformanceGagalFillingRange($startDate, $endDate)
    {
        $timezone = 'Asia/Jakarta';
        $start = Carbon::parse($startDate, $timezone);
        $end = Carbon::parse($endDate, $timezone);
        $results = [];

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $shifts = [
                [
                    'name' => 'Shift 1',
                    'start' => $date->copy()->setTime(6, 0, 0),
                    'end'   => $date->copy()->setTime(14, 0, 0),
                ],
                [
                    'name' => 'Shift 2',
                    'start' => $date->copy()->setTime(14, 0, 1),
                    'end'   => $date->copy()->setTime(22, 0, 0),
                ],
                [
                    'name' => 'Shift 3',
                    'start' => $date->copy()->setTime(22, 0, 1),
                    'end'   => $date->copy()->addDay()->setTime(5, 59, 59),
                ],
            ];

            foreach ($shifts as $shift) {
                $data = self::whereBetween('ts', [$shift['start'], $shift['end']])
                    ->orderBy('ts')
                    ->get();

                // Hitung running time (start_mesin = 1)
                $runningTimeMinutes = 0;
                $previousTime = null;
                foreach ($data as $row) {
                    if ($row->start_mesin == 1) {
                        if ($previousTime) {
                            $diff = Carbon::parse($row->ts)->diffInMinutes($previousTime);
                            $runningTimeMinutes += $diff;
                        }
                        $previousTime = Carbon::parse($row->ts);
                    } else {
                        $previousTime = null;
                    }
                }

                // Hitung total nozzle aktif
                $totalNozzleAktif = $data->reduce(function ($carry, $item) {
                    return $carry + ($item->nozzle_1 == 1 ? 1 : 0) + ($item->nozzle_2 == 1 ? 1 : 0);
                }, 0);

                // Actual speed terakhir
                $actualSpeed = optional($data->last())->main_speed ?? 0;
                $hasilrunningtime = $runningTimeMinutes * (-1);

                // Hitung performance gagal filling
                $denominator = $hasilrunningtime * $actualSpeed * 2;
                $performanceGoodFilling = $denominator > 0
                    ? ($totalNozzleAktif / $denominator) * 100
                    : 0;
                $performanceGagalFilling = $performanceGoodFilling > 0 ? (100 - $performanceGoodFilling) : 0;

                $results[] = [
                    'shift' => $shift['name'],
                    'tanggal' => $date->toDateString(),
                    'ts_awal_shift' => $shift['start']->toDateTimeString(),
                    'ts_akhir_shift' => $shift['end']->toDateTimeString(),
                    'akumulasi_menit_mesin_menyala' => $hasilrunningtime,
                    'actual_speed' => $actualSpeed,
                    'total_nozzle_aktif' => $totalNozzleAktif,
                    'performance_gagal_filling_percent' => round($performanceGagalFilling, 2),
                ];
            }
        }

        return $results;
    }


    // public static function getPerformanceGagalFilling($tanggal = null)
    // {
    //     $timezone = 'Asia/Jakarta';
    //     $now = Carbon::now($timezone);
    //     $carbonDate = $tanggal
    //         ? Carbon::parse($tanggal, $timezone)
    //         : $now->copy();

    //     $shifts = [
    //         [
    //             'name' => 'Shift 1',
    //             'start' => $carbonDate->copy()->setTime(6, 0, 0),
    //             'end'   => $carbonDate->copy()->setTime(14, 0, 0),
    //         ],
    //         [
    //             'name' => 'Shift 2',
    //             'start' => $carbonDate->copy()->setTime(14, 0, 1),
    //             'end'   => $carbonDate->copy()->setTime(22, 0, 0),
    //         ],
    //         [
    //             'name' => 'Shift 3',
    //             'start' => $carbonDate->copy()->setTime(22, 0, 1),
    //             'end'   => $carbonDate->copy()->addDay()->setTime(5, 59, 59),
    //         ],
    //     ];

    //     // Generate target timestamps
    //     $target14 = $carbonDate->copy()->setTime(14, 0, 0)->toDateTimeString();
    //     $target22 = $carbonDate->copy()->setTime(22, 0, 0)->toDateTimeString();
    //     $target06 = $carbonDate->copy()->addDay()->setTime(6, 0, 0)->toDateTimeString();

    //     // Ambil total_counter terdekat dengan target waktu
    //     $totalCounterData = DB::select("
    //     WITH all_targets AS (
    //         SELECT ? AS target_ts
    //         UNION ALL
    //         SELECT ?
    //         UNION ALL
    //         SELECT ?
    //     ),
    //     closest_valid AS (
    //         SELECT 
    //             t.target_ts,
    //             r.ts,
    //             r.total_counter,
    //             ROW_NUMBER() OVER (
    //                 PARTITION BY t.target_ts 
    //                 ORDER BY ABS(TIMESTAMPDIFF(SECOND, r.ts, t.target_ts))
    //             ) AS rn
    //         FROM all_targets t
    //         JOIN retail_d4 r ON r.ts <= t.target_ts
    //         WHERE r.total_counter != 0
    //     )
    //     SELECT 
    //         target_ts,
    //         ts AS actual_ts,
    //         total_counter
    //     FROM closest_valid
    //     WHERE rn = 1
    //     ORDER BY target_ts
    //   ", [$target14, $target22, $target06]);

    //     // Konversi hasil query ke associative array
    //     $countersByTarget = collect($totalCounterData)->keyBy('target_ts');

    //     $results = [];

    //     foreach ($shifts as $shift) {
    //         $data = self::whereBetween('ts', [$shift['start'], $shift['end']])
    //             ->orderBy('ts')
    //             ->get();

    //         $runningTimeMinutes = $data->where('start_mesin', 1)->count();
    //         $runningTimeMinutescount = $runningTimeMinutes / 60;

    //         // Ambil total_counter dari target timestamp setelah shift ini
    //         $targetKey = $shift['name'] === 'Shift 1' ? $target14
    //             : ($shift['name'] === 'Shift 2' ? $target22 : $target06);
    //         $totalNozzleAktif = isset($countersByTarget[$targetKey])
    //             ? $countersByTarget[$targetKey]->total_counter
    //             : 0;

    //         $actualSpeed = optional($data->last())->main_speed ?? 0;

    //         $denominator = $runningTimeMinutescount * $actualSpeed * 2;
    //         $performanceGoodFilling = $denominator > 0
    //             ? (($totalNozzleAktif / $denominator) * 100)
    //             : 0;
    //         $performanceGagalFilling = $performanceGoodFilling > 0 ? (100 - $performanceGoodFilling) : 0;

    //         $results[] = [
    //             'shift' => $shift['name'],
    //             'dominator' => $denominator,
    //             'goodfilling' => $performanceGoodFilling,
    //             'tanggal' => $carbonDate->toDateString(),
    //             'ts_awal_shift' => $shift['start']->toDateTimeString(),
    //             'ts_akhir_shift' => $shift['end']->toDateTimeString(),
    //             'jumlah_start_mesin' => $runningTimeMinutescount,
    //             'actual_speed' => $actualSpeed,
    //             'total_nozzle_aktif' => $totalNozzleAktif,
    //             'performance_gagal_filling_percent' => round($performanceGagalFilling, 2),
    //             'target_ts' => $targetKey,
    //             'actual_ts' => isset($countersByTarget[$targetKey])
    //                 ? $countersByTarget[$targetKey]->actual_ts
    //                 : null,
    //             'total_counter_per_shift' => isset($countersByTarget[$targetKey]) ? $countersByTarget[$targetKey]->total_counter : 0, // Total counter per shift

    //         ];
    //     }

    //     return $results;
    // }

    public static function getPerformanceGagalFilling($tanggal = null)
    {
        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);
        $carbonDate = $tanggal
            ? Carbon::parse($tanggal, $timezone)
            : $now->copy();

        $shifts = [
            [
                'name' => 'Shift 1',
                'start' => $carbonDate->copy()->setTime(6, 0, 0),
                'end'   => $carbonDate->copy()->setTime(14, 0, 0),
            ],
            [
                'name' => 'Shift 2',
                'start' => $carbonDate->copy()->setTime(14, 0, 1),
                'end'   => $carbonDate->copy()->setTime(22, 0, 0),
            ],
            [
                'name' => 'Shift 3',
                'start' => $carbonDate->copy()->setTime(22, 0, 1),
                'end'   => $carbonDate->copy()->addDay()->setTime(5, 59, 59),
            ],
        ];

        $results = [];

        foreach ($shifts as $shift) {
            $data = self::whereBetween('ts', [$shift['start'], $shift['end']])
                ->orderBy('ts')
                ->get();

            $runningTimeMinutes = $data->where('start_mesin', 1)->count();
            $runningTimeMinutesCount = $runningTimeMinutes / 60;
            $actualSpeed = optional($data->last())->main_speed ?? 0;

            // Dapatkan total_counter terakhir sebelum 0
            $row = DB::selectOne("
                WITH shift_data AS (
                    SELECT * FROM retail_d4
                    WHERE ts BETWEEN ? AND ?
                ),
                zero_ts AS (
                    SELECT ts FROM shift_data WHERE total_counter = 0 ORDER BY ts LIMIT 1
                ),
                before_zero AS (
                    SELECT * FROM shift_data
                    WHERE ts < (SELECT ts FROM zero_ts)
                    ORDER BY ts DESC
                    LIMIT 1
                ),
                fallback AS (
                    SELECT * FROM shift_data
                    ORDER BY ts DESC
                    LIMIT 1
                )
                SELECT * FROM before_zero
                UNION ALL
                SELECT * FROM fallback
                WHERE NOT EXISTS (SELECT 1 FROM before_zero)
                LIMIT 1
            ", [
                $shift['start']->toDateTimeString(),
                $shift['end']->toDateTimeString(),
            ]);

            $totalNozzleAktif = $row ? $row->total_counter : 0;
            $actualTS = $row ? $row->ts : null;

            $denominator = $runningTimeMinutesCount * $actualSpeed * 2;
            $performanceGoodFilling = $denominator > 0
                ? (($totalNozzleAktif / $denominator) * 100)
                : 0;
            $performanceGagalFilling = $performanceGoodFilling > 0 ? (100 - $performanceGoodFilling) : 0;

            $results[] = [
                'shift' => $shift['name'],
                'tanggal' => $carbonDate->toDateString(),
                'ts_awal_shift' => $shift['start']->toDateTimeString(),
                'ts_akhir_shift' => $shift['end']->toDateTimeString(),
                'jumlah_start_mesin' => round($runningTimeMinutesCount, 2),
                'actual_speed' => $actualSpeed,
                'total_nozzle_aktif' => $totalNozzleAktif,
                'performance_gagal_filling_percent' => round($performanceGagalFilling, 2),
                'actual_ts' => $actualTS,
                'total_counter_per_shift' => $totalNozzleAktif,
                'denominator' => round($denominator, 2),
                'goodfilling' => round($performanceGoodFilling, 2),
            ];
        }

        return $results;
    }
    


    //test
    public static function getStartMesinDurasiPerShift($tanggal)
    {
        $besok = Carbon::parse($tanggal)->addDay()->toDateString();

        $shift1 = DB::table('retail_d4')
            ->whereBetween('ts', ["$tanggal 06:00:00", "$tanggal 14:00:00"])
            ->where('start_mesin', 1)
            ->count();

        $shift2 = DB::table('retail_d4')
            ->whereBetween('ts', ["$tanggal 14:00:01", "$tanggal 22:00:00"])
            ->where('start_mesin', 1)
            ->count();

        $shift3 = DB::table('retail_d4')
            ->whereBetween('ts', ["$tanggal 22:00:01", "$besok 05:59:59"])
            ->where('start_mesin', 1)
            ->count();

        return [
            'shift1_detik' => $shift1,
            'shift2_detik' => $shift2,
            'shift3_detik' => $shift3,
        ];
    }

    public static function getOffMesinDurasiPerShift($tanggal)
    {
        $besok = Carbon::parse($tanggal)->addDay()->toDateString();

        $shift1 = DB::table('retail_d4')
            ->whereBetween('ts', ["$tanggal 06:00:00", "$tanggal 14:00:00"])
            ->where('start_mesin', 0)
            ->count();

        $shift2 = DB::table('retail_d4')
            ->whereBetween('ts', ["$tanggal 14:00:01", "$tanggal 22:00:00"])
            ->where('start_mesin', 0)
            ->count();

        $shift3 = DB::table('retail_d4')
            ->whereBetween('ts', ["$tanggal 22:00:01", "$besok 05:59:59"])
            ->where('start_mesin', 0)
            ->count();

        return [
            'shift1_detik' => $shift1,
            'shift2_detik' => $shift2,
            'shift3_detik' => $shift3,
        ];
    }

    // public static function getPerformanceOutput($tanggal = null)
    // {
    //     $timezone = 'Asia/Jakarta';
    //     $now = Carbon::now($timezone);

    //     if (!$tanggal) {
    //         $carbonDate = $now->copy();
    //     } else {
    //         $carbonDate = Carbon::parse($tanggal, $timezone);
    //         if (strlen($tanggal) <= 10) {
    //             $carbonDate->setTimeFrom($now);
    //         }
    //     }

    //     $currentTime = $carbonDate->format('H:i:s');
    //     $shift = '';
    //     $start = null;

    //     if ($currentTime >= '06:00:00' && $currentTime <= '14:00:00') {
    //         $shift = 'Shift 1';
    //         $start = $carbonDate->copy()->setTime(6, 0, 0);
    //     } elseif ($currentTime > '14:00:00' && $currentTime <= '22:00:00') {
    //         $shift = 'Shift 2';
    //         $start = $carbonDate->copy()->setTime(14, 1, 0);
    //     } else {
    //         $shift = 'Shift 3';
    //         if ($currentTime >= '22:00:01') {
    //             $start = $carbonDate->copy()->setTime(22, 1, 0);
    //         } else {
    //             $start = $carbonDate->copy()->subDay()->setTime(22, 1, 0);
    //         }
    //     }

    //     $durasiMenit = $start->diffInMinutes($carbonDate);

    //     // Ambil data dari tabel retail_d4_nozzle
    //     $totalNozzleAktif = retail_d4_nozzle::whereBetween('ts', [$start, $carbonDate])
    //         ->get()
    //         ->reduce(function ($carry, $item) {
    //             return $carry + ($item->nozzle_1 == 1 ? 1 : 0) + ($item->nozzle_2 == 1 ? 1 : 0);
    //         }, 0);

    //     // Asumsi total maksimal nozzle adalah 40 unit per menit per nozzle (×2 karena nozzle_1 & nozzle_2)
    //     $performance = $durasiMenit > 0
    //         ? ($totalNozzleAktif / ($durasiMenit * 40 * 2)) * 100
    //         : 0;

    //     return [
    //         'shift' => $shift,
    //         'tanggal' => $carbonDate->toDateString(),
    //         'ts_awal_shift' => $start->toDateTimeString(),
    //         'ts_sekarang' => $carbonDate->toDateTimeString(),
    //         'durasi_menit' => $durasiMenit,
    //         'total_nozzle_aktif' => $totalNozzleAktif,
    //         'performance_output_percent' => round($performance, 2),
    //     ];
    // }

    // public static function getAllShiftPerformanceOutput($tanggal = null)
    // {
    //     $timezone = 'Asia/Jakarta';
    //     $now = Carbon::now($timezone);

    //     $carbonDate = $tanggal
    //         ? Carbon::parse($tanggal, $timezone)
    //         : $now->copy();

    //     // Definisi shift
    //     $shifts = [
    //         [
    //             'name' => 'Shift 1',
    //             'start' => $carbonDate->copy()->setTime(6, 0, 0),
    //             'end'   => $carbonDate->copy()->setTime(14, 0, 0),
    //         ],
    //         [
    //             'name' => 'Shift 2',
    //             'start' => $carbonDate->copy()->setTime(14, 0, 1),
    //             'end'   => $carbonDate->copy()->setTime(22, 0, 0),
    //         ],
    //         [
    //             'name' => 'Shift 3',
    //             'start' => $carbonDate->copy()->setTime(22, 0, 1),
    //             'end'   => $carbonDate->copy()->addDay()->setTime(5, 59, 59),
    //         ],
    //     ];

    //     $results = [];

    //     foreach ($shifts as $shift) {
    //         $totalNozzleAktif = retail_d4_nozzle::whereBetween('ts', [$shift['start'], $shift['end']])
    //             ->get()
    //             ->reduce(function ($carry, $item) {
    //                 return $carry + ($item->nozzle_1 == 1 ? 1 : 0) + ($item->nozzle_2 == 1 ? 1 : 0);
    //             }, 0);

    //         $durasiMenit = 420; // 7 jam shift
    //         $performance = ($durasiMenit > 0)
    //             ? ($totalNozzleAktif / ($durasiMenit * 40 * 2)) * 100
    //             : 0;

    //         $results[] = [
    //             'shift' => $shift['name'],
    //             'tanggal' => $carbonDate->toDateString(),
    //             'ts_awal_shift' => $shift['start']->toDateTimeString(),
    //             'ts_akhir_shift' => $shift['end']->toDateTimeString(),
    //             'durasi_menit' => $durasiMenit,
    //             'total_nozzle_aktif' => $totalNozzleAktif,
    //             'performance_output_percent' => round($performance, 2),
    //         ];
    //     }

    //     return $results;
    // }

    //make total counter
    public static function getAllShiftPerformanceOutput($tanggal = null)
    {
        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);

        $carbonDate = $tanggal
        ? Carbon::parse($tanggal, $timezone)
        : $now->copy();

        $shifts = [
                [
                    'name' => 'Shift 1',
                    'start' => $carbonDate->copy()->setTime(6, 0, 0),
                    'end'   => $carbonDate->copy()->setTime(14, 0, 0),
                ],
                [
                    'name' => 'Shift 2',
                    'start' => $carbonDate->copy()->setTime(14, 0, 1),
                    'end'   => $carbonDate->copy()->setTime(22, 0, 0),
                ],
                [
                    'name' => 'Shift 3',
                    'start' => $carbonDate->copy()->setTime(22, 0, 1),
                    'end'   => $carbonDate->copy()->addDay()->setTime(5, 59, 59),
                ],
            ];

        $results = [];

        foreach ($shifts as $shift) {
            $data = DB::selectOne("
            WITH shift_data AS (
                SELECT ts, total_counter
                FROM retail_d4
                WHERE ts BETWEEN ? AND ?
                ORDER BY ts
            ),
            with_next AS (
                SELECT 
                    ts,
                    total_counter,
                    LEAD(total_counter) OVER (ORDER BY ts) AS next_counter
                FROM shift_data
            )
            SELECT 
                ts,
                total_counter
            FROM with_next
            WHERE next_counter = 0
            ORDER BY ts DESC
            LIMIT 1
        ", [$shift['start']->toDateTimeString(), $shift['end']->toDateTimeString()]);

            if (!$data) {
                // fallback: ambil data tepat di akhir shift jika tidak ada perubahan ke 0
                $data = DB::selectOne("
                SELECT ts, total_counter
                FROM retail_d4
                WHERE ts <= ?
                ORDER BY ts DESC
                LIMIT 1
            ", [$shift['end']->toDateTimeString()]);
            }

            $totalCounter = $data ? $data->total_counter : 0;
            $actualTs = $data ? $data->ts : null;
            $durasiMenit = 420;

            $performance = $durasiMenit > 0
                ? ($totalCounter / ($durasiMenit * 40 * 2)) * 100
                : 0;

            $results[] = [
                'shift' => $shift['name'],
                'tanggal' => $carbonDate->toDateString(),
                'ts_awal_shift' => $shift['start']->toDateTimeString(),
                'ts_akhir_shift' => $shift['end']->toDateTimeString(),
                'actual_ts' => $actualTs,
                'durasi_menit' => $durasiMenit,
                'total_counter' => $totalCounter,
                'performance_output_percent' => round($performance, 2),
            ];
        }

        return $results;
    }


    public static function getPerformanceOutput($tanggal = null)
    {
        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);

        $carbonDate = $tanggal
            ? Carbon::parse($tanggal, $timezone)
            : $now->copy();

        if ($tanggal && strlen($tanggal) <= 10) {
            $carbonDate->setTimeFrom($now);
        }

        $currentTime = $carbonDate->format('H:i:s');
        $shift = '';
        $start = null;
        $end = null;

        if ($currentTime >= '06:00:00' && $currentTime <= '14:00:00') {
            $shift = 'Shift 1';
            $start = $carbonDate->copy()->setTime(6, 0, 0);
            $end = $carbonDate->copy()->setTime(14, 0, 0);
        } elseif ($currentTime > '14:00:00' && $currentTime <= '22:00:00') {
            $shift = 'Shift 2';
            $start = $carbonDate->copy()->setTime(14, 0, 1);
            $end = $carbonDate->copy()->setTime(22, 0, 0);
        } else {
            $shift = 'Shift 3';
            if ($currentTime >= '22:00:01') {
                $start = $carbonDate->copy()->setTime(22, 0, 1);
                $end = $carbonDate->copy()->addDay()->setTime(5, 59, 59);
            } else {
                $start = $carbonDate->copy()->subDay()->setTime(22, 0, 1);
                $end = $carbonDate->copy()->setTime(5, 59, 59);
            }
        }

        $durasiMenit = $start->diffInMinutes($carbonDate);

        $data = DB::selectOne("
        WITH shift_data AS (
            SELECT ts, total_counter
            FROM retail_d4
            WHERE ts BETWEEN ? AND ?
            ORDER BY ts
        ),
        with_next AS (
            SELECT 
                ts,
                total_counter,
                LEAD(total_counter) OVER (ORDER BY ts) AS next_counter
            FROM shift_data
        )
        SELECT 
            ts,
            total_counter
        FROM with_next
        WHERE next_counter = 0
        ORDER BY ts DESC
        LIMIT 1
    ", [$start->toDateTimeString(), $carbonDate->toDateTimeString()]);

        if (!$data) {
            $data = DB::selectOne("
            SELECT ts, total_counter
            FROM retail_d4
            WHERE ts <= ?
            ORDER BY ts DESC
            LIMIT 1
        ", [$carbonDate->toDateTimeString()]);
        }

        $totalCounter = $data ? $data->total_counter : 0;

        $performance = $durasiMenit > 0
            ? ($totalCounter / ($durasiMenit * 40 * 2)) * 100
            : 0;

        return [
            'shift' => $shift,
            'tanggal' => $carbonDate->toDateString(),
            'ts_awal_shift' => $start->toDateTimeString(),
            'ts_sekarang' => $carbonDate->toDateTimeString(),
            'durasi_menit' => $durasiMenit,
            'total_counter' => $totalCounter,
            'performance_output_percent' => round($performance, 2),
        ];
    }

}
