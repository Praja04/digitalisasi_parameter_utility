<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyTank\DailyTankModel;
class SensorDailyTankController extends Controller
{
    public function getLatestRO()
    {
        $latestData = DailyTankModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('ID', 'desc')
            ->first();

        return response()->json(['RO' => $latestData ? $latestData->DT_RO : 0]);
    }

    /**
     * Mengambil data terbaru untuk DT_Salt
     */
    public function getLatestSalt()
    {
        $latestData = DailyTankModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('ID', 'desc')
            ->first();

        return response()->json(['salt' => $latestData ? $latestData->DT_Salt : 0]);
    }

    /**
     * Mengambil data terbaru untuk DT_SoySauceA
     */
    public function getLatestSoySauceA()
    {
        $latestData = DailyTankModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('ID', 'desc')
            ->first();

        return response()->json(['sauceA' => $latestData ? $latestData->DT_SoySauceA : 0]);
    }

    /**
     * Mengambil data terbaru untuk DT_SoySauceB
     */
    public function getLatestSoySauceB()
    {
        $latestData = DailyTankModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('ID', 'desc')
            ->first();

        return response()->json(['sauceB' => $latestData ? $latestData->DT_SoySauceB : 0]);
    }

    /**
     * Mengambil data terbaru untuk DT_SoySauceC
     */
    public function getLatestSoySauceC()
    {
        $latestData = DailyTankModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('ID', 'desc')
            ->first();

        return response()->json(['sauceC' => $latestData ? $latestData->DT_SoySauceC : 0]);
    }
}
