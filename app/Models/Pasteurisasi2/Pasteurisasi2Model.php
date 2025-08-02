<?php

namespace App\Models\Pasteurisasi2;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Pasteurisasi2Model extends Model
{
    use HasFactory;

    protected $table = 'readsensors_pasteurisasi2'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary Key

    public $timestamps = false; // Karena kita sudah mengatur timestamp manual

    protected $fillable = [
        'waktu',
        'SpeedPompaMixing',
        'PressureMixing',
        'SuhuPreheating',
        'LevelBT1',
        'SpeedPumpBT1',
        'LevelVD',
        'SpeedPumpVD',
        'FlowrateAM',
        'Flowrate',
        'SuhuHeating',
        'SuhuHolding',
        'SuhuPrecooling',
        'LevelBT2',
        'SpeedPumpBT2',
        'PressureBT2',
        'SuhuCooling',
        'MV1',
        'MV2'
    ];

    /**
     * Ambil data terbaru dengan limit tertentu
     */
    public static function getLatestData($limit = 10)
    {
        return self::orderBy('waktu', 'desc')->limit($limit)->get();
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
                waktu,
                SuhuHeating,
                CASE 
                    WHEN SuhuHeating < 120  THEN 1 ELSE 0
                END AS is_abnormal
            FROM readsensors_pasteurisasi2
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
            MIN(waktu) AS Waktu_mulai,
            MAX(waktu) AS Waktu_akhir
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
                waktu,
                SuhuHolding,
                CASE 
                    WHEN SuhuHolding < 114  THEN 1 ELSE 0
                END AS is_abnormal
            FROM readsensors_pasteurisasi2
            {$whereClause}
        ),
        with_groups AS (
            SELECT *,
                ROW_NUMBER() OVER (ORDER BY Waktu) 
              - ROW_NUMBER() OVER (PARTITION BY is_abnormal ORDER BY waktu) 
              AS group_id
            FROM status_flagged
        )
        SELECT 
            MIN(waktu) AS Waktu_mulai,
            MAX(waktu) AS Waktu_akhir
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
                waktu,
                Flowrate,
                CASE 
                    WHEN Flowrate < 114  THEN 1 ELSE 0
                END AS is_abnormal
            FROM readsensors_pasteurisasi2
            {$whereClause}
        ),
        with_groups AS (
            SELECT *,
                ROW_NUMBER() OVER (ORDER BY Waktu) 
              - ROW_NUMBER() OVER (PARTITION BY is_abnormal ORDER BY waktu) 
              AS group_id
            FROM status_flagged
        )
        SELECT 
            MIN(waktu) AS Waktu_mulai,
            MAX(waktu) AS Waktu_akhir
        FROM with_groups
        WHERE is_abnormal = 1
        GROUP BY group_id
        ORDER BY Waktu_mulai
    ";

        return DB::select($query);
    }
}
