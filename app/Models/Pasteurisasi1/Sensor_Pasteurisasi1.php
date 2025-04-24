<?php

namespace App\Models\Pasteurisasi1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Sensor_Pasteurisasi1 extends Model
{
    //
    use HasFactory;

    protected $table = 'readsensors_pasteurisasi1';
    protected $primaryKey = 'id';
    public $timestamps = false; // Karena sudah ada `waktu` otomatis

    protected $fillable = [
        'Waktu',
        'SpeedPompaMixing',
        'PressureMixing',
        'SuhuPreheating',
        'LevelBT1',
        'SpeedPumpBT1',
        'LevelVD',
        'SpeedPumpVD',
        'Flowrate',
        'SuhuHeating',
        'SuhuHolding',
        'SuhuPrecooling',
        'LevelBT2',
        'SpeedPumpBT2',
        'PressureBT2',
        'SuhuCooling',
        'PressToPasteur',
        'PressVDHH',
        'PressVDLL',
        'MixingAM',
        'BT1AM',
        'VDAM',
        'PCV1',
        'TimeDivert',
        'Mode',
        'Varian',
        'Batch',
        'Storage',
    ];

    public static function getLatestData($limit = 10)
    {
        return self::orderBy('Waktu', 'desc')->limit($limit)->get();
    }

    public static function getAbnormalSuhuHeatingPeriods($filterType = 'today', $startDate = null, $endDate = null)
    {
        // Filter SQL tambahan
        $whereClause = "";

        if ($filterType === 'today') {
            $whereClause = "WHERE DATE(waktu) = CURDATE()";
        } elseif ($filterType === 'date' && $startDate) {
            $whereClause = "WHERE DATE(waktu) = '{$startDate}'";
        } elseif ($filterType === 'range' && $startDate && $endDate) {
            $whereClause = "WHERE DATE(waktu) BETWEEN '{$startDate}' AND '{$endDate}'";
        }

        $query = "
        WITH status_flagged AS (
            SELECT 
                Waktu,
                SuhuHeating,
                CASE 
                    WHEN SuhuHeating < 120  THEN 1 ELSE 0
                END AS is_abnormal
            FROM readsensors_pasteurisasi1
            {$whereClause}
        ),
        with_groups AS (
            SELECT *,
                ROW_NUMBER() OVER (ORDER BY Waktu) 
              - ROW_NUMBER() OVER (PARTITION BY is_abnormal ORDER BY Waktu) 
              AS group_id
            FROM status_flagged
        )
        SELECT 
            MIN(Waktu) AS Waktu_mulai,
            MAX(Waktu) AS Waktu_akhir
        FROM with_groups
        WHERE is_abnormal = 1
        GROUP BY group_id
        ORDER BY Waktu_mulai
    ";

        return DB::select($query);
    }


    public static function getAbnormalSuhuHoldingPeriods($filterType = 'today', $startDate = null, $endDate = null)
    {
        // Filter SQL tambahan
        $whereClause = "";

        if ($filterType === 'today') {
            $whereClause = "WHERE DATE(waktu) = CURDATE()";
        } elseif ($filterType === 'date' && $startDate) {
            $whereClause = "WHERE DATE(waktu) = '{$startDate}'";
        } elseif ($filterType === 'range' && $startDate && $endDate) {
            $whereClause = "WHERE DATE(waktu) BETWEEN '{$startDate}' AND '{$endDate}'";
        }

        $query = "
        WITH status_flagged AS (
            SELECT 
                Waktu,
                SuhuHolding,
                CASE 
                    WHEN SuhuHolding < 114  THEN 1 ELSE 0
                END AS is_abnormal
            FROM readsensors_pasteurisasi1
            {$whereClause}
        ),
        with_groups AS (
            SELECT *,
                ROW_NUMBER() OVER (ORDER BY Waktu) 
              - ROW_NUMBER() OVER (PARTITION BY is_abnormal ORDER BY Waktu) 
              AS group_id
            FROM status_flagged
        )
        SELECT 
            MIN(Waktu) AS Waktu_mulai,
            MAX(Waktu) AS Waktu_akhir
        FROM with_groups
        WHERE is_abnormal = 1
        GROUP BY group_id
        ORDER BY Waktu_mulai
    ";

        return DB::select($query);
    }


    public static function getAbnormalFlowratePeriods($filterType = 'today', $startDate = null, $endDate = null)
    {
        // Filter SQL tambahan
        $whereClause = "";

        if ($filterType === 'today') {
            $whereClause = "WHERE DATE(waktu) = CURDATE()";
        } elseif ($filterType === 'date' && $startDate) {
            $whereClause = "WHERE DATE(waktu) = '{$startDate}'";
        } elseif ($filterType === 'range' && $startDate && $endDate) {
            $whereClause = "WHERE DATE(waktu) BETWEEN '{$startDate}' AND '{$endDate}'";
        }

        $query = "
        WITH status_flagged AS (
            SELECT 
                Waktu,
                Flowrate,
                CASE 
                    WHEN Flowrate < 114  THEN 1 ELSE 0
                END AS is_abnormal
            FROM readsensors_pasteurisasi1
            {$whereClause}
        ),
        with_groups AS (
            SELECT *,
                ROW_NUMBER() OVER (ORDER BY Waktu) 
              - ROW_NUMBER() OVER (PARTITION BY is_abnormal ORDER BY Waktu) 
              AS group_id
            FROM status_flagged
        )
        SELECT 
            MIN(Waktu) AS Waktu_mulai,
            MAX(Waktu) AS Waktu_akhir
        FROM with_groups
        WHERE is_abnormal = 1
        GROUP BY group_id
        ORDER BY Waktu_mulai
    ";

        return DB::select($query);
    }
}
