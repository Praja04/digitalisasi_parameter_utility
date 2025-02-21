<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Olahsari\OlahsariModel;
class SensorOlahsariController extends Controller
{
    public function getLatestLC1()
    {
        $latestData = OlahsariModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('id', 'desc')
            ->first();

        return response()->json(['lc1' => $latestData ? $latestData->LC_Mixer1 : 0]);
    }

    /**
     * Mengambil data terbaru untuk LC_Mixer2
     */
    public function getLatestLC2()
    {
        $latestData = OlahsariModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('id', 'desc')
            ->first();

        return response()->json(['lc2' => $latestData ? $latestData->LC_Mixer2 : 0]);
    }

    /**
     * Mengambil data terbaru untuk TempMixer1
     */
    public function getLatestTemp1()
    {
        $latestData = OlahsariModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('id', 'desc')
            ->first();

        return response()->json(['temp1' => $latestData ? $latestData->TempMixer1 : 0]);
    }

    /**
     * Mengambil data terbaru untuk TempMixer2
     */
    public function getLatestTemp2()
    {
        $latestData = OlahsariModel::whereDate('waktu', '>=', '2024-07-26')
            ->orderBy('id', 'desc')
            ->first();

        return response()->json(['temp2' => $latestData ? $latestData->TempMixer2 : 0]);
    }
}
