<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PemakaianAirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $jenisPemakaianList = [
            "CT RO",
            "CT WS",
            "Green Belt",
            "Outlet Fresh Water 1",
            "Outlet Fresh Water 2",
            "Outlet Storage RO Reject",
            "Outlet Storage WS",
            "PDAM",
            "Sumur 1",
            "Sumur 2",
            "Sumur 3"
        ];

        $startDate = Carbon::today()->subMonths(3)->startOfMonth(); // Tiga bulan lalu awal bulan
        $endDate = Carbon::today()->subDay(); // Hingga kemarin
        $data = [];

        // Nilai dasar awal
        $baseAwal = 100;

        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dayOffset = $date->diffInDays($startDate);

            foreach ($jenisPemakaianList as $index => $jenis) {
                // Pemakaian dibuat bertumbuh konsisten per minggu
                $growthFactor = floor($dayOffset / 7); // Mingguan
                $awal = $baseAwal + ($index * 5) + ($growthFactor * 2);
                $akhir = $awal + 15;

                $data[] = [
                    'tanggal'           => $date->format('Y-m-d'),
                    'pemakaian_awal'    => $awal,
                    'pemakaian_akhir'   => $akhir,
                    'jenis_pemakaian'   => $jenis,
                    'notes'             => null,
                    'created_by'        => 'seeder',
                    'created_at'        => now(),
                    'updated_at'        => now()
                ];
            }
        }

        DB::table('pemakaian_air_eng')->insert($data);


    }
}
