<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use App\Models\Retail\retail_d4_nozzle1;

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

    protected static function getShiftSchedule(Carbon $carbonDate)
    {
        $dayOfWeek = $carbonDate->dayOfWeek;

        if ($dayOfWeek === Carbon::SATURDAY) {
            return [
                [
                    'name' => 'Shift 1',
                    'start' => $carbonDate->copy()->setTime(6, 0, 0),
                    'end'   => $carbonDate->copy()->setTime(11, 0, 0),
                ],
                [
                    'name' => 'Shift 2',
                    'start' => $carbonDate->copy()->setTime(11, 0, 1),
                    'end'   => $carbonDate->copy()->setTime(16, 0, 0),
                ],
                [
                    'name' => 'Shift 3',
                    'start' => $carbonDate->copy()->setTime(16, 0, 1),
                    'end'   => $carbonDate->copy()->setTime(21, 0, 0),
                ],
            ];
        }

        return [
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
    }

    public static function getAllShiftPerformanceOutput($tanggal = null)
    {
        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);
        $carbonDate = $tanggal ? Carbon::parse($tanggal, $timezone) : $now->copy();
        $shifts = self::getShiftSchedule($carbonDate);

        $results = [];

        foreach ($shifts as $shift) {
            $oneHourBeforeEnd = $shift['end']->copy()->subHour();
            $useLatestOnly = $now->lt($oneHourBeforeEnd);

            if ($useLatestOnly) {
                $data = DB::table('retail_d4')
                    ->whereBetween('ts', [$shift['start'], $shift['end']])
                    ->orderByDesc('ts')
                    ->limit(1)
                    ->first();
            } else {
                $rangeStart = $oneHourBeforeEnd;
                $rangeEnd = $shift['end'];

                $data = DB::selectOne("
                WITH range_data AS (
                    SELECT ts, total_counter FROM retail_d4
                    WHERE ts BETWEEN ? AND ?
                ),
                zero_ts AS (
                    SELECT ts FROM range_data WHERE total_counter = 0 ORDER BY ts LIMIT 1
                ),
                before_zero AS (
                    SELECT * FROM range_data
                    WHERE ts < (SELECT ts FROM zero_ts)
                    ORDER BY ts DESC LIMIT 1
                ),
                fallback AS (
                    SELECT * FROM range_data ORDER BY ts DESC LIMIT 1
                )
                SELECT * FROM before_zero
                UNION ALL
                SELECT * FROM fallback
                WHERE NOT EXISTS (SELECT 1 FROM before_zero)
                LIMIT 1
            ", [
                    $rangeStart->toDateTimeString(),
                    $rangeEnd->toDateTimeString(),
                ]);
            }

            $totalCounter = $data ? $data->total_counter : 0;
            $actualTs = $data ? $data->ts : null;

            $durasiMenit = 0;
            $isToday = $carbonDate->isSameDay($now);

            if ($isToday) {
                // Jika tanggal shift adalah hari ini
                if ($actualTs && strtotime($actualTs) >= $shift['start']->getTimestamp()) {
                    $actualCarbon = Carbon::parse($actualTs, $timezone);
                    $durasiMenit = $shift['start']->diffInMinutes($actualCarbon);
                }
            } else {
                // Jika tanggal shift adalah hari sebelumnya
                $durasiMenit = 420;
            }

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
    public static function getPerformanceGagalFilling($tanggal = null)
    {
        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);
        $carbonDate = $tanggal
            ? Carbon::parse($tanggal, $timezone)
            : $now->copy();

        // Ambil shift schedule dinamis sesuai hari (termasuk Sabtu)
        $shifts = self::getShiftSchedule($carbonDate);
        $results = [];

        foreach ($shifts as $shift) {
            // Ambil data selama shift
            $data = self::whereBetween('ts', [$shift['start'], $shift['end']])
                ->orderBy('ts')
                ->get();

            $runningTimeMinutes = $data->where('start_mesin', 1)->count();
            $runningTimeMinutesCount = $runningTimeMinutes / 60;
            $actualSpeed = optional($data->last())->main_speed ?? 0;

            // Logic 1 jam terakhir shift
            $oneHourBeforeEnd = $shift['end']->copy()->subHour();
            $useLatestOnly = $now->lt($oneHourBeforeEnd);

            if ($useLatestOnly) {
                $row = self::whereBetween('ts', [$shift['start'], $shift['end']])
                    ->orderByDesc('ts')
                    ->first();
            } else {
                $rangeStart = $oneHourBeforeEnd;
                $rangeEnd = $shift['end'];

                $row = DB::selectOne("
                WITH range_data AS (
                    SELECT * FROM retail_d4
                    WHERE ts BETWEEN ? AND ?
                ),
                zero_ts AS (
                    SELECT ts FROM range_data WHERE total_counter = 0 ORDER BY ts LIMIT 1
                ),
                before_zero AS (
                    SELECT * FROM range_data
                    WHERE ts < (SELECT ts FROM zero_ts)
                    ORDER BY ts DESC LIMIT 1
                ),
                fallback AS (
                    SELECT * FROM range_data
                    ORDER BY ts DESC LIMIT 1
                )
                SELECT * FROM before_zero
                UNION ALL
                SELECT * FROM fallback
                WHERE NOT EXISTS (SELECT 1 FROM before_zero)
                LIMIT 1
            ", [
                    $rangeStart->toDateTimeString(),
                    $rangeEnd->toDateTimeString(),
                ]);
            }

            $totalNozzleAktif = $row ? $row->total_counter : 0;
            $actualTS = $row ? $row->ts : null;

            $denominator = $runningTimeMinutesCount * $actualSpeed * 2;
            $performanceGoodFilling = $denominator > 0
                ? (($totalNozzleAktif / $denominator) * 100)
                : 0;
            $performanceGagalFilling = $performanceGoodFilling > 0
                ? (100 - $performanceGoodFilling)
                : 0;

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
    public static function getPerformanceOutput($tanggal = null)
    {
        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);
        $carbonDate = $tanggal ? Carbon::parse($tanggal, $timezone) : $now->copy();

        if ($tanggal && strlen($tanggal) <= 10) {
            $carbonDate->setTimeFrom($now);
        }

        $shiftList = self::getShiftSchedule($carbonDate);
        $currentTime = $carbonDate->format('H:i:s');
        $shift = '';
        $start = null;

        foreach ($shiftList as $s) {
            if ($carbonDate->betweenIncluded($s['start'], $s['end'])) {
                $shift = $s['name'];
                $start = $s['start'];
                break;
            }
        }

        if (!$start) {
            return ['error' => 'Waktu saat ini di luar definisi shift'];
        }

        $durasiMenit = $start->diffInMinutes($carbonDate);

        $awalCounter = DB::table('retail_d4')
            ->where('ts', '<=', $start)
            ->where('total_counter', '!=', 0)
            ->orderByDesc('ts')
            ->limit(1)
            ->value('total_counter');

        $akhirCounter = DB::table('retail_d4')
            ->where('ts', '<=', $carbonDate)
            ->where('total_counter', '!=', 0)
            ->orderByDesc('ts')
            ->limit(1)
            ->value('total_counter');

        $totalCounter = $akhirCounter;
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


    public static function getStartMesinDurasiPerShift($tanggal)
    {
        $carbonDate = Carbon::parse($tanggal, 'Asia/Jakarta');
        $dayOfWeek = $carbonDate->dayOfWeek;

        // Minggu libur
        if ($dayOfWeek === Carbon::SUNDAY) {
            return [
                'shift1' => ['menit' => 0, 'hasil' => 0],
                'shift2' => ['menit' => 0, 'hasil' => 0],
                'shift3' => ['menit' => 0, 'hasil' => 0],
            ];
        }

        // Durasi shift dalam menit
        $durasiShift = ($dayOfWeek === Carbon::SATURDAY) ? 240 : 420;

        $shifts = self::getShiftSchedule($carbonDate);
        $results = [];

        foreach ($shifts as $index => $shift) {
            $count = DB::table('retail_d4')
                ->whereBetween('ts', [
                    $shift['start']->toDateTimeString(),
                    $shift['end']->toDateTimeString()
                ])
                ->where('start_mesin', 1)
                ->count();

            $menit = $count / 60;
            $hasil = $menit / $durasiShift;

            $results["shift" . ($index + 1)] = [
                'menit' => round($menit, 2),
                'hasil' => round($hasil, 4),
            ];
        }

        return $results;
    }

    public static function getOffMesinDurasiPerShift($tanggal)
    {
        $carbonDate = Carbon::parse($tanggal, 'Asia/Jakarta');
        $dayOfWeek = $carbonDate->dayOfWeek;

        // Minggu libur
        if ($dayOfWeek === Carbon::SUNDAY) {
            return [
                'shift1' => ['menit' => 0, 'hasil' => 0],
                'shift2' => ['menit' => 0, 'hasil' => 0],
                'shift3' => ['menit' => 0, 'hasil' => 0],
            ];
        }

        // Durasi shift dalam menit
        $durasiShift = ($dayOfWeek === Carbon::SATURDAY) ? 240 : 420;

        $shifts = self::getShiftSchedule($carbonDate);
        $results = [];

        foreach ($shifts as $index => $shift) {
            $count = DB::table('retail_d4')
                ->whereBetween('ts', [
                    $shift['start']->toDateTimeString(),
                    $shift['end']->toDateTimeString()
                ])
                ->where('start_mesin', 0)
                ->count();

            $menit = $count / 60;
            $hasil = $menit / $durasiShift;

            $results["shift" . ($index + 1)] = [
                'menit' => round($menit, 2),
                'hasil' => round($hasil, 4),
            ];
        }

        return $results;
    }

    public static function getStartMesinDurasiRealtime($tanggal)
    {
        $timezone = 'Asia/Jakarta';
        $carbonDate = Carbon::parse($tanggal, $timezone);
        $shifts = self::getShiftSchedule($carbonDate);

        $results = [];

        foreach ($shifts as $shift) {
            $count = DB::table('retail_d4')
                ->whereBetween('ts', [
                    $shift['start']->toDateTimeString(),
                    $shift['end']->toDateTimeString()
                ])
                ->where('start_mesin', 1)
                ->count();

            $results[$shift['name'] . '_detik'] = $count;
        }
    }

    public static function getOffMesinDurasiRealtime($tanggal)
    {
        $timezone = 'Asia/Jakarta';
        $carbonDate = Carbon::parse($tanggal, $timezone);
        $shifts = self::getShiftSchedule($carbonDate);

        $results = [];

        foreach ($shifts as $shift) {
            $count = DB::table('retail_d4')
                ->whereBetween('ts', [
                    $shift['start']->toDateTimeString(),
                    $shift['end']->toDateTimeString()
                ])
                ->where('start_mesin', 0)
                ->count();

            $results[$shift['name'] . '_detik'] = $count;
        }

        return $results;
    }
}




