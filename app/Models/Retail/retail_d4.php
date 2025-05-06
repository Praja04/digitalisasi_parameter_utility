<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class retail_d4 extends Model
{
    //
    use HasFactory;

    protected $table = 'retail_d4';
    protected $primaryKey = 'id';
    public $timestamps = false; // Karena sudah ada kolom `waktu` yang otomatis

    protected $fillable = [
        'waktu', 'main_speed', 'total_counter', 'nozzle_1', 'nozzle_2', 'Start_Mesin'
    ];

    public static function getMesinStartPeriods($filterType = 'realtime', $startDate = null, $endDate = null)
    {
        $bindings = [];
        $whereClause = "";

        // Normalisasi nilai filter agar lebih fleksibel
        $filterType = strtolower($filterType);
        if ($filterType === 'tanggal') {
            $filterType = 'date';
        }

        // Bangun WHERE clause berdasarkan filter
        if ($filterType === 'realtime') {
            $whereClause = "WHERE DATE(waktu) = CURDATE()";
        } elseif ($filterType === 'date' && $startDate) {
            $whereClause = "WHERE DATE(waktu) = ?";
            $bindings[] = $startDate;
        } elseif ($filterType === 'range' && $startDate && $endDate) {
            $whereClause = "WHERE DATE(waktu) BETWEEN ? AND ?";
            $bindings[] = $startDate;
            $bindings[] = $endDate;
        }

        $query = "
        WITH flagged_status AS (
            SELECT 
                waktu,
                Start_Mesin,
                CASE 
                    WHEN Start_Mesin = 1 THEN 1 ELSE 0
                END AS is_running
            FROM retail_d4
            {$whereClause}
        ),
        grouped_blocks AS (
            SELECT *,
                ROW_NUMBER() OVER (ORDER BY waktu)
              - ROW_NUMBER() OVER (PARTITION BY is_running ORDER BY waktu) AS group_id
            FROM flagged_status
        )
        SELECT 
            MIN(waktu) AS Waktu_mulai,
            MAX(waktu) AS Waktu_akhir
        FROM grouped_blocks
        WHERE is_running = 1
        GROUP BY group_id
        ORDER BY Waktu_mulai
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

            $start2 = $carbonDate->copy()->setTime(14, 1, 0);
            $end2 = $carbonDate->copy()->setTime(22, 0, 0);

            // 🔥 Shift 3: Mulai dari hari sebelumnya jam 22:01 sampai hari ini jam 05:59
            $start3 = $carbonDate->copy()->subDay()->setTime(22, 1, 0);
            $end3 = $carbonDate->copy()->setTime(5, 59, 59);

            $totalShift1 += self::whereBetween('waktu', [$start1, $end1])->sum('total_counter');
            $totalShift2 += self::whereBetween('waktu', [$start2, $end2])->sum('total_counter');
            $totalShift3 += self::whereBetween('waktu', [$start3, $end3])->sum('total_counter');
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
            $start2 = $carbonDate->copy()->setTime(14, 1, 0);
            $end2 = $carbonDate->copy()->setTime(22, 0, 0);

            // Shift 3: 22:01 (hari sebelumnya) - 05:59 (hari ini)
            $start3 = $carbonDate->copy()->setTime(22, 1, 0);
            $end3 = $carbonDate->copy()->addDay()->setTime(5, 59, 59);

            // Hitung setiap shift
            $result['shift_1']['nozzle_1'] += self::whereBetween('waktu', [$start1, $end1])->sum('nozzle_1');
            $result['shift_1']['nozzle_2'] += self::whereBetween('waktu', [$start1, $end1])->sum('nozzle_2');

            $result['shift_2']['nozzle_1'] += self::whereBetween('waktu', [$start2, $end2])->sum('nozzle_1');
            $result['shift_2']['nozzle_2'] += self::whereBetween('waktu', [$start2, $end2])->sum('nozzle_2');

            $result['shift_3']['nozzle_1'] += self::whereBetween('waktu', [$start3, $end3])->sum('nozzle_1');
            $result['shift_3']['nozzle_2'] += self::whereBetween('waktu', [$start3, $end3])->sum('nozzle_2');
        }

        return $result;
    }

    //performance mesin
    // public static function getTotalMesinRunningMinutes($filterType = 'realtime', $startDate = null, $endDate = null)
    // {
    //     $bindings = [];
    //     $whereClause = "";

    //     if ($filterType === 'realtime') {
    //         $whereClause = "WHERE DATE(waktu) = CURDATE()";
    //     } elseif ($filterType === 'date' && $startDate) {
    //         $whereClause = "WHERE DATE(waktu) = ?";
    //         $bindings[] = $startDate;
    //     } elseif ($filterType === 'range' && $startDate && $endDate) {
    //         $whereClause = "WHERE DATE(waktu) BETWEEN ? AND ?";
    //         $bindings[] = $startDate;
    //         $bindings[] = $endDate;
    //     }

    //     $query = "
    // WITH flagged_status AS (
    //     SELECT 
    //         waktu,
    //         Start_Mesin,
    //         CASE 
    //             WHEN Start_Mesin = 1 THEN 1 ELSE 0
    //         END AS is_running
    //     FROM retail_d4
    //     {$whereClause}
    // ),
    // grouped_blocks AS (
    //     SELECT * ,
    //         ROW_NUMBER() OVER (ORDER BY waktu)
    //       - ROW_NUMBER() OVER (PARTITION BY is_running ORDER BY waktu) AS group_id
    //     FROM flagged_status
    // )
    // SELECT 
    //     MIN(waktu) AS Waktu_mulai,
    //     MAX(waktu) AS Waktu_akhir
    // FROM grouped_blocks
    // WHERE is_running = 1
    // GROUP BY group_id
    // ORDER BY Waktu_mulai
    // ";

    //     $periods = DB::select($query, $bindings);

    //     // Menghitung total menit
    //     $totalMinutes = 0;

    //     foreach ($periods as $period) {
    //         $start = \Carbon\Carbon::parse($period->Waktu_mulai);
    //         $end = \Carbon\Carbon::parse($period->Waktu_akhir);
    //         $totalMinutes += $start->diffInMinutes($end); // Menghitung selisih dalam menit
    //     }

    //     return $totalMinutes; // Total menit mesin berjalan
    // }

    public static function getTotalMesinRunningMinutesByShift($filterType = 'realtime', $startDate = null, $endDate = null)
    {
        $bindings = [];
        $whereClause = "";

        if ($filterType === 'realtime') {
            $whereClause = "WHERE DATE(waktu) = CURDATE()";
        } elseif ($filterType === 'date' && $startDate) {
            $whereClause = "WHERE DATE(waktu) = ?";
            $bindings[] = $startDate;
        } elseif ($filterType === 'range' && $startDate && $endDate) {
            $whereClause = "WHERE DATE(waktu) BETWEEN ? AND ?";
            $bindings[] = $startDate;
            $bindings[] = $endDate;
        }

        $query = "
            WITH flagged_status AS (
                SELECT 
                    waktu,
                    Start_Mesin,
                    CASE 
                        WHEN Start_Mesin = 1 THEN 1 ELSE 0
                    END AS is_running
                FROM retail_d4
                {$whereClause}
            ),
            grouped_blocks AS (
                SELECT *,
                    ROW_NUMBER() OVER (ORDER BY waktu)
                    - ROW_NUMBER() OVER (PARTITION BY is_running ORDER BY waktu) AS group_id
                FROM flagged_status
            )
            SELECT 
                MIN(waktu) AS Waktu_mulai,
                MAX(waktu) AS Waktu_akhir
            FROM grouped_blocks
            WHERE is_running = 1
            GROUP BY group_id
            ORDER BY Waktu_mulai
            ";

        $periods = DB::select($query, $bindings);

        // Menghitung total menit per shift
        $shift1 = $shift2 = $shift3 = 0;

        foreach ($periods as $period) {
            $start = \Carbon\Carbon::parse($period->Waktu_mulai);
            $end = \Carbon\Carbon::parse($period->Waktu_akhir);
            $minutes = $start->diffInMinutes($end); // Menghitung selisih dalam menit

            // Menghitung durasi mesin menyala dalam setiap shift
            while ($start < $end) {
                $currentTime = \Carbon\Carbon::parse($start);
                if ($currentTime->between(\Carbon\Carbon::parse('06:00:00'), \Carbon\Carbon::parse('14:00:00'))) {
                    // Shift 1 (06:00 - 14:00)
                    $shift1 += 1;
                } elseif ($currentTime->between(\Carbon\Carbon::parse('14:01:00'), \Carbon\Carbon::parse('22:00:00'))) {
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
            $whereClause = "WHERE DATE(waktu) = CURDATE()";
        } elseif ($filterType === 'date' && $startDate) {
            $whereClause = "WHERE DATE(waktu) = ?";
            $bindings[] = $startDate;
        } elseif ($filterType === 'range' && $startDate && $endDate) {
            $whereClause = "WHERE DATE(waktu) BETWEEN ? AND ?";
            $bindings[] = $startDate;
            $bindings[] = $endDate;
        }

        $query = "
        WITH flagged_status AS (
            SELECT 
                waktu,
                Start_Mesin,
                CASE 
                    WHEN Start_Mesin = 0 THEN 1 ELSE 0
                END AS is_down
            FROM retail_d4
            {$whereClause}
        ),
        grouped_blocks AS (
            SELECT * ,
                ROW_NUMBER() OVER (ORDER BY waktu)
                - ROW_NUMBER() OVER (PARTITION BY is_down ORDER BY waktu) AS group_id
            FROM flagged_status
        )
        SELECT 
            MIN(waktu) AS Waktu_mulai,
            MAX(waktu) AS Waktu_akhir
        FROM grouped_blocks
        WHERE is_down = 1
        GROUP BY group_id
        ORDER BY Waktu_mulai
        ";

        $periods = DB::select($query, $bindings);

        // Menghitung total menit downtime
        $shift1 = $shift2 = $shift3 = 0; // Variabel untuk menyimpan menit downtime per shift

        foreach ($periods as $period) {
            $start = \Carbon\Carbon::parse($period->Waktu_mulai);
            $end = \Carbon\Carbon::parse($period->Waktu_akhir);
            $minutes = $start->diffInMinutes($end); // Menghitung selisih dalam menit

            // Memecah waktu downtime ke dalam 3 shift
            while ($start < $end) {
                $currentTime = \Carbon\Carbon::parse($start);
                if ($currentTime->between(\Carbon\Carbon::parse('06:00:00'), \Carbon\Carbon::parse('14:00:00'))) {
                    // Shift 1 (06:00 - 14:00)
                    $shift1 += 1;
                } elseif ($currentTime->between(\Carbon\Carbon::parse('14:01:00'), \Carbon\Carbon::parse('22:00:00'))) {
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

        // Variabel untuk menyimpan total waktu
        $totalWaktu = 0;

        // Menjumlahkan durasi untuk setiap periode
        foreach ($data as $item) {
            $waktuMulai = \Carbon\Carbon::parse($item->Waktu_mulai);
            $waktuAkhir = \Carbon\Carbon::parse($item->Waktu_akhir);

            // Pastikan waktu akhir selalu lebih besar dari waktu mulai
            if ($waktuAkhir < $waktuMulai) {
                // Tukar posisi jika waktu akhir lebih kecil
                $temp = $waktuMulai;
                $waktuMulai = $waktuAkhir;
                $waktuAkhir = $temp;
            }

            // Menghitung selisih waktu dalam menit
            $durasi = Carbon::parse($waktuMulai)->diffInMinutes($waktuAkhir);

            // Menambahkan durasi ke total waktu
            $totalWaktu += $durasi;

            // Optional: return data per item untuk debugging
            // Bisa mengembalikan detail setiap item dan durasi per item
            $item->durasi = $durasi; // Menyimpan durasi di item untuk debugging
        }

        // Return array data beserta total waktu untuk debugging
        return [
            'totalWaktu' => $totalWaktu,
            'data' => $data // Mengembalikan data yang diproses
        ];
    }

    //berhasil

    // public static function getDurasiMesinPerShift($tanggal = null)
    // {
    //     // Jika tidak ada tanggal yang diberikan, gunakan tanggal hari ini
    //     if (!$tanggal) {
    //         $tanggal = Carbon::now()->toDateString();
    //     }

    //     return DB::select("
    //     SELECT
    //         shift,
    //         tanggal_shift,
    //         COUNT(*) AS total_detik_menyala,
    //         SEC_TO_TIME(COUNT(*)) AS durasi_menyala
    //     FROM (
    //         -- Shift 1
    //         SELECT 'Shift 1' AS shift,
    //                DATE(waktu) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) BETWEEN '06:00:00' AND '14:00:00'
    //           AND Start_Mesin = 1
    //           AND DATE(waktu) = ?

    //         UNION ALL

    //         -- Shift 2
    //         SELECT 'Shift 2' AS shift,
    //                DATE(waktu) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) BETWEEN '14:01:00' AND '22:00:00'
    //           AND Start_Mesin = 1
    //           AND DATE(waktu) = ?

    //         UNION ALL

    //         -- Shift 3 Malam
    //         SELECT 'Shift 3' AS shift,
    //                DATE(waktu) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) >= '22:01:00'
    //           AND Start_Mesin = 1
    //           AND DATE(waktu) = ?

    //         UNION ALL

    //         -- Shift 3 Dini Hari (tanggal sebelumnya)
    //         SELECT 'Shift 3' AS shift,
    //                DATE(waktu - INTERVAL 1 DAY) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) <= '05:59:59'
    //           AND Start_Mesin = 1
    //           AND DATE(waktu - INTERVAL 1 DAY) = ?
    //     ) AS shifts
    //     GROUP BY shift, tanggal_shift
    //     ORDER BY tanggal_shift, FIELD(shift, 'Shift 1', 'Shift 2', 'Shift 3')
    // ", [$tanggal, $tanggal, $tanggal, $tanggal]);
    // }
    public static function getDurasiMesinPerShift($tanggal = null)
    {
        if (!$tanggal) {
            $tanggal = Carbon::now()->toDateString();
        }

        return DB::select("
        WITH status_dengan_shift AS (
            SELECT 
                waktu,
                Start_Mesin,
                CASE
                    WHEN TIME(waktu) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                    WHEN TIME(waktu) BETWEEN '14:01:00' AND '22:00:00' THEN 'Shift 2'
                    WHEN TIME(waktu) >= '22:01:00' THEN 'Shift 3'
                    WHEN TIME(waktu) <= '05:59:59' THEN 'Shift 3'
                END AS shift,
                LAG(Start_Mesin) OVER (
                    PARTITION BY 
                        CASE
                            WHEN TIME(waktu) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                            WHEN TIME(waktu) BETWEEN '14:01:00' AND '22:00:00' THEN 'Shift 2'
                            WHEN TIME(waktu) >= '22:01:00' THEN 'Shift 3'
                            WHEN TIME(waktu) <= '05:59:59' THEN 'Shift 3'
                        END
                    ORDER BY waktu
                ) AS prev_status
            FROM retail_d4
            WHERE DATE(waktu) = ? OR DATE(waktu) = DATE_SUB(?, INTERVAL 1 DAY)
        ),
        blok AS (
            SELECT 
                waktu,
                shift,
                Start_Mesin,
                SUM(CASE 
                    WHEN Start_Mesin = 1 AND (prev_status = 0 OR prev_status IS NULL) THEN 1 
                    ELSE 0 
                END) OVER (
                    PARTITION BY shift 
                    ORDER BY waktu 
                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                ) AS group_id
            FROM status_dengan_shift
        ),
        durasi_per_shift AS (
            SELECT 
                shift,
                MIN(waktu) AS waktu_mulai,
                MAX(waktu) AS waktu_akhir,
                TIMESTAMPDIFF(SECOND, MIN(waktu), MAX(waktu)) AS durasi_detik
            FROM blok
            WHERE Start_Mesin = 1
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


    //uptime mesin
    // public static function getUptime($tanggal = null)
    // {
    //     // Jika tidak ada tanggal yang diberikan, gunakan tanggal hari ini
    //     if (!$tanggal) {
    //         $tanggal = Carbon::now()->toDateString();
    //     }

    //     // Mendapatkan data dari database sesuai dengan query sebelumnya
    //     $data = DB::select("
    //     SELECT
    //         shift,
    //         tanggal_shift,
    //         COUNT(*) AS total_detik_menyala,
    //         SEC_TO_TIME(COUNT(*)) AS durasi_menyala
    //     FROM (
    //         -- Shift 1
    //         SELECT 'Shift 1' AS shift,
    //                DATE(waktu) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) BETWEEN '06:00:00' AND '14:00:00'
    //           AND Start_Mesin = 1
    //           AND DATE(waktu) = ?

    //         UNION ALL

    //         -- Shift 2
    //         SELECT 'Shift 2' AS shift,
    //                DATE(waktu) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) BETWEEN '14:01:00' AND '22:00:00'
    //           AND Start_Mesin = 1
    //           AND DATE(waktu) = ?

    //         UNION ALL

    //         -- Shift 3 Malam
    //         SELECT 'Shift 3' AS shift,
    //                DATE(waktu) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) >= '22:01:00'
    //           AND Start_Mesin = 1
    //           AND DATE(waktu) = ?

    //         UNION ALL

    //         -- Shift 3 Dini Hari (tanggal sebelumnya)
    //         SELECT 'Shift 3' AS shift,
    //                DATE(waktu - INTERVAL 1 DAY) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) <= '05:59:59'
    //           AND Start_Mesin = 1
    //           AND DATE(waktu - INTERVAL 1 DAY) = ?
    //     ) AS shifts
    //     GROUP BY shift, tanggal_shift
    //     ORDER BY tanggal_shift, FIELD(shift, 'Shift 1', 'Shift 2', 'Shift 3')
    //  ", [$tanggal, $tanggal, $tanggal, $tanggal]);

    //     // Menghitung mesin yang berjalan dalam menit per shift, dibagi dengan total menit dalam 7 jam (420 menit)
    //     $result = [];
    //     foreach ($data as $item) {
    //         // Hitung total detik menyala per shift
    //         $detikMenyala = $item->total_detik_menyala;

    //         // Ubah detik ke menit
    //         $menitMenyala = $detikMenyala / 60;

    //         // Hitung mesin run dalam menit dibagi dengan 420 menit
    //         $mesinRunPerShift = $menitMenyala / 420;

    //         // Simpan hasil dalam array dengan format yang diinginkan
    //         $result[] = [
    //             'shift' => $item->shift,
    //             'durasi' => $menitMenyala,
    //             'tanggal_shift' => $item->tanggal_shift,
    //             'mesin_uptime' => $mesinRunPerShift * 100, // Mesin run dalam perbandingan dengan 7 jam
    //         ];
    //     }

    //     return $result;
    // }

    public static function getUptime($tanggal = null)
    {
        if (!$tanggal) {
            $tanggal = Carbon::now()->toDateString();
        }

        $data = DB::select("
        WITH status_dengan_shift AS (
            SELECT 
                waktu,
                Start_Mesin,
                CASE
                    WHEN TIME(waktu) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                    WHEN TIME(waktu) BETWEEN '14:01:00' AND '22:00:00' THEN 'Shift 2'
                    WHEN TIME(waktu) >= '22:01:00' THEN 'Shift 3'
                    WHEN TIME(waktu) <= '05:59:59' THEN 'Shift 3'
                END AS shift,
                LAG(Start_Mesin) OVER (PARTITION BY 
                    CASE
                        WHEN TIME(waktu) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                        WHEN TIME(waktu) BETWEEN '14:01:00' AND '22:00:00' THEN 'Shift 2'
                        WHEN TIME(waktu) >= '22:01:00' THEN 'Shift 3'
                        WHEN TIME(waktu) <= '05:59:59' THEN 'Shift 3'
                    END
                    ORDER BY waktu) AS prev_status
            FROM retail_d4
            WHERE DATE(waktu) = ? OR DATE(waktu) = DATE_SUB(?, INTERVAL 1 DAY)
        ),
        blok AS (
            SELECT 
                waktu,
                shift,
                Start_Mesin,
                SUM(CASE 
                    WHEN Start_Mesin = 1 AND (prev_status = 0 OR prev_status IS NULL) THEN 1 
                    ELSE 0 
                END) OVER (PARTITION BY shift ORDER BY waktu ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) AS group_id
            FROM status_dengan_shift
        ),
        durasi_per_shift AS (
            SELECT 
                shift,
                MIN(waktu) AS waktu_mulai,
                MAX(waktu) AS waktu_akhir,
                TIMESTAMPDIFF(SECOND, MIN(waktu), MAX(waktu)) AS durasi_detik
            FROM blok
            WHERE Start_Mesin = 1
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



    //downtime mesin
    // public static function getDownTime($tanggal = null)
    // {
    //     // Jika tidak ada tanggal yang diberikan, gunakan tanggal hari ini
    //     if (!$tanggal) {
    //         $tanggal = Carbon::now()->toDateString();
    //     }

    //     // Mendapatkan data dari database sesuai dengan query sebelumnya
    //     $data = DB::select("
    //     SELECT
    //         shift,
    //         tanggal_shift,
    //         COUNT(*) AS total_detik_mati,
    //         SEC_TO_TIME(COUNT(*)) AS durasi_mati
    //     FROM (
    //         -- Shift 1
    //         SELECT 'Shift 1' AS shift,
    //                DATE(waktu) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) BETWEEN '06:00:00' AND '14:00:00'
    //           AND Start_Mesin = 0
    //           AND DATE(waktu) = ?

    //         UNION ALL

    //         -- Shift 2
    //         SELECT 'Shift 2' AS shift,
    //                DATE(waktu) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) BETWEEN '14:01:00' AND '22:00:00'
    //           AND Start_Mesin = 0
    //           AND DATE(waktu) = ?

    //         UNION ALL

    //         -- Shift 3 Malam
    //         SELECT 'Shift 3' AS shift,
    //                DATE(waktu) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) >= '22:01:00'
    //           AND Start_Mesin = 0
    //           AND DATE(waktu) = ?

    //         UNION ALL

    //         -- Shift 3 Dini Hari (tanggal sebelumnya)
    //         SELECT 'Shift 3' AS shift,
    //                DATE(waktu - INTERVAL 1 DAY) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) <= '05:59:59'
    //           AND Start_Mesin = 0
    //           AND DATE(waktu - INTERVAL 1 DAY) = ?
    //     ) AS shifts
    //     GROUP BY shift, tanggal_shift
    //     ORDER BY tanggal_shift, FIELD(shift, 'Shift 1', 'Shift 2', 'Shift 3')
    //  ", [$tanggal, $tanggal, $tanggal, $tanggal]);

    //     // Menghitung mesin yang berjalan dalam menit per shift, dibagi dengan total menit dalam 7 jam (420 menit)
    //     $result = [];
    //     foreach ($data as $item) {
    //         // Hitung total detik menyala per shift
    //         $detikMati = $item->total_detik_mati;

    //         // Ubah detik ke menit
    //         $menitMati = $detikMati / 60;

    //         // Hitung mesin run dalam menit dibagi dengan 420 menit
    //         $mesinRunPerShift = $menitMati / 420;

    //         // Simpan hasil dalam array dengan format yang diinginkan
    //         $result[] = [
    //             'shift' => $item->shift,
    //             'durasi' => $menitMati,
    //             'tanggal_shift' => $item->tanggal_shift,
    //             'mesin_downtime' => $mesinRunPerShift * 100, // Mesin run dalam perbandingan dengan 7 jam
    //         ];
    //     }

    //     return $result;
    // }

    public static function getDownTime($tanggal = null)
    {
        if (!$tanggal) {
            $tanggal = Carbon::now()->toDateString();
        }

        $data = DB::select("
        WITH status_dengan_shift AS (
            SELECT 
                waktu,
                Start_Mesin,
                CASE
                    WHEN TIME(waktu) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                    WHEN TIME(waktu) BETWEEN '14:01:00' AND '22:00:00' THEN 'Shift 2'
                    WHEN TIME(waktu) >= '22:01:00' THEN 'Shift 3'
                    WHEN TIME(waktu) <= '05:59:59' THEN 'Shift 3'
                END AS shift,
                LAG(Start_Mesin) OVER (
                    PARTITION BY 
                        CASE
                            WHEN TIME(waktu) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                            WHEN TIME(waktu) BETWEEN '14:01:00' AND '22:00:00' THEN 'Shift 2'
                            WHEN TIME(waktu) >= '22:01:00' THEN 'Shift 3'
                            WHEN TIME(waktu) <= '05:59:59' THEN 'Shift 3'
                        END
                    ORDER BY waktu
                ) AS prev_status
            FROM retail_d4
            WHERE DATE(waktu) = ? OR DATE(waktu) = DATE_SUB(?, INTERVAL 1 DAY)
        ),
        blok AS (
            SELECT 
                waktu,
                shift,
                Start_Mesin,
                SUM(CASE 
                    WHEN Start_Mesin = 0 AND (prev_status = 1 OR prev_status IS NULL) THEN 1 
                    ELSE 0 
                END) OVER (
                    PARTITION BY shift 
                    ORDER BY waktu 
                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                ) AS group_id
            FROM status_dengan_shift
        ),
        durasi_per_shift AS (
            SELECT 
                shift,
                MIN(waktu) AS waktu_mulai,
                MAX(waktu) AS waktu_akhir,
                TIMESTAMPDIFF(SECOND, MIN(waktu), MAX(waktu)) AS durasi_detik
            FROM blok
            WHERE Start_Mesin = 0
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




    // public static function getUptimeWithRealtime($tanggal = null)
    // {
    //     // Jika tidak ada tanggal yang diberikan, gunakan tanggal hari ini
    //     if (!$tanggal) {
    //         $tanggal = Carbon::now()->toDateString();
    //     }

    //     // Mendapatkan data dari database sesuai dengan query sebelumnya
    //     $data = DB::select("
    //     SELECT
    //         shift,
    //         tanggal_shift,
    //         COUNT(*) AS total_detik_menyala,
    //         SEC_TO_TIME(COUNT(*)) AS durasi_menyala
    //     FROM (
    //         -- Shift 1
    //         SELECT 'Shift 1' AS shift,
    //                DATE(waktu) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) BETWEEN '06:00:00' AND '14:00:00'
    //           AND Start_Mesin = 1
    //           AND DATE(waktu) = ?

    //         UNION ALL

    //         -- Shift 2
    //         SELECT 'Shift 2' AS shift,
    //                DATE(waktu) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) BETWEEN '14:01:00' AND '22:00:00'
    //           AND Start_Mesin = 1
    //           AND DATE(waktu) = ?

    //         UNION ALL

    //         -- Shift 3 Malam
    //         SELECT 'Shift 3' AS shift,
    //                DATE(waktu) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) >= '22:01:00'
    //           AND Start_Mesin = 1
    //           AND DATE(waktu) = ?

    //         UNION ALL

    //         -- Shift 3 Dini Hari (tanggal sebelumnya)
    //         SELECT 'Shift 3' AS shift,
    //                DATE(waktu - INTERVAL 1 DAY) AS tanggal_shift,
    //                waktu
    //         FROM retail_d4
    //         WHERE TIME(waktu) <= '05:59:59'
    //           AND Start_Mesin = 1
    //           AND DATE(waktu - INTERVAL 1 DAY) = ?
    //     ) AS shifts
    //     GROUP BY shift, tanggal_shift
    //     ORDER BY tanggal_shift, FIELD(shift, 'Shift 1', 'Shift 2', 'Shift 3')
    //   ", [$tanggal, $tanggal, $tanggal, $tanggal]);

    //     // Ambil waktu sekarang
    //     $currentTime = Carbon::now();

    //     // Menghitung mesin yang berjalan dalam menit per shift, dibagi dengan waktu yang telah berlalu dari awal shift
    //     $result = [];
    //     foreach ($data as $item) {
    //         // Hitung total detik menyala per shift
    //         $detikMenyala = $item->total_detik_menyala;

    //         // Ubah detik ke menit
    //         $menitMenyala = $detikMenyala / 60;

    //         // Tentukan durasi shift
    //         $shiftStartTime = Carbon::createFromFormat('H:i:s', '06:00:00'); // Default shift 1 start time
    //         $shiftEndTime = Carbon::createFromFormat('H:i:s', '14:00:00'); // Default shift 1 end time

    //         if ($item->shift == 'Shift 2') {
    //             $shiftStartTime = Carbon::createFromFormat('H:i:s', '14:01:00');
    //             $shiftEndTime = Carbon::createFromFormat('H:i:s', '22:00:00');
    //         } elseif ($item->shift == 'Shift 3') {
    //             $shiftStartTime = Carbon::createFromFormat('H:i:s', '22:01:00');
    //             $shiftEndTime = Carbon::createFromFormat('H:i:s', '06:00:00');
    //         }

    //         // Periksa apakah shift saat ini sedang aktif
    //         // Untuk Shift 3, kita perlu menangani logika waktu yang melintasi tengah malam.
    //         if ($item->shift == 'Shift 3') {
    //             if ($currentTime->between($shiftStartTime, Carbon::createFromFormat('H:i:s', '23:59:59'))) {
    //                 // Shift 3 pada malam hari
    //                 $shiftDurationInMinutes = $currentTime->diffInMinutes($shiftStartTime);
    //             } elseif ($currentTime->between(Carbon::createFromFormat('H:i:s', '00:00:00'), $shiftEndTime)) {
    //                 // Shift 3 pada dini hari (melalui tengah malam)
    //                 $shiftDurationInMinutes = $currentTime->diffInMinutes(Carbon::createFromFormat('H:i:s', '00:00:00'));
    //             } else {
    //                 // Jika waktu sudah lewat shift, gunakan durasi shift standar
    //                 $shiftDurationInMinutes = 420;
    //             }
    //         } else {
    //             // Untuk Shift 1 dan Shift 2, langsung hitung durasi sesuai dengan waktu sekarang
    //             if ($currentTime->between($shiftStartTime, $shiftEndTime)) {
    //                 $shiftDurationInMinutes = $currentTime->diffInMinutes($shiftStartTime);
    //             } else {
    //                 $shiftDurationInMinutes = 420; // Shift selesai, gunakan durasi penuh
    //             }
    //         }

    //         // Jika shift saat ini aktif, hitung uptime mesin
    //         if ($shiftDurationInMinutes > 0) {
    //             // Hitung mesin run dalam menit dibagi dengan durasi shift yang berlalu
    //             $mesinRunPerShift = $menitMenyala / $shiftDurationInMinutes;

    //             // Simpan hasil dalam array dengan format yang diinginkan
    //             $result[] = [
    //                 'shift' => $item->shift,
    //                 'durasi' => $menitMenyala,
    //                 'tanggal_shift' => $item->tanggal_shift,
    //                 'mesin_uptime' => $mesinRunPerShift * 100, // Mesin run dalam perbandingan dengan durasi shift yang telah berlalu
    //             ];
    //         }
    //     }

    //     return $result;
    // }

    public static function getUptimeWithRealtime($tanggal = null)
    {
        // Pastikan menggunakan zona waktu Asia/Jakarta (WIB)
        $currentTime = Carbon::now('Asia/Jakarta');  // Menggunakan WIB untuk waktu sekarang

        // Jika tidak ada tanggal diberikan, gunakan hari ini
        if (!$tanggal) {
            $tanggal = $currentTime->toDateString();
        }

        $tanggalKemarin = Carbon::parse($tanggal)->subDay()->toDateString();

        // SQL query menggunakan CTE
        $data = DB::select(" 
        WITH status_dengan_shift AS (
            SELECT 
                waktu,
                Start_Mesin,
                CASE
                    WHEN TIME(waktu) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                    WHEN TIME(waktu) BETWEEN '14:01:00' AND '22:00:00' THEN 'Shift 2'
                    WHEN TIME(waktu) >= '22:01:00' THEN 'Shift 3'
                    WHEN TIME(waktu) <= '05:59:59' THEN 'Shift 3'
                END AS shift,
                LAG(Start_Mesin) OVER (
                    PARTITION BY CASE
                        WHEN TIME(waktu) BETWEEN '06:00:00' AND '14:00:00' THEN 'Shift 1'
                        WHEN TIME(waktu) BETWEEN '14:01:00' AND '22:00:00' THEN 'Shift 2'
                        WHEN TIME(waktu) >= '22:01:00' THEN 'Shift 3'
                        WHEN TIME(waktu) <= '05:59:59' THEN 'Shift 3'
                    END
                    ORDER BY waktu
                ) AS prev_status
            FROM retail_d4
            WHERE DATE(waktu) IN (?, ?)
        ),
        blok AS (
            SELECT 
                waktu,
                shift,
                Start_Mesin,
                SUM(
                    CASE 
                        WHEN Start_Mesin = 1 AND (prev_status = 0 OR prev_status IS NULL) THEN 1 
                        ELSE 0 
                    END
                ) OVER (PARTITION BY shift ORDER BY waktu ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) AS group_id
            FROM status_dengan_shift
        ),
        durasi_per_shift AS (
            SELECT 
                shift,
                MIN(waktu) AS waktu_mulai,
                MAX(waktu) AS waktu_akhir,
                TIMESTAMPDIFF(SECOND, MIN(waktu), MAX(waktu)) AS durasi_detik
            FROM blok
            WHERE Start_Mesin = 1
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
                $shiftStart = Carbon::createFromTimeString("$tanggal 14:01:00", 'Asia/Jakarta');
            } elseif ($shift == 'Shift 3') {
                $shiftStart = Carbon::createFromTimeString("$tanggal 22:01:00", 'Asia/Jakarta');
            }

            // Jika waktu sekarang lebih kecil dari waktu mulai shift, set durasi berjalan ke 0
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

    //performance output
    public static function getPerformanceOutput($tanggal = null)
    {
        // Set timezone ke Asia/Jakarta
        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);

        // Gunakan waktu saat ini jika tidak diberikan tanggal
        if (!$tanggal) {
            $carbonDate = $now->copy();
        } else {
            $carbonDate = Carbon::parse($tanggal, $timezone)->setTimeFrom($now);
        }

        $currentTime = $carbonDate->format('H:i:s');
        $shift = '';
        $start = null;

        // Tentukan shift dan waktu awal shift
        if ($currentTime >= '06:00:00' && $currentTime <= '14:00:00') {
            $shift = 'Shift 1';
            $start = $carbonDate->copy()->setTime(6, 0, 0);
        } elseif ($currentTime > '14:00:00' && $currentTime <= '22:00:00') {
            $shift = 'Shift 2';
            $start = $carbonDate->copy()->setTime(14, 1, 0);
        } else {
            $shift = 'Shift 3';
            $start = $carbonDate->copy()->setTime(22, 1, 0);
            if ($currentTime <= '05:59:59') {
                // Pukul 00:00–05:59 → tanggal sebelumnya, shift mulai hari kemarin jam 22:01
                $start = $carbonDate->copy()->subDay()->setTime(22, 1, 0);
            }
        }

        // Hitung durasi shift time dalam menit
        $shiftTimeMinutes = ($carbonDate->diffInMinutes($start)) * (-1);

        // Hitung nozzle aktif (nozzle_1 atau nozzle_2 = 1) dari start hingga now
        $totalNozzleAktif = self::whereBetween('waktu', [$start, $carbonDate])
            ->where(function ($query) {
                $query->where('nozzle_1', 1)->orWhere('nozzle_2', 1);
            })
            ->get()
            ->reduce(function ($carry, $item) {
                return $carry + ($item->nozzle_1 == 1 ? 1 : 0) + ($item->nozzle_2 == 1 ? 1 : 0);
            }, 0);

        $performance = $shiftTimeMinutes > 0
            ? ($totalNozzleAktif / ($shiftTimeMinutes * 40 * 2)) * 100
            : 0;

        return [
            'shift' => $shift,
            'tanggal' => $carbonDate->toDateString(),
            'waktu_awal_shift' => $start->toDateTimeString(),
            'waktu_sekarang' => $carbonDate->toDateTimeString(),
            'durasi_menit' => $shiftTimeMinutes,
            'total_nozzle_aktif' => $totalNozzleAktif,
            'performance_output_percent' => round($performance, 2),
        ];
    }

    public static function getAllShiftPerformanceOutput($tanggal = null)
    {
        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);

        $carbonDate = $tanggal
            ? Carbon::parse($tanggal, $timezone)
            : $now->copy();

        // Definisi shift
        $shifts = [
            [
                'name' => 'Shift 1',
                'start' => $carbonDate->copy()->setTime(6, 0, 0),
                'end'   => $carbonDate->copy()->setTime(14, 0, 0),
            ],
            [
                'name' => 'Shift 2',
                'start' => $carbonDate->copy()->setTime(14, 1, 0),
                'end'   => $carbonDate->copy()->setTime(22, 0, 0),
            ],
            [
                'name' => 'Shift 3',
                'start' => $carbonDate->copy()->setTime(22, 1, 0),
                'end'   => $carbonDate->copy()->addDay()->setTime(5, 59, 59),
            ],
        ];

        $results = [];

        foreach ($shifts as $shift) {
            $totalNozzleAktif = self::whereBetween('waktu', [$shift['start'], $shift['end']])
                ->where(function ($query) {
                    $query->where('nozzle_1', 1)->orWhere('nozzle_2', 1);
                })
                ->get()
                ->reduce(function ($carry, $item) {
                    return $carry + ($item->nozzle_1 == 1 ? 1 : 0) + ($item->nozzle_2 == 1 ? 1 : 0);
                }, 0);

            $durasiMenit = 420; // Shift tetap 7 jam = 420 menit
            $performance = ($totalNozzleAktif / ($durasiMenit * 40*2)) * 100;

            $results[] = [
                'shift' => $shift['name'],
                'tanggal' => $carbonDate->toDateString(),
                'waktu_awal_shift' => $shift['start']->toDateTimeString(),
                'waktu_akhir_shift' => $shift['end']->toDateTimeString(),
                'durasi_menit' => $durasiMenit,
                'total_nozzle_aktif' => $totalNozzleAktif,
                'performance_output_percent' => round($performance, 2),
            ];
        }

        return $results;
    }

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
                'start' => $carbonDate->copy()->setTime(14, 1, 0),
                'end'   => $carbonDate->copy()->setTime(22, 0, 0),
            ],
            [
                'name' => 'Shift 3',
                'start' => $carbonDate->copy()->setTime(22, 1, 0),
                'end'   => $carbonDate->copy()->addDay()->setTime(5, 59, 59),
            ],
        ];

        $results = [];

        foreach ($shifts as $shift) {
            $data = self::whereBetween('waktu', [$shift['start'], $shift['end']])
                ->orderBy('waktu')
                ->get();

            // 1️⃣ Hitung durasi mesin menyala (Start_Mesin = 1)
            $runningTimeMinutes = 0;
            $previousTime = null;
            foreach ($data as $row) {
                if ($row->Start_Mesin == 1) {
                    if ($previousTime) {
                        $diff = Carbon::parse($row->waktu)->diffInMinutes($previousTime);
                        $runningTimeMinutes += $diff;
                    }
                    $previousTime = Carbon::parse($row->waktu);
                } else {
                    $previousTime = null;
                }
            }

            // 2️⃣ Hitung total nozzle aktif
            $totalNozzleAktif = $data->reduce(function ($carry, $item) {
                return $carry + ($item->nozzle_1 == 1 ? 1 : 0) + ($item->nozzle_2 == 1 ? 1 : 0);
            }, 0);

            // 3️⃣ Ambil nilai actual speed terakhir
            $actualSpeed = optional($data->last())->main_speed ?? 0;
            $hasilrunningtime = $runningTimeMinutes * (-1);
            // 4️⃣ Hitung performance gagal filling
            $denominator = $hasilrunningtime * $actualSpeed * 2;
            $performanceGoodFilling = $denominator > 0
                ? ($totalNozzleAktif / $denominator) * 100
                : 0;
            $performanceGagalFilling= $performanceGoodFilling > 0 ? (100 - $performanceGoodFilling) : 0;
            $results[] = [
                'shift' => $shift['name'],
                'tanggal' => $carbonDate->toDateString(),
                'waktu_awal_shift' => $shift['start']->toDateTimeString(),
                'waktu_akhir_shift' => $shift['end']->toDateTimeString(),
                'akumulasi_menit_mesin_menyala' => $hasilrunningtime,
                'actual_speed' => $actualSpeed,
                'total_nozzle_aktif' => $totalNozzleAktif,
                'performance_gagal_filling_percent' => round($performanceGagalFilling, 2),
            ];
        }

        return $results;
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
                    'start' => $date->copy()->setTime(14, 1, 0),
                    'end'   => $date->copy()->setTime(22, 0, 0),
                ],
                [
                    'name' => 'Shift 3',
                    'start' => $date->copy()->setTime(22, 1, 0),
                    'end'   => $date->copy()->addDay()->setTime(5, 59, 59),
                ],
            ];

            foreach ($shifts as $shift) {
                $data = self::whereBetween('waktu', [$shift['start'], $shift['end']])
                    ->orderBy('waktu')
                    ->get();

                // Hitung running time (Start_Mesin = 1)
                $runningTimeMinutes = 0;
                $previousTime = null;
                foreach ($data as $row) {
                    if ($row->Start_Mesin == 1) {
                        if ($previousTime) {
                            $diff = Carbon::parse($row->waktu)->diffInMinutes($previousTime);
                            $runningTimeMinutes += $diff;
                        }
                        $previousTime = Carbon::parse($row->waktu);
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
                    'waktu_awal_shift' => $shift['start']->toDateTimeString(),
                    'waktu_akhir_shift' => $shift['end']->toDateTimeString(),
                    'akumulasi_menit_mesin_menyala' => $hasilrunningtime,
                    'actual_speed' => $actualSpeed,
                    'total_nozzle_aktif' => $totalNozzleAktif,
                    'performance_gagal_filling_percent' => round($performanceGagalFilling, 2),
                ];
            }
        }

        return $results;
    }


}
