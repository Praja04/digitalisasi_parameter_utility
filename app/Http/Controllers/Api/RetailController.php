<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Retail\retail_d4;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RetailController extends Controller
{
    // buatkan fungsi ambil 1 data terakhir dari tabel retail_d4
    public function getLastData()
    {
        // Ambil data terakhir dari tabel retail_d4
        $data = retail_d4::orderBy('waktu', 'desc')->first();

        // Jika tidak ada data, set nilai default ke 0
        if (!$data) {
            $data = [
                "id" => 0,
                "waktu" => now()->toDateTimeString(),
                "main_speed" => 0,
                "total_counter" => 0,
                "nozzle_1" => 0,
                "nozzle_2" => 0,
                "Start_Mesin" => 0
            ];
        }

        return response()->json($data);
    }

    //ambil data dari tabel retail_d4 berdasarkan waktu sebanyak 100 data
    public function getData()
    {
        // Ambil data dari tabel retail_d4 berdasarkan waktu sebanyak 100 data
        $data = retail_d4::orderBy('waktu', 'desc')->take(100)->get();

        // Jika tidak ada data, set nilai default ke 0
        if ($data->isEmpty()) {
            $data = [
                "id" => 0,
                "waktu" => now()->toDateTimeString(),
                "main_speed" => 0,
                "total_counter" => 0,
                "nozzle_1" => 0,
                "nozzle_2" => 0,
                "Start_Mesin" => 0
            ];
        }

        return response()->json($data);
    }
    // buatkan fungsi menghitung rata-rata dari main_speed saja berdasarkan waktu, dengan 3 filter yaitu realtime hari ini, lalu pilih tanggal, dan range tanggal
    public function getAverageMainSpeed(Request $request)
    {
        // Validasi input
        $request->validate([
            'filter' => 'required|in:realtime,tanggal,range',
            'tanggal' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $query = retail_d4::query();

        // Filter berdasarkan waktu
        if ($request->filter == 'realtime') {
            $query->whereDate('waktu', now());
        } elseif ($request->filter == 'tanggal') {
            $query->whereDate('waktu', $request->tanggal);
        } elseif ($request->filter == 'range') {
            $query->whereBetween('waktu', [$request->start_date, $request->end_date]);
        }

        // Hitung rata-rata main_speed
        $average = $query->avg('main_speed');

        return response()->json(['average_main_speed' => $average]);
    }
    // buatkan fungsi menghitung jumlah keseluruhan dari total_counter saja berdasarkan waktu, dengan 3 filter yaitu realtime hari ini, lalu pilih tanggal, dan range tanggal. dan juga dibagi menjadi 3 shift, shift 1 dari 06.00 sampai 14.00, shift 2 dari 14.01 sampai 22.00,dan shift 3 dari 22.01 sampai 05.59 tanggal berikutnya
    public function getTotalCounter(Request $request)
    {
        $request->validate([
            'filter' => 'required|in:realtime,tanggal,range',
            'tanggal' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $data = retail_d4::getTotalCounterWithShifts(
            $request->filter,
            $request->tanggal,
            $request->start_date,
            $request->end_date
        );

        return response()->json($data);
    }

    public function getNozzleCount(Request $request)
    {
        $request->validate([
            'filter' => 'required|in:realtime,tanggal,range',
            'tanggal' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $dates = [];

        if ($request->filter === 'realtime') {
            $dates[] = Carbon::today()->toDateString();
        } elseif ($request->filter === 'tanggal') {
            $dates[] = Carbon::parse($request->tanggal)->toDateString();
        } elseif ($request->filter === 'range') {
            $start = Carbon::parse($request->start_date);
            $end = Carbon::parse($request->end_date);
            for ($date = $start;
                $date->lte($end);
                $date->addDay()
            ) {
                $dates[] = $date->toDateString();
            }
        }

        $shiftCounts = retail_d4::getNozzleCountPerShift($dates);

        return response()->json([
            'total_nozzle_1' => $shiftCounts['shift_1']['nozzle_1'] + $shiftCounts['shift_2']['nozzle_1'] + $shiftCounts['shift_3']['nozzle_1'],
            'total_nozzle_2' => $shiftCounts['shift_1']['nozzle_2'] + $shiftCounts['shift_2']['nozzle_2'] + $shiftCounts['shift_3']['nozzle_2'],
            'shift_1' => $shiftCounts['shift_1'],
            'shift_2' => $shiftCounts['shift_2'],
            'shift_3' => $shiftCounts['shift_3'],
        ]);
    }

    public function getMesinStartPeriods(Request $request)
    {
        $filter = $request->input('filter'); // 'today', 'date', 'range'
        $start = $request->input('start');
        $end = $request->input('end');

        $periods = retail_d4::getMesinStartPeriods($filter, $start, $end);

        $data = array_map(function ($item) {
            return [
                'waktu_mulai' => $item->Waktu_mulai,
                'waktu_akhir' => $item->Waktu_akhir,
            ];
        }, $periods);

        return response()->json([
            'total' => count($data),
            'data' => $data
        ]);
    }
}
