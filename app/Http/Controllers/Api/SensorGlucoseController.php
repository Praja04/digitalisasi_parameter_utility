<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Glucose\GlucoseModel;
class SensorGlucoseController extends Controller
{
    public function getLatestGST1()
    {
        $latestData = GlucoseModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('id', 'desc')
            ->first();

        return response()->json(['gst1' => $latestData ? $latestData->GST1 : 0]);
    }

    /**
     * Mengambil data terbaru untuk GST2
     */
    public function getLatestGST2()
    {
        $latestData = GlucoseModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('id', 'desc')
            ->first();

        return response()->json(['gst2' => $latestData ? $latestData->GST2 : 0]);
    }

    /**
     * Mengambil data terbaru untuk GST3
     */
    public function getLatestGST3()
    {
        $latestData = GlucoseModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('id', 'desc')
            ->first();

        return response()->json(['gst3' => $latestData ? $latestData->GST3 : 0]);
    }

    /**
     * Mengambil data terbaru untuk GST4
     */
    public function getLatestGST4()
    {
        $latestData = GlucoseModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('id', 'desc')
            ->first();

        return response()->json(['gst4' => $latestData ? $latestData->GST4 : 0]);
    }

    /**
     * Mengambil data terbaru untuk GST5
     */
    public function getLatestGST5()
    {
        $latestData = GlucoseModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('id', 'desc')
            ->first();

        return response()->json(['gst5' => $latestData ? $latestData->GST5 : 0]);
    }
}
