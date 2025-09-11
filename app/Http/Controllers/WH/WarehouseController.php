<?php

namespace App\Http\Controllers\WH;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\P2HForklfitModel;
use App\Models\Warehouse\P2HPalletMoverModel;
use App\Models\Warehouse\ForkliftModel;
use App\Models\Warehouse\PalletMoverModel;
use App\Models\Warehouse\UserForkliftAssignmentModel;
use App\Models\Warehouse\PalletAssignmentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WarehouseController extends Controller
{
    ///////////Start View Dept Head///////////////////
    public function DashboardDeptHeadWarehouse()
    {
        if (Session::get('jabatan') == 'dept_head') {
            return view('user.dept_head.dashboard_wh');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    public function DashboardDeptHeadTKBM()
    {
        if (Session::get('jabatan') == 'dept_head') {
            return view('user.dept_head.wh.analytics_tkbm');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    ///////////End View Dept Head///////////////////

    ///////////Start View Supervisor///////////////////
    public function DashboardSupervisorWarehouse()
    {
        if (Session::get('jabatan') == 'supervisor') {
            return view('user.supervisor.wh.dashboard');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    public function DetailP2HSupervisorWarehouse()
    {
        if (Session::get('jabatan') == 'supervisor') {
            return view('user.supervisor.wh.data');
        }
        return redirect('/')->with(
            'error',
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }
    ///////////End View Supervisor///////////////////

    /////////////// 🔹 Dashboard untuk Operator //////////////////
    public function DashboardOperatorWarehouse()
    {
        if (Session::get('jabatan') === 'operator') {
            $userId = Session::get('user_id');

            $assignments = UserForkliftAssignmentModel::with('forklift')
                ->where('user_id', $userId)
                ->where('is_active', true)
                ->get();

            $forklifts = $assignments->filter(fn($a) => $a->forklift)->map(function ($a) {
                return [
                    'nomor_unit' => $a->forklift->nomor_unit,
                    'departemen' => $a->forklift->departemen,
                    'is_primary' => $a->is_primary,
                ];
            });

            $palletAssignments = PalletAssignmentModel::with('palletMover')
                ->where('user_id', $userId)
                ->get();

            $pallets = $palletAssignments->filter(fn($a) => $a->palletMover)->map(function ($a) {
                return [
                    'nomor_unit' => $a->palletMover->nomor_unit,
                    'departemen' => $a->palletMover->departemen,
                    'is_primary' => $a->is_primary,
                    'tipe' => 'Pallet Mover'
                ];
            });


            // Ambil departemen & nomor unit pertama untuk default tampilan
            $departemen = $forklifts->first()['departemen'] ?? '';
            $nomorUnit = $forklifts->first()['nomor_unit'] ?? '';

            $departemenpallet = $pallets->first()['departemen'] ?? '';
            $nomorUnitpallet = $pallets->first()['nomor_unit'] ?? '';
            //dd($pallets);
            return view('user.operator.wh.dashboard_wh', compact('forklifts', 'pallets', 'departemen', 'nomorUnit', 'departemenpallet', 'nomorUnitpallet'));
        }

        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    public function DetailP2HOperatorWarehouse()
    {
        if (Session::get('jabatan') == 'operator') {
            return view('user.operator.wh.data');
        }
        return redirect('/')->with(
            'error',
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }


    ////////////End View Operator /////////////////

    //////////// Start View Foreman /////////////////
    public function DashboardForemanWarehouse()
    {
        if (Session::get('jabatan') == 'foreman') {

            return view('user.foreman.wh.dashboard');
        }
        return redirect('/')->with(
            'error',
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }

    public function FormP2HForeman()
    {
        if (Session::get('jabatan') == 'foreman') {
            $data_forklift = ForkliftModel::all();
            $data_pallet = PalletMoverModel::all();
            return view('user.foreman.wh.form_p2h', compact('data_forklift', 'data_pallet'));
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    public function DetailP2HForemanWarehouse()
    {
        if (Session::get('jabatan') == 'foreman') {
            return view('user.foreman.wh.data');
        }
        return redirect('/')->with(
            'error',
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }
    /////////// End View Foreman /////////////////


    //forklift P2H
    public function storeP2h(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_p2h' => 'nullable|string|max:50',
            'nomor_unit' => 'required|string|max:50',
            'dept'  => 'required|string|max:50',
            'shift' => 'required',
            'operator_name' => 'required|string|max:100',
            'catatan' => 'nullable|string',
            'jam_operasional' => 'required',

            // Validasi status komponen
            'cek_baterai' => 'required|in:1,0',
            'cek_fork' => 'required|in:1,0',
            'kondisi_body_kebersihan' => 'required|in:1,0',
            'lampu_kiri' => 'required|in:1,0',
            'lampu_kanan' => 'required|in:1,0',
            'lampu_sorot' => 'required|in:1,0',
            'lampu_sign_depan_kanan' => 'required|in:1,0',
            'lampu_sign_depan_kiri' => 'required|in:1,0',
            'kipas_belakang' => 'required|in:1,0',
            'rantai_lift' => 'required|in:1,0',
            'sistem_hidrolik' => 'required|in:1,0',
            'kondisi_axle' => 'required|in:1,0',
            'sistem_kemudi' => 'required|in:1,0',
            'panel_display' => 'required|in:1,0',
            'air_aki' => 'required|in:1,0',
            'klakson' => 'required|in:1,0',
            'buzzer_mundur' => 'required|in:1,0',
            'kaca_spion' => 'required|in:1,0',
            'kondisi_ban' => 'required|in:1,0',
            'fungsi_rem' => 'required|in:1,0',
        ]);

        // Cek duplikasi data
        $exists = P2HForklfitModel::whereDate('tanggal', $request->tanggal)
            ->where('shift', $request->shift)
            ->where('nomor_unit', $request->nomor_unit)
            ->where('jenis_p2h', $request->jenis_p2h)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Data untuk tanggal, shift, jenis P2H, dan nomor unit ini sudah ada.'
            ], 422);
        }

        // Validasi jam operasional
        $lastRecord = P2HForklfitModel::where('nomor_unit', $request->nomor_unit)
            ->orderByDesc('created_at')
            ->first();

        if ($lastRecord && $request->jam_operasional < $lastRecord->jam_operasional) {
            return response()->json([
                'success' => false,
                'message' => 'Hours Meter unit ini tidak boleh lebih kecil dari data sebelumnya (' . $lastRecord->jam_operasional . '). Cek kembali!'
            ], 422);
        }

        // Perhitungan persentase
        $group20 = ['cek_baterai', 'cek_fork', 'kondisi_body_kebersihan', 'lampu_kiri', 'lampu_kanan', 'lampu_sorot', 'lampu_sign_depan_kanan', 'lampu_sign_depan_kiri', 'kipas_belakang'];
        $group50 = ['rantai_lift', 'sistem_hidrolik', 'kondisi_axle', 'sistem_kemudi', 'panel_display', 'jam_operasional', 'air_aki'];
        $group30 = ['klakson', 'buzzer_mundur', 'kaca_spion', 'kondisi_ban', 'fungsi_rem'];

        $totalPoin = 0;
        foreach ($group20 as $field) {
            $totalPoin += $request->$field ? 20 : 0;
        }
        foreach ($group50 as $field) {
            $totalPoin += $request->$field ? 50 : 0;
        }
        foreach ($group30 as $field) {
            $totalPoin += $request->$field ? 30 : 0;
        }

        $maxPoin = (count($group20) * 20) + (count($group50) * 50) + (count($group30) * 30); // Total bobot ideal
        $persentase = round(($totalPoin / $maxPoin) * 100, 2);

        // Deteksi rusak berat
        $criticalNok = ['cek_baterai', 'kipas_belakang', 'rantai_lift', 'sistem_hidrolik', 'kondisi_axle', 'sistem_kemudi', 'panel_display', 'air_aki', 'fungsi_rem'];
        $isRusakBerat = collect($criticalNok)->contains(fn($f) => $request->$f == 0);
        $statusUnit = $isRusakBerat ? 'Rusak Berat' : 'Normal';
        if ($isRusakBerat) {
            $persentase = 50.00; // Tetapkan nilai default jika rusak berat
        }
        try {
            $batch = P2HForklfitModel::create([
                'tanggal' => $request->tanggal,
                'jenis_p2h' => $request->jenis_p2h,
                'nomor_unit' => $request->nomor_unit,
                'dept' => $request->dept,
                'shift' => $request->shift,
                'operator_name' => $request->operator_name,
                'catatan' => $request->catatan,
                'cek_baterai' => $request->cek_baterai,
                'cek_fork' => $request->cek_fork,
                'kondisi_body_kebersihan' => $request->kondisi_body_kebersihan,
                'lampu_kiri' => $request->lampu_kiri,
                'lampu_kanan' => $request->lampu_kanan,
                'lampu_sorot' => $request->lampu_sorot,
                'lampu_sign_depan_kanan' => $request->lampu_sign_depan_kanan,
                'lampu_sign_depan_kiri' => $request->lampu_sign_depan_kiri,
                'kipas_belakang' => $request->kipas_belakang,
                'rantai_lift' => $request->rantai_lift,
                'sistem_hidrolik' => $request->sistem_hidrolik,
                'kondisi_axle' => $request->kondisi_axle,
                'sistem_kemudi' => $request->sistem_kemudi,
                'panel_display' => $request->panel_display,
                'jam_operasional' => $request->jam_operasional,
                'air_aki' => $request->air_aki,
                'klakson' => $request->klakson,
                'buzzer_mundur' => $request->buzzer_mundur,
                'kaca_spion' => $request->kaca_spion,
                'kondisi_ban' => $request->kondisi_ban,
                'fungsi_rem' => $request->fungsi_rem,
                'persentase' => $persentase
            ]);

            return response()->json([
                'success' => true,
                'data' => $batch,
                'persentase' => $persentase,
                'status_unit' => $statusUnit
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function destroyP2h($id)
    {
        $data = P2HForklfitModel::findOrFail($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'data berhasil dihapus!'
        ]);
    }

    public function updateDetail(Request $request, $id)
    {
        $detail = P2HForklfitModel::findOrFail($id);

        $exclude = ['id', 'created_at', 'updated_at', 'p2h_model_id', 'shift', 'jenis_p2h', 'tanggal', 'nomor_unit', 'dept'];
        $fillable = collect($request->all())->except($exclude)->toArray();

        $detail->update($fillable);

        return response()->json(['status' => 'success']);
    }





    //pallet mover P2H
    public function storeP2hPalletMover(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_p2h' => 'required|string',
            'nomor_unit' => 'required|string',
            'dept' => 'required|string',
            'shift' => 'required|string',
            'operator_name' => 'required|string',
            'catatan' => 'nullable|string',
            'check_air_accu' => 'required|in:0,1',
            'check_battery' => 'required|in:0,1',
            'check_body_unit' => 'required|in:0,1',
            'check_klakson' => 'required|in:0,1',
            'check_roda' => 'required|in:0,1',
            'check_sistem_kemudi' => 'required|in:0,1',
            'check_kebersihan_unit' => 'required|in:0,1',
            'check_kunci_pm' => 'required|in:0,1',
            'check_hydraulic' => 'required|in:0,1',
        ]);

        // Cek apakah data dengan kombinasi unik sudah ada
        $exists = P2HPalletMoverModel::whereDate(
            'tanggal',
            $request->tanggal
        )
            ->where('shift', $request->shift)
            ->where('nomor_unit', $request->nomor_unit)
            ->where('jenis_p2h', $request->jenis_p2h)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Data untuk tanggal, shift, jenis p2h, dan nomor unit ini sudah ada.'
            ], 422);
        }

        try {
            $batch = P2HPalletMoverModel::create($request->all());

            return response()->json([
                'success' => true,
                'data' => $batch
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyP2hPalletMover($id)
    {
        $data = P2HPalletMoverModel::findOrFail($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'data berhasil dihapus!'
        ]);
    }

    public function updateDetailPalletMover(Request $request, $id)
    {
        $detail = P2HPalletMoverModel::findOrFail($id);

        $exclude = [
            'id',
            'created_at',
            'updated_at',
            'shift',
            'jenis_p2h',
            'tanggal',
            'nomor_unit',
            'dept'
        ];
        $fillable = collect($request->all())->except($exclude)->toArray();

        $detail->update($fillable);

        return response()->json(['status' => 'success']);
    }




    //api

    // 1. Total pemeriksaan dan status
    public function summary()
    {
        $today = Carbon::today();

        // Total semua entri
        $total = P2HForklfitModel::count();

        // Total entri hari ini
        $todayCount = P2HForklfitModel::whereDate('tanggal', $today)->count();

        // Completed: nomor_unit + tanggal yang sudah ada 3 shift
        $completed = P2HForklfitModel::select('nomor_unit', 'tanggal')
            ->groupBy('nomor_unit', 'tanggal')
            ->havingRaw('COUNT(DISTINCT shift) = 3')
            ->get()
            ->count();

        // Pending: nomor_unit + tanggal yang belum lengkap 3 shift
        $pending = P2HForklfitModel::select('nomor_unit', 'tanggal')
            ->groupBy('nomor_unit', 'tanggal')
            ->havingRaw('COUNT(DISTINCT shift) < 3')
            ->get()
            ->count();

        return response()->json([
            'total' => $total,
            'today' => $todayCount,
            'completed' => $completed,
            'pending' => $pending,
        ]);
    }

    // 2. Persentase kelayakan rata-rata dan kategori
    public function kelayakanSummary()
    {
        $data = P2HForklfitModel::all();
        $total = $data->count();

        $kategori = [
            'layak' => 0,
            'perlu_perhatian' => 0,
            'tidak_layak' => 0,

        ];

        if ($total > 0) {
            $totalPersen = 0;

            foreach ($data as $item) {
                $result = $item->calculateKelayakan();
                $persen = $result['persentase'];
                $totalPersen += $persen;

                if ($persen >= 95) $kategori['layak']++;
                elseif ($persen >= 85) $kategori['perlu_perhatian']++;
                else $kategori['tidak_layak']++;
            }
        }

        return response()->json($kategori);
    }

    // 3. Komponen paling sering rusak (nilai ≠ OK)
    public function topMasalah()
    {
        $komponen = [
            'cek_baterai',
            'cek_fork',
            'kondisi_body_kebersihan',
            'lampu_kiri',
            'lampu_kanan',
            'lampu_sorot',
            'lampu_sign_depan_kanan',
            'lampu_sign_depan_kiri',
            'kipas_belakang',
            'rantai_lift',
            'sistem_hidrolik',
            'kondisi_axle',
            'sistem_kemudi',
            'panel_display',
            'air_aki',
            'klakson',
            'buzzer_mundur',
            'kaca_spion',
            'kondisi_ban',
            'fungsi_rem'
        ];

        $rusak = [];

        foreach ($komponen as $item) {
            $rusak[$item] = P2HForklfitModel::where($item, '!=', 'OK')->count();
        }

        arsort($rusak); // urutkan dari terbanyak
        $top = array_slice($rusak, 0, 5); // ambil 5 teratas

        return response()->json($top);
    }

    // 4. Operator terbanyak + avg kelayakan
    public function operatorStat()
    {
        $data = P2HForklfitModel::select('operator_name', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('operator_name')
            ->orderByDesc('jumlah')
            ->take(5)
            ->get();

        $hasil = $data->map(function ($item) {
            $records = P2HForklfitModel::where('operator_name', $item->operator_name)->get();
            $avg = $records->avg(fn($r) => $r->calculateKelayakan()['persentase']);

            return [
                'operator' => $item->operator_name,
                'jumlah' => $item->jumlah,
                'rata_kelayakan' => round($avg, 2)
            ];
        });

        return response()->json($hasil);
    }

    // 5. Distribusi shift
    public function shiftDistribusi()
    {
        $data = P2HForklfitModel::select('shift', DB::raw('COUNT(*) as total'))
            ->groupBy('shift')
            ->orderBy('shift')
            ->get();

        return response()->json($data);
    }


    // 6. Progress pemeriksaan per unit
    public function unitProgress()
    {
        $units = P2HForklfitModel::select('nomor_unit')
            ->distinct()
            ->pluck('nomor_unit');

        $data = $units->map(function ($unit) {
            $records = P2HForklfitModel::where('nomor_unit', $unit)->get();
            $avg = $records->count() ? round($records->avg(fn($r) => $r->calculateKelayakan()['persentase'])) : 0;
            return [
                'unit' => $unit,
                'count' => $records->count(),
                'avg_kelayakan' => $avg
            ];
        });

        return response()->json($data);
    }


    // 7. Masalah berulang per unit
    public function masalahBerulang()
    {
        $fields = ['cek_fork', 'klakson', 'lampu_kiri', 'lampu_kanan'];
        $unitData = [];

        foreach ($fields as $field) {
            $data = P2HForklfitModel::where($field, '!=', 'OK')
                ->select('nomor_unit', DB::raw("COUNT(*) as jumlah"))
                ->groupBy('nomor_unit')
                ->having('jumlah', '>=', 2)
                ->get();

            foreach ($data as $row) {
                $unitData[] = [
                    'unit' => $row->nomor_unit,
                    'komponen' => $field,
                    'jumlah_masalah' => $row->jumlah
                ];
            }
        }

        return response()->json($unitData);
    }


    // 8. Pemeriksaan hari ini
    public function pemeriksaanHariIni()
    {
        $today = Carbon::today();
        $data = P2HForklfitModel::whereDate('tanggal', $today)->get();

        return response()->json($data);
    }

    // 9. data P2H berdasarkan tanggal
    public function getP2HGroupedDetail(Request $request)
    {

        $data = P2HForklfitModel::orderBy('tanggal', 'desc')->get()
            ->groupBy(fn($item) => $item->jenis_p2h . '|' . $item->tanggal . '|' . $item->nomor_unit);

        $result = [];

        foreach ($data as $groupKey => $items) {
            [$jenis_p2h, $tanggal, $nomor_unit] = explode('|', $groupKey);

            $shiftData = [];

            foreach ($items as $item) {
                $shiftData[$item->shift] = $item;
            }

            $result[] = [
                'tanggal' => $tanggal,
                'nomor_unit' => $nomor_unit,
                'jenis_p2h' => $jenis_p2h,
                'shifts' => $shiftData
            ];
        }

        return response()->json($result);
    }
    public function getP2HGroupedDetailPalletMover()
    {
        $data = P2HPalletMoverModel::orderBy('tanggal', 'desc')->get()
            ->groupBy(fn($item) => $item->jenis_p2h . '|' . $item->tanggal . '|' . $item->nomor_unit);

        $result = [];

        foreach ($data as $groupKey => $items) {
            [$jenis_p2h, $tanggal, $nomor_unit] = explode('|', $groupKey);

            $shiftData = [];

            foreach ($items as $item) {
                $shiftData[$item->shift] = $item;
            }

            $result[] = [
                'tanggal' => $tanggal,
                'nomor_unit' => $nomor_unit,
                'jenis_p2h' => $jenis_p2h,
                'shifts' => $shiftData
            ];
        }

        return response()->json($result);
    }
}
