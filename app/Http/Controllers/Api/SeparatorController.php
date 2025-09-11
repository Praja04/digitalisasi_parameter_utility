<?php

namespace App\Http\Controllers\Api;

use App\Models\SeparatorDataModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SeparatorController extends Controller
{
    /**
     * Display the separator dashboard
     */
    public function index()
    {
        try {
            // Get initial data for dashboard
            $currentStatus = SeparatorDataModel::getCurrentStatus();
            $summaryStats = SeparatorDataModel::getSummaryStats();

            return view('separator.dashboard', compact('currentStatus', 'summaryStats'));
        } catch (\Exception $e) {
            Log::error('Separator Dashboard Error: ' . $e->getMessage());
            return view('separator.dashboard')->with(['error' => 'Failed to load dashboard data']);
        }
    }

    /**
     * Get current status of all separators
     */
    public function getCurrentStatus(): JsonResponse
    {
        try {
            $current = SeparatorDataModel::getCurrentStatus();
            $durations = SeparatorDataModel::getCurrentDuration();
            $operations = SeparatorDataModel::getTodayOperations();

            if (!$current) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No data available'
                ], 404);
            }

            $data = [
                'separator1' => [
                    'status' => $current->separator1,
                    'status_text' => $current->separator1 ? 'OPEN' : 'CLOSED',
                    'badge_class' => $current->separator1 ? 'bg-success pulse' : 'bg-danger',
                    'badge_text' => $current->separator1 ? 'Online' : 'Closed',
                    'duration' => $durations['separator1'],
                    'duration_formatted' => $this->formatDuration($durations['separator1']),
                    'count' => $operations['separator1'],
                    'last_update' => $current->timestamp->format('H:i:s'),
                    'card_status' => $current->separator1 ? 'open' : 'closed'
                ],
                'separator2' => [
                    'status' => $current->separator2,
                    'status_text' => $current->separator2 ? 'OPEN' : 'CLOSED',
                    'badge_class' => $current->separator2 ? 'bg-success pulse' : 'bg-danger',
                    'badge_text' => $current->separator2 ? 'Online' : 'Closed',
                    'duration' => $durations['separator2'],
                    'duration_formatted' => $this->formatDuration($durations['separator2']),
                    'count' => $operations['separator2'],
                    'last_update' => $current->timestamp->format('H:i:s'),
                    'card_status' => $current->separator2 ? 'open' : 'closed'
                ],
                'separator3' => [
                    'status' => $current->separator3,
                    'status_text' => $current->separator3 ? 'OPEN' : 'CLOSED',
                    'badge_class' => $current->separator3 ? 'bg-success pulse' : 'bg-danger',
                    'badge_text' => $current->separator3 ? 'Online' : 'Closed',
                    'duration' => $durations['separator3'],
                    'duration_formatted' => $this->formatDuration($durations['separator3']),
                    'count' => $operations['separator3'],
                    'last_update' => $current->timestamp->format('H:i:s'),
                    'card_status' => $current->separator3 ? 'open' : 'closed'
                ]
            ];

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'timestamp' => $current->timestamp->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            Log::error('Get Current Status Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get current status'
            ], 500);
        }
    }

    /**
     * Get summary statistics
     */
    public function getSummaryStats(): JsonResponse
    {
        try {
            $stats = SeparatorDataModel::getSummaryStats();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'currently_active' => $stats['currently_active'],
                    'total_operations' => $stats['total_operations'],
                    'average_duration' => round($stats['average_duration'], 1),
                    'average_duration_formatted' => $this->formatDuration($stats['average_duration']),
                    'last_activity' => [
                        'time' => $stats['last_activity']['time'],
                        'separator' => $stats['last_activity']['separator'],
                        'action' => $stats['last_activity']['action']
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Get Summary Stats Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get summary statistics'
            ], 500);
        }
    }

    /**
     * Get timeline data for chart
     */
    public function getTimelineData(Request $request): JsonResponse
    {
        try {
            $hours = $request->input('hours', 24);

            // Determine interval based on time range
            $interval = match (true) {
                $hours <= 1 => 'minute',
                $hours <= 6 => 'minute',
                default => 'minute'
            };

            $data = SeparatorDataModel::getTimelineData($hours, $interval);

            // Format data for ApexCharts
            $chartData = [
                'categories' => $data->pluck('formatted_time')->toArray(),
                'series' => [
                    [
                        'name' => 'Separator 1',
                        'data' => $data->pluck('separator1')->map(fn ($val) => $val ? 1 : 0)->toArray()
                    ],
                    [
                        'name' => 'Separator 2',
                        'data' => $data->pluck('separator2')->map(fn ($val) => $val ? 1 : 0)->toArray()
                    ],
                    [
                        'name' => 'Separator 3',
                        'data' => $data->pluck('separator3')->map(fn ($val) => $val ? 1 : 0)->toArray()
                    ]
                ]
            ];

            return response()->json([
                'status' => 'success',
                'data' => $chartData,
                'period' => $hours . ' hours',
                'interval' => $interval,
                'total_points' => $data->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Get Timeline Data Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get timeline data'
            ], 500);
        }
    }

    /**
     * Get activity log
     */
    public function getActivityLog(Request $request): JsonResponse
    {
        try {
            $limit = $request->input('limit', 50);
            $separatorFilter = $request->input('separator', 'all');
            $actionFilter = $request->input('action', 'all');

            $activities = SeparatorDataModel::getActivityLog($limit, $separatorFilter, $actionFilter);

            $formattedActivities = $activities->map(function ($activity) {
                return [
                    'timestamp' => $activity->formatted_time,
                    'full_timestamp' => $activity->timestamp,
                    'date' => $activity->formatted_date,
                    'separator' => $activity->separator_name,
                    'separator_id' => $activity->separator_id,
                    'action' => $activity->action,
                    'action_badge' => $activity->action === 'Open' ? 'bg-success' : 'bg-danger',
                    'duration' => $activity->duration,
                    'duration_formatted' => $this->formatDuration($activity->duration),
                    'status_icon' => 'ri-checkbox-circle-line text-success'
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $formattedActivities,
                'total' => $activities->count(),
                'filters' => [
                    'separator' => $separatorFilter,
                    'action' => $actionFilter,
                    'limit' => $limit
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Get Activity Log Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get activity log'
            ], 500);
        }
    }

    /**
     * Export activity log to CSV
     */
    public function exportActivityLog(Request $request)
    {
        try {
            $separatorFilter = $request->input('separator', 'all');
            $actionFilter = $request->input('action', 'all');
            $limit = $request->input('limit', 1000); // Larger limit for export

            $activities = SeparatorDataModel::getActivityLog($limit, $separatorFilter, $actionFilter);

            $filename = 'separator_activity_log_' . date('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ];

            return response()->stream(function () use ($activities) {
                $file = fopen('php://output', 'w');

                // CSV Headers
                fputcsv($file, ['Timestamp', 'Date', 'Separator', 'Action', 'Duration (seconds)', 'Duration (formatted)']);

                // CSV Data
                foreach ($activities as $activity) {
                    fputcsv($file, [
                        $activity->timestamp,
                        $activity->formatted_date,
                        $activity->separator_name,
                        $activity->action,
                        $activity->duration,
                        $this->formatDuration($activity->duration)
                    ]);
                }

                fclose($file);
            }, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Export Activity Log Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to export activity log'
            ], 500);
        }
    }

    /**
     * Store new separator data (for testing or external input)
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'separator1' => 'required|boolean',
                'separator2' => 'required|boolean',
                'separator3' => 'required|boolean',
                'timestamp' => 'nullable|date'
            ]);

            $data = SeparatorDataModel::insertData(
                $request->separator1,
                $request->separator2,
                $request->separator3,
                $request->timestamp ? Carbon::parse($request->timestamp) : null
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Separator data stored successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Store Separator Data Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store separator data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get dashboard refresh data (all data in one call)
     */
    public function getDashboardData(Request $request): JsonResponse
    {
        try {
            $currentStatus = $this->getCurrentStatus();
            $summaryStats = $this->getSummaryStats();
            $activityLog = $this->getActivityLog($request);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'current_status' => $currentStatus->getData(),
                    'summary_stats' => $summaryStats->getData(),
                    'recent_activities' => $activityLog->getData()
                ],
                'timestamp' => now()->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            Log::error('Get Dashboard Data Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get dashboard data'
            ], 500);
        }
    }

    /**
     * Helper function to format duration in seconds to readable format
     */
    private function formatDuration($seconds): string
    {
        if ($seconds < 60) {
            return $seconds . 's';
        } elseif ($seconds < 3600) {
            $minutes = floor($seconds / 60);
            $remainingSeconds = $seconds % 60;
            return $minutes . 'm ' . $remainingSeconds . 's';
        } else {
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds % 3600) / 60);
            return $hours . 'h ' . $minutes . 'm';
        }
    }

    /**
     * Health check endpoint
     */
    public function healthCheck(): JsonResponse
    {
        try {
            $latestData = SeparatorDataModel::orderBy('timestamp', 'desc')->first();
            $totalRecords = SeparatorDataModel::count();

            $status = $latestData ? 'healthy' : 'no_data';
            $lastDataAge = $latestData ? Carbon::parse($latestData->timestamp)->diffInSeconds(now()) : null;

            return response()->json([
                'status' => 'success',
                'system_status' => $status,
                'total_records' => $totalRecords,
                'last_data_timestamp' => $latestData?->timestamp,
                'last_data_age_seconds' => $lastDataAge,
                'server_time' => now()->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            Log::error('Health Check Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'System health check failed'
            ], 500);
        }
    }
}
