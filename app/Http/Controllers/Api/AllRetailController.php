<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\produksi\VariantTarget;
use App\Models\produksi\VariantShift;


class AllRetailController extends Controller
{
    //
    // public function data_retail_all_varian(Request $request)
    // {
    //     $tanggal = $request->input('tanggal', now()->toDateString()); // default hari ini

    //     $variants = ['a', 'b', 'c', 'd'];
    //     $result = [];

    //     foreach ($variants as $variant) {
    //         $target = VariantTarget::where('variant_name', $variant)
    //             ->where('tanggal', $tanggal)
    //             ->first();

    //         $shifts = VariantShift::where('variant_name', $variant)
    //             ->where('tanggal', $tanggal)
    //             ->get()
    //             ->groupBy('shift_number')
    //             ->map(fn ($group) => $group->sum('total'));

    //         $result[] = [
    //             'variant' => $variant,
    //             'tanggal' => $tanggal,
    //             'target' => $target?->target ?? 0,
    //             'shift_1' => $shifts->get(1, 0),
    //             'shift_2' => $shifts->get(2, 0),
    //             'shift_3' => $shifts->get(3, 0),
    //         ];
    //     }

    //     return response()->json($result);
    // }
    public function data_retail_all_varian(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $range = $request->input('range');

        // Hitung rentang waktu berdasarkan input
        if ($range) {
            $endDate = now()->toDateString();

            if ($range === 'ALL') {
                $startDate = '2000-01-01'; // Atau sesuaikan dengan tanggal data terawal kamu
                $endDate = now()->toDateString();
            } else {
                $startDate = match ($range) {
                    '1M' => now()->startOfMonth()->toDateString(),
                    '6M' => now()->subMonths(5)->startOfMonth()->toDateString(),
                    '1Y' => now()->subMonths(11)->startOfMonth()->toDateString(),
                    default => now()->toDateString()
                };
            }
        } elseif ($tanggal) {
            $startDate = $endDate = $tanggal;
        } else {
            $startDate = $endDate = now()->toDateString(); // default: hari ini
        }

        $variants = [
            'YB20gr',
            'YB77gr',
            'BB77BBG1',
            'BB77Harga',
            '250gr',
            'BB725',
            '40gr',
            '700gr',
        ];        
        $result = [];

        foreach ($variants as $variant) {
            // Ambil target total dari rentang tanggal
            $totalTarget = VariantTarget::where('variant_name', $variant)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->sum('target');

            // Ambil total shift per shift number dalam rentang tanggal
            $shifts = VariantShift::where('variant_name', $variant)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->get()
                ->groupBy('shift_number')
                ->map(fn ($group) => $group->sum('total'));

            $result[] = [
                'variant' => $variant,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'target' => $totalTarget,
                'shift_1' => $shifts->get(1, 0),
                'shift_2' => $shifts->get(2, 0),
                'shift_3' => $shifts->get(3, 0),
            ];
        }

        return response()->json($result);
    }
}
