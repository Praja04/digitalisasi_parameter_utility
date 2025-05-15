<?php

namespace App\Models\Retail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class retail_d5_nozzle1 extends Model
{
    //
    use HasFactory;

    protected $table = 'retail_d5_nozzle1';
    protected $primaryKey = 'id';
    public $timestamps = false; // Karena sudah ada kolom `ts` yang otomatis

    protected $fillable = [
        'nozzle_1', 'ts'
    ];

    public static function getNozzleCountPerShift($dates)
    {
        $result = [
            'shift_1' => ['nozzle_1' => 0],
            'shift_2' => ['nozzle_1' => 0],
            'shift_3' => ['nozzle_1' => 0],
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
           
            $result['shift_2']['nozzle_1'] += self::whereBetween('ts', [$start2, $end2])->sum('nozzle_1');
           
            $result['shift_3']['nozzle_1'] += self::whereBetween('ts', [$start3, $end3])->sum('nozzle_1');
            }

        return $result;
    }
}
