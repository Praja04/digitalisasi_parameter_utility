<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Boiler\BbSteam_Boiler;
use App\Models\Boiler\ReadSensors_Boiler;
use App\Models\Boiler\Sensors_Boiler;
use Carbon\Carbon;

class SensorBoilerController extends Controller
{
    public function getSensorData()
    {
        // Ambil data terbaru dari masing-masing tabel berdasarkan waktu terbaru
        $dataReadSensors = ReadSensors_Boiler::orderByDesc('waktu')->first();
        $dataSensors = Sensors_Boiler::orderByDesc('waktu')->first();

        // Jika tidak ada data, set nilai default ke 0
        $readSensorsArray = $dataReadSensors ? $dataReadSensors->toArray() : [
            "id" => 0,
            "waktu" => now()->toDateTimeString(),
            "LevelFeedWater" => 0,
            "PVSteam" => 0,
            "FeedPressure" => 0,
            "LHGuiloutine" => 0,
            "RHGuiloutine" => 0,
            "LHTemp" => 0,
            "RHTemp" => 0,
            "IDFan" => 0,
            "LHFDFan" => 0,
            "RHFDFan" => 0,
            "LHStoker" => 0,
            "RHStoker" => 0,
            "WaterPump1" => 0,
            "WaterPump2" => 0,
            "InletWaterFlow" => 0,
            "OutletSteamFlow" => 0,
            "SuhuFeedTank" => 0,
            "O2" => 0,
            "CO2" => 0,
            "Batubara_FK" => 0,
            "Steam_FK" => 0
        ];

        $sensorsArray = $dataSensors ? $dataSensors->toArray() : [
            "Batubara" => 0,
            "Steam" => 0
        ];

        // Gabungkan kedua array
        $response = array_merge($readSensorsArray, $sensorsArray);

        return response()->json($response);
    }

    public function getSensorDataa()
    {
        //$tanggal = Carbon::now()->toDateString();

        // Ambil data terbaru dari masing-masing tabel berdasarkan tanggal
        $dataReadSensors = ReadSensors_Boiler::orderByDesc('waktu')->first();
        $dataSensors = Sensors_Boiler::orderByDesc('waktu')->first();


        // Mapping kolom untuk ReadSensors_Boiler
        $readSensorsMap = [
            'batubara_fk' => 'Batubara_FK',
            'bbsteam' => 'Steam_FK',
            'co2' => 'CO2',
            'level_feed_water' => 'LevelFeedWater',
            'idfan' => 'IDFan',
            'steam_fk' => 'Steam_FK',
            'rhstoker' => 'RHStoker',
            'rhguil' => 'RHGuiloutine',
            'rhfd' => 'RHFDFan',
            'rh' => 'RHTemp',
            'pvsteam1' => 'PVSteam',
            'pvsteam' => 'PVSteam',
            'pump2' => 'WaterPump2',
            'pump1' => 'WaterPump1',
            'o2' => 'O2',
            'lhstoker' => 'LHStoker',
            'lhguil' => 'LHGuiloutine',
            'lhfd' => 'LHFDFan',
            'lh' => 'LHTemp'
        ];

        // Mapping kolom untuk Sensors_Boiler
        $sensorsMap = [
            'batubara' => 'Batubara',
            'steam' => 'Steam'
        ];

        $response = [];

        // Ambil data dari ReadSensors_Boiler
        foreach ($readSensorsMap as $key => $column) {
            $response[$key] = $dataReadSensors;
        }

        // Ambil data dari Sensors_Boiler
        foreach ($sensorsMap as $key => $column) {
            $response[$key] = $dataSensors;
        }

        return response()->json($response);
    }



    //data trend start

    public function getBoilerData()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data sensor boiler berhasil diambil',
            'data' => ReadSensors_Boiler::getLatestData(20)
        ]);
    }
    //data trend end


    //filter data trend start
    public function getFilteredBoilerData(Request $request)
    {
        $query = ReadSensors_Boiler::query();

        // Cek apakah filter harian digunakan
        if ($request->has('tanggal')) {
            $tanggal = $request->input('tanggal');
            $query->whereDate('waktu', $tanggal);
        }

        // Cek apakah filter mingguan digunakan
        if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
            $tanggalMulai = $request->input('tanggal_mulai');
            $tanggalSelesai = $request->input('tanggal_selesai');

            $query->whereBetween('waktu', [$tanggalMulai, $tanggalSelesai]);
        }

        // Ambil data yang sudah difilter
        $data = $query->orderBy('waktu', 'asc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data boiler berhasil diambil',
            'data' => $data
        ]);
    }

    public function getBoilerDataHarian(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $data = ReadSensors_Boiler::whereDate('waktu', $tanggal)
            ->orderBy('waktu', 'asc')
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data untuk tanggal ini tidak ditemukan',
                'data' => []
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data harian berhasil diambil',
            'data' => $data
        ]);
    }

    public function getBoilerDataMingguan(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $data = ReadSensors_Boiler::whereBetween('waktu', [$tanggalMulai, $tanggalSelesai])
            ->orderBy('waktu', 'asc')
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data untuk rentang tanggal ini tidak ditemukan',
                'data' => []
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data mingguan berhasil diambil',
            'data' => $data
        ]);
    }
    //filter data trend end

}
