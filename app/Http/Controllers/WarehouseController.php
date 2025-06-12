<?php

namespace App\Http\Controllers;

use App\Models\Warehouse\CheckForm;
use App\Models\Warehouse\CheckFormItem;
use App\Models\Warehouse\CheckItem;
use App\Models\Warehouse\Forklift;
use App\Models\Warehouse\P2HModel;
use App\Models\Warehouse\detailP2HModel;
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
        if (Session::get('jabatan') == 'operator') {
            return view('user.operator.wh.dashboard_wh');
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
            return view('user.foreman.wh.form_p2h');
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
            // validasi semua kolom boolean (OK/NOK)
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
        // Cek apakah data dengan tanggal + shift + nomor_unit sudah ada
        $exists = P2HModel::whereDate('tanggal', $request->tanggal)
            ->where('shift', $request->shift)
            ->where('nomor_unit', $request->nomor_unit)
            ->where('jenis_p2h', $request->jenis_p2h)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Data untuk tanggal, shift,jenis p2h, dan nomor unit ini sudah ada.'
            ], 422);
        }
        try {
            $batch = P2HModel::create([
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
            ]);

            return response()->json(['success' => true, 'data' => $batch]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroyP2h($id)
    {
        $data = P2HModel::findOrFail($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'data berhasil dihapus!'
        ]);
    }

    public function updateDetail(Request $request , $id)
    {
        $detail = P2HModel::findOrFail($id);

        $exclude = ['id', 'created_at', 'updated_at', 'p2h_model_id', 'shift', 'jenis_p2h', 'tanggal', 'nomor_unit', 'dept'];
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
        $total = P2HModel::count();

        // Total entri hari ini
        $todayCount = P2HModel::whereDate('tanggal', $today)->count();

        // Completed: nomor_unit + tanggal yang sudah ada 3 shift
        $completed = P2HModel::select('nomor_unit', 'tanggal')
            ->groupBy('nomor_unit', 'tanggal')
            ->havingRaw('COUNT(DISTINCT shift) = 3')
            ->get()
            ->count();

        // Pending: nomor_unit + tanggal yang belum lengkap 3 shift
        $pending = P2HModel::select('nomor_unit', 'tanggal')
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
        $data = P2HModel::all();
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
            'cek_baterai', 'cek_fork', 'kondisi_body_kebersihan', 'lampu_kiri', 'lampu_kanan',
            'lampu_sorot', 'lampu_sign_depan_kanan', 'lampu_sign_depan_kiri', 'kipas_belakang',
            'rantai_lift', 'sistem_hidrolik', 'kondisi_axle', 'sistem_kemudi', 'panel_display',
             'air_aki', 'klakson', 'buzzer_mundur', 'kaca_spion', 'kondisi_ban',
            'fungsi_rem'
        ];

        $rusak = [];

        foreach ($komponen as $item) {
            $rusak[$item] = P2HModel::where($item, '!=', 'OK')->count();
        }

        arsort($rusak); // urutkan dari terbanyak
        $top = array_slice($rusak, 0, 5); // ambil 5 teratas

        return response()->json($top);
    }

    // 4. Operator terbanyak + avg kelayakan
    public function operatorStat()
    {
        $data = P2HModel::select('operator_name', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('operator_name')
            ->orderByDesc('jumlah')
            ->take(5)
            ->get();

        $hasil = $data->map(function ($item) {
            $records = P2HModel::where('operator_name', $item->operator_name)->get();
            $avg = $records->avg(fn ($r) => $r->calculateKelayakan()['persentase']);

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
        $data = P2HModel::select('shift', DB::raw('COUNT(*) as total'))
            ->groupBy('shift')
            ->orderBy('shift')
            ->get();

        return response()->json($data);
    }


    // 6. Progress pemeriksaan per unit
    public function unitProgress()
    {
        $units = P2HModel::select('nomor_unit')
        ->distinct()
        ->pluck('nomor_unit');

        $data = $units->map(function ($unit) {
            $records = P2HModel::where('nomor_unit', $unit)->get();
            $avg = $records->count() ? round($records->avg(fn ($r) => $r->calculateKelayakan()['persentase'])) : 0;
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
            $data = P2HModel::where($field, '!=', 'OK')
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
        $data = P2HModel::whereDate('tanggal', $today)->get();

        return response()->json($data);
    }

    // 9. data P2H berdasarkan tanggal
    public function getP2HGroupedDetail(Request $request)
    {

        $jenis = $request->jenis_p2h;
        $data = P2HModel::orderBy('tanggal', 'desc')->where('jenis_p2h', $jenis)->get()
        ->groupBy(fn ($item) => $item->jenis_p2h . '|' . $item->tanggal . '|' . $item->nomor_unit);

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
