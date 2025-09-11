<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SeparatorDataModel extends Model
{
    protected $table = 'separator_data';

    protected $fillable = [
        'timestamp',
        'separator1',
        'separator2',
        'separator3'
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'separator1' => 'boolean',
        'separator2' => 'boolean',
        'separator3' => 'boolean'
    ];

    public $timestamps = false; // Karena kita pakai custom timestamp

    /**
     * Get current status of all separators
     */
    public static function getCurrentStatus()
    {
        return self::orderBy('timestamp', 'desc')->first();
    }

    /**
     * Get separator status for specific time range
     */
    public static function getStatusByTimeRange($hours = 24)
    {
        $startTime = Carbon::now()->subHours($hours);

        return self::where('timestamp', '>=', $startTime)
            ->orderBy('timestamp', 'asc')
            ->get();
    }

    /**
     * Get operations count for today
     */
    public static function getTodayOperations()
    {
        $today = Carbon::today();

        $query = "
            SELECT 
                SUM(CASE WHEN prev_sep1 = 0 AND separator1 = 1 THEN 1 ELSE 0 END) as sep1_opens,
                SUM(CASE WHEN prev_sep2 = 0 AND separator2 = 1 THEN 1 ELSE 0 END) as sep2_opens,
                SUM(CASE WHEN prev_sep3 = 0 AND separator3 = 1 THEN 1 ELSE 0 END) as sep3_opens
            FROM (
                SELECT *,
                    LAG(separator1) OVER (ORDER BY timestamp) as prev_sep1,
                    LAG(separator2) OVER (ORDER BY timestamp) as prev_sep2,
                    LAG(separator3) OVER (ORDER BY timestamp) as prev_sep3
                FROM separator_data
                WHERE DATE(timestamp) = ?
            ) t
        ";

        $result = DB::select($query, [$today->format('Y-m-d')]);

        return [
            'separator1' => $result[0]->sep1_opens ?? 0,
            'separator2' => $result[0]->sep2_opens ?? 0,
            'separator3' => $result[0]->sep3_opens ?? 0,
            'total' => ($result[0]->sep1_opens ?? 0) + ($result[0]->sep2_opens ?? 0) + ($result[0]->sep3_opens ?? 0)
        ];
    }

    /**
     * Get average duration for each separator
     */
    public static function getAverageDuration($days = 1)
    {
        $startDate = Carbon::now()->subDays($days);

        $query = "
            SELECT 
                AVG(CASE WHEN separator1 = 1 THEN duration ELSE NULL END) as avg_sep1,
                AVG(CASE WHEN separator2 = 1 THEN duration ELSE NULL END) as avg_sep2,
                AVG(CASE WHEN separator3 = 1 THEN duration ELSE NULL END) as avg_sep3
            FROM (
                SELECT *,
                    separator1, separator2, separator3,
                    TIMESTAMPDIFF(SECOND, 
                        LAG(timestamp) OVER (ORDER BY timestamp), 
                        timestamp
                    ) as duration
                FROM separator_data
                WHERE timestamp >= ?
            ) t
        ";

        $result = DB::select($query, [$startDate]);

        return [
            'separator1' => round($result[0]->avg_sep1 ?? 0, 2),
            'separator2' => round($result[0]->avg_sep2 ?? 0, 2),
            'separator3' => round($result[0]->avg_sep3 ?? 0, 2),
            'overall' => round((($result[0]->avg_sep1 ?? 0) + ($result[0]->avg_sep2 ?? 0) + ($result[0]->avg_sep3 ?? 0)) / 3, 2)
        ];
    }

    /**
     * Get current duration for each separator
     */
    public static function getCurrentDuration()
    {
        $query = "
            SELECT 
                separator1, separator2, separator3, timestamp,
                TIMESTAMPDIFF(SECOND, timestamp, NOW()) as seconds_ago
            FROM separator_data 
            ORDER BY timestamp DESC 
            LIMIT 1
        ";

        $current = DB::select($query)[0] ?? null;

        if (!$current) {
            return ['separator1' => 0, 'separator2' => 0, 'separator3' => 0];
        }

        // Cari kapan terakhir setiap separator berubah status
        $durations = [];

        for ($i = 1; $i <= 3; $i++) {
            $sepField = "separator{$i}";
            $currentStatus = $current->$sepField;

            $lastChangeQuery = "
                SELECT timestamp 
                FROM separator_data 
                WHERE $sepField != ? 
                ORDER BY timestamp DESC 
                LIMIT 1
            ";

            $lastChange = DB::select($lastChangeQuery, [$currentStatus]);

            if ($lastChange) {
                $durations["separator{$i}"] = Carbon::parse($lastChange[0]->timestamp)->diffInSeconds(Carbon::now());
            } else {
                $durations["separator{$i}"] = $current->seconds_ago;
            }
        }

        return $durations;
    }

    /**
     * Get activity log with status changes
     */
    public static function getActivityLog($limit = 50, $separatorFilter = null, $actionFilter = null)
    {
        $separatorConditions = [];
        $params = [];

        for ($i = 1; $i <= 3; $i++) {
            $sep = "separator{$i}";

            if ($separatorFilter && $separatorFilter != 'all' && $separatorFilter != $i) {
                continue;
            }

            $condition = "
                SELECT 
                    timestamp,
                    {$i} as separator_id,
                    'Separator {$i}' as separator_name,
                    CASE WHEN {$sep} = 1 THEN 'Open' ELSE 'Close' END as action,
                    {$sep} as status,
                    TIMESTAMPDIFF(SECOND, 
                        LAG(timestamp) OVER (ORDER BY timestamp), 
                        timestamp
                    ) as duration
                FROM separator_data
                WHERE {$sep} != LAG({$sep}) OVER (ORDER BY timestamp)
            ";

            $separatorConditions[] = $condition;
        }

        if (empty($separatorConditions)) {
            return collect();
        }

        $query = implode(' UNION ALL ', $separatorConditions);
        $query .= " ORDER BY timestamp DESC LIMIT ?";
        $params[] = $limit;

        $results = DB::select($query, $params);

        // Filter by action if specified
        if ($actionFilter && $actionFilter != 'all') {
            $results = array_filter($results, function ($item) use ($actionFilter) {
                return strtolower($item->action) === strtolower($actionFilter);
            });
        }

        return collect($results)->map(function ($item) {
            return (object)[
                'timestamp' => Carbon::parse($item->timestamp)->format('Y-m-d H:i:s'),
                'separator_id' => $item->separator_id,
                'separator_name' => $item->separator_name,
                'action' => $item->action,
                'status' => $item->status,
                'duration' => $item->duration ?? 0,
                'formatted_time' => Carbon::parse($item->timestamp)->format('H:i:s'),
                'formatted_date' => Carbon::parse($item->timestamp)->format('d M Y'),
            ];
        });
    }

    /**
     * Get last activity info
     */
    public static function getLastActivity()
    {
        $activities = self::getActivityLog(1);

        if ($activities->isEmpty()) {
            return [
                'time' => '--:--',
                'separator' => 'No activity',
                'action' => null,
                'timestamp' => null
            ];
        }

        $lastActivity = $activities->first();

        return [
            'time' => $lastActivity->formatted_time,
            'separator' => $lastActivity->separator_name,
            'action' => $lastActivity->action,
            'timestamp' => $lastActivity->timestamp
        ];
    }

    /**
     * Get summary statistics
     */
    public static function getSummaryStats()
    {
        $current = self::getCurrentStatus();
        $operations = self::getTodayOperations();
        $durations = self::getAverageDuration();
        $lastActivity = self::getLastActivity();

        $currentlyActive = 0;
        if ($current) {
            $currentlyActive = ($current->separator1 ? 1 : 0) +
                ($current->separator2 ? 1 : 0) +
                ($current->separator3 ? 1 : 0);
        }

        return [
            'currently_active' => $currentlyActive,
            'total_operations' => $operations['total'],
            'average_duration' => $durations['overall'],
            'last_activity' => $lastActivity
        ];
    }

    /**
     * Get timeline data for chart
     */
    public static function getTimelineData($hours = 24, $interval = 'minute')
    {
        $startTime = Carbon::now()->subHours($hours);

        // Adjust interval based on time range
        $groupBy = match ($interval) {
            'second' => '%Y-%m-%d %H:%i:%s',
            'minute' => '%Y-%m-%d %H:%i:00',
            'hour' => '%Y-%m-%d %H:00:00',
            default => '%Y-%m-%d %H:%i:00'
        };

        $query = "
            SELECT 
                DATE_FORMAT(timestamp, ?) as time_group,
                MAX(separator1) as separator1,
                MAX(separator2) as separator2,
                MAX(separator3) as separator3,
                MIN(timestamp) as min_timestamp
            FROM separator_data 
            WHERE timestamp >= ?
            GROUP BY time_group
            ORDER BY min_timestamp ASC
        ";

        $results = DB::select($query, [$groupBy, $startTime]);

        return collect($results)->map(function ($item) {
            return [
                'timestamp' => $item->time_group,
                'separator1' => (bool) $item->separator1,
                'separator2' => (bool) $item->separator2,
                'separator3' => (bool) $item->separator3,
                'formatted_time' => Carbon::parse($item->time_group)->format('H:i')
            ];
        });
    }

    /**
     * Insert new separator data
     */
    public static function insertData($separator1, $separator2, $separator3, $timestamp = null)
    {
        return self::create([
            'timestamp' => $timestamp ?? now(),
            'separator1' => $separator1,
            'separator2' => $separator2,
            'separator3' => $separator3
        ]);
    }
}
