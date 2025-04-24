<?php

namespace App\Models\Boiler;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReadSensors_Boiler extends Model
{
    use HasFactory;

    protected $table = 'readsensors_boiler';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'waktu',
        'LevelFeedWater',
        'PVSteam',
        'FeedPressure',
        'LHGuiloutine',
        'RHGuiloutine',
        'LHTemp',
        'RHTemp',
        'IDFan',
        'LHFDFan',
        'RHFDFan',
        'LHStoker',
        'RHStoker',
        'WaterPump1',
        'WaterPump2',
        'InletWaterFlow',
        'OutletSteamFlow',
        'SuhuFeedTank',
        'O2',
        'CO2',
        'Batubara_FK',
        'Steam_FK'
    ];


    public static function getLatestData($limit = 10)
    {
        return self::orderBy('waktu', 'desc')->limit($limit)->get();
    }

    public static function getAbnormalRHTempPeriods($filterType = 'today', $startDate = null, $endDate = null)
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
                waktu,
                RHtemp,
                CASE 
                    WHEN RHtemp < 80 OR RHtemp > 200 THEN 1 ELSE 0 
                END AS is_abnormal
            FROM readsensors_boiler
            {$whereClause}
        ),
        with_groups AS (
            SELECT *,
                ROW_NUMBER() OVER (ORDER BY waktu) 
              - ROW_NUMBER() OVER (PARTITION BY is_abnormal ORDER BY waktu) 
              AS group_id
            FROM status_flagged
        )
        SELECT 
            MIN(waktu) AS waktu_mulai,
            MAX(waktu) AS waktu_akhir
        FROM with_groups
        WHERE is_abnormal = 1
        GROUP BY group_id
        ORDER BY waktu_mulai
    ";

        return DB::select($query);
    }


    public static function getAbnormalLHTempPeriods($filterType = 'today', $startDate = null, $endDate = null)
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
                waktu,
                LHtemp,
                CASE 
                    WHEN LHtemp < 80 OR LHtemp > 200 THEN 1 ELSE 0 
                END AS is_abnormal
            FROM readsensors_boiler
            {$whereClause}
        ),
        with_groups AS (
            SELECT *,
                ROW_NUMBER() OVER (ORDER BY waktu) 
              - ROW_NUMBER() OVER (PARTITION BY is_abnormal ORDER BY waktu) 
              AS group_id
            FROM status_flagged
        )
        SELECT 
            MIN(waktu) AS waktu_mulai,
            MAX(waktu) AS waktu_akhir
        FROM with_groups
        WHERE is_abnormal = 1
        GROUP BY group_id
        ORDER BY waktu_mulai
    ";

        return DB::select($query);
    }

    public static function getAbnormalPVSteamPeriods($filterType = 'today', $startDate = null, $endDate = null)
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
                waktu,
                PVSteam,
                CASE 
                    WHEN PVSteam > 6 THEN 1 ELSE 0 
                END AS is_abnormal
            FROM readsensors_boiler
            {$whereClause}
        ),
        with_groups AS (
            SELECT *,
                ROW_NUMBER() OVER (ORDER BY waktu) 
              - ROW_NUMBER() OVER (PARTITION BY is_abnormal ORDER BY waktu) 
              AS group_id
            FROM status_flagged
        )
        SELECT 
            MIN(waktu) AS waktu_mulai,
            MAX(waktu) AS waktu_akhir
        FROM with_groups
        WHERE is_abnormal = 1
        GROUP BY group_id
        ORDER BY waktu_mulai
     ";

        return DB::select($query);
    }

    public static function getAbnormalLevelFeedWaterPeriods($filterType = 'today', $startDate = null, $endDate = null)
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
                waktu,
                LevelFeedWater,
                CASE 
                    WHEN LevelFeedWater > 60 THEN 1 ELSE 0 
                END AS is_abnormal
            FROM readsensors_boiler
            {$whereClause}
        ),
        with_groups AS (
            SELECT *,
                ROW_NUMBER() OVER (ORDER BY waktu) 
              - ROW_NUMBER() OVER (PARTITION BY is_abnormal ORDER BY waktu) 
              AS group_id
            FROM status_flagged
        )
        SELECT 
            MIN(waktu) AS waktu_mulai,
            MAX(waktu) AS waktu_akhir
        FROM with_groups
        WHERE is_abnormal = 1
        GROUP BY group_id
        ORDER BY waktu_mulai
     ";

        return DB::select($query);
    }
}
