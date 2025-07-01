<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PemakaianListrikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $panels = [
            'MDP',
            'SDP1', 'SDP2', 'SDP3', 'SDP4', 'SDP5', 'SDP6', 'SDP7',
            'SDP8', 'SDP9', 'SDP10', 'SDP11', 'SDP12', 'SDP13', 'SDP14'
        ];

        $startDate = Carbon::today()->subDays(29); // 30 hari terakhir
        $now = now();
        $data = [];

        foreach ($panels as $panel) {
            $baseMwh = rand(100, 500); // nilai awal acak

            for ($i = 0; $i < 30; $i++) {
                $tanggal = $startDate->copy()->addDays($i);
                $delta = $i * rand(1, 5) / 10; // kenaikan bertahap
                $mwh = round($baseMwh + $delta, 3);

                $data[] = [
                    'waktu'      => $tanggal->format('Y-m-d') . ' 08:00:00',
                    'operator'   => 'SeederBot',
                    'panel_type' => $panel,
                    'volt'       => rand(380, 420),
                    'a'          => rand(100, 300),
                    'kw'         => rand(200, 500),
                    'mwh'        => $mwh,
                    'cos'        => round(rand(90, 100) / 100, 2),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('pemakaian_listrik_eng')->insert($data);


    }
}
