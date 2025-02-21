<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Boiler\BbSteam_Boiler;
use App\Models\Boiler\ReadSensors_Boiler;
use Carbon\Carbon;

class SensorBoilerController extends Controller
{
    public function getBatubaraFk()
    {
        $tanggal = Carbon::now()->toDateString();

        $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'batubara_fk' => $data ? $data->Batubara_FK : 0
        ]);
    }

    public function getBbSteam()
    {
        $tanggal = Carbon::now()->toDateString();

        $data = BbSteam_Boiler::whereDate('waktu', '>=', $tanggal)
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'bbsteam' => $data ? $data->bb_steam : 0,
            'batubara' => $data ? $data->AvgBatubara : 0,
            'steam' => $data ? $data->AvgSteam : 0
        ]);
    }

    public function getCO2()
    {
        $tanggal = Carbon::now()->toDateString();

        $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'co2' => $data ? round($data->CO2, 2) : 0
        ]);
    }

    public function getLevelFeedWater()
    {
        $tanggal = Carbon::now()->toDateString();

        $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'level_feed_water' => $data ? $data->LevelFeedWater : 0
        ]);
    }

    public function getIDFan()
    {
        $tanggal = Carbon::now()->toDateString();

        $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'idfan' => $data ? $data->IDFan : 0
        ]);
    }

    public function getSteamFk()
    {
        $tanggal = Carbon::now()->toDateString();

        $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'steam_fk' => $data ? $data->Steam_FK : 0
        ]);
    }

    public function getRHStoker()
    {
        $tanggal = Carbon::now()->toDateString();

        $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'rhstoker' => $data ? $data->RHStoker : 0
        ]);
    }

    public function getRHGuiloutine()
    {
        $tanggal = Carbon::now()->toDateString();

        $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'rhguil' => $data ? $data->RHGuiloutine : 0
        ]);
    }

    public function getRHFDFan()
    {
        $tanggal = Carbon::now()->toDateString();

        $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'rhfd' => $data ? $data->RHFDFan : 0
        ]);
    }


    public function getRHTemp()
{
    $tanggal = Carbon::now()->toDateString();

    $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
        ->orderByDesc('id')
        ->first();

    return response()->json([
        'rh' => $data ? $data->RHTemp : 0
    ]);
}

public function getPVSteam1()
{
    $tanggal = Carbon::now()->toDateString();

    $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
        ->orderByDesc('id')
        ->first();

    return response()->json([
        'pvsteam1' => $data ? $data->PVSteam : 0
    ]);
}

public function getPVSteam()
{
    $tanggal = Carbon::now()->toDateString();

    $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
        ->orderByDesc('id')
        ->first();

    return response()->json([
        'pvsteam' => $data ? $data->PVSteam : 0
    ]);
}

public function getWaterPump2()
{
    $tanggal = Carbon::now()->toDateString();

    $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
        ->orderByDesc('id')
        ->first();

    return response()->json([
        'pump2' => $data ? $data->WaterPump2 : 0
    ]);
}

public function getWaterPump1()
{
    $tanggal = Carbon::now()->toDateString();

    $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
        ->orderByDesc('id')
        ->first();

    return response()->json([
        'pump1' => $data ? $data->WaterPump1 : 0
    ]);
}

public function getO2()
{
    $tanggal = Carbon::now()->toDateString();

    $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
        ->orderByDesc('id')
        ->first();

    return response()->json([
        'o2' => $data ? $data->O2 : 0
    ]);
}

public function getLHStoker()
{
    $tanggal = Carbon::now()->toDateString();

    $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
        ->orderByDesc('id')
        ->first();

    return response()->json([
        'lhstoker' => $data ? $data->LHStoker : 0
    ]);
}

public function getLHGuiloutine()
{
    $tanggal = Carbon::now()->toDateString();

    $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
        ->orderByDesc('id')
        ->first();

    return response()->json([
        'lhguil' => $data ? $data->LHGuiloutine : 0
    ]);
}

public function getLHFDFan()
{
    $tanggal = Carbon::now()->toDateString();

    $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
        ->orderByDesc('id')
        ->first();

    return response()->json([
        'lhfd' => $data ? $data->LHFDFan : 0
    ]);
}

public function getLHTemp()
{
    $tanggal = Carbon::now()->toDateString();

    $data = ReadSensors_Boiler::whereDate('waktu', '>=', $tanggal)
        ->orderByDesc('id')
        ->first();

    return response()->json([
        'lh' => $data ? $data->LHTemp : 0
    ]);
}


}
