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

    public static function getMesinStartPeriods($filterType = 'today', $startDate = null, $endDate = null)
    {
        // Tentukan filter
        $whereClause = "";

        if ($filterType === 'today') {
            $whereClause = "WHERE DATE(waktu) = CURDATE()";
        } elseif ($filterType === 'date' && $startDate) {
            $whereClause = "WHERE DATE(waktu) = '{$startDate}'";
        } elseif ($filterType === 'range' && $startDate && $endDate) {
            $whereClause = "WHERE DATE(waktu) BETWEEN '{$startDate}' AND '{$endDate}'";
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

        return DB::select($query);
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
            $start3 = $carbonDate->copy()->subDay()->setTime(22, 1, 0);
            $end3 = $carbonDate->copy()->setTime(5, 59, 59);

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
}
