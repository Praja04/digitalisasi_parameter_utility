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
    ///////////End View Supervisor///////////////////

    /////////////// 🔹 Dashboard untuk Operator //////////////////
    public function DashboardOperatorWarehouse()
    {
        if (Session::get('jabatan') == 'operator') {
            return view('user.operator.wh.dashboard_wh');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    public function DetailP2HOperatorWarehouse($id)
    {
        if (Session::get('jabatan') == 'operator') {
            return view('user.operator.wh.detail_p2h', ['id' => $id]);
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

    public function DetailP2HForeman($id)
    {
        if (Session::get('jabatan') == 'foreman') {
            $p2h = P2HModel::with('details')->findOrFail($id);

            // Hitung persentase kelayakan untuk setiap detail
            foreach ($p2h->details as $detail) {
                $detail->persentase_kelayakan = $detail->calculateKelayakan();
            }
            return view('user.foreman.wh.detail_p2h', compact('p2h'));
        }
        return redirect('/')->with(
            'error',
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }
    /////////// End View Foreman /////////////////

    public function index()
    {
        $checkForms = CheckForm::with('forklift')->latest()->get();
        return response()->json($checkForms);
    }

    public function fetchFormData()
    {
        $forklifts = Forklift::all();
        $checkItems = CheckItem::all();
        return response()->json(compact('forklifts', 'checkItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'forklift_id' => 'required|exists:forklifts,id',
            'shift' => 'required|in:Shift 1,Shift 2,Shift 3',
            'tanggal' => 'required|date',
            'operator_name' => 'required|string',
            'check_items' => 'required|array',
            'check_items.*.item_id' => 'required|exists:check_items,id',
            'check_items.*.condition_value' => 'required|string',
        ]);

        $checkForm = CheckForm::create($request->only(['forklift_id', 'shift', 'tanggal', 'operator_name']));

        foreach ($request->check_items as $item) {
            CheckFormItem::create([
                'check_form_id' => $checkForm->id,
                'check_item_id' => $item['item_id'],
                'condition_value' => $item['condition_value'],
                'remarks' => $item['remarks'] ?? null,
            ]);
        }

        return response()->json(['message' => 'Pemeriksaan berhasil disimpan.']);
    }

    public function show(CheckForm $checkForm)
    {
        $checkForm->load(['forklift', 'checkFormItems.checkItem']);
        return response()->json($checkForm);
    }

    public function update(Request $request, CheckForm $checkForm)
    {
        $request->validate([
            'forklift_id' => 'required|exists:forklifts,id',
            'shift' => 'required|in:Shift 1,Shift 2,Shift 3',
            'tanggal' => 'required|date',
            'operator_name' => 'required|string',
            'check_items' => 'required|array',
            'check_items.*.item_id' => 'required|exists:check_items,id',
            'check_items.*.condition_value' => 'required|string',
        ]);

        $checkForm->update($request->only(['forklift_id', 'shift', 'tanggal', 'operator_name']));

        $checkForm->checkFormItems()->delete();

        foreach ($request->check_items as $item) {
            CheckFormItem::create([
                'check_form_id' => $checkForm->id,
                'check_item_id' => $item['item_id'],
                'condition_value' => $item['condition_value'],
                'remarks' => $item['remarks'] ?? null,
            ]);
        }

        return response()->json(['message' => 'Data berhasil diperbarui.']);
    }

    public function destroy(CheckForm $checkForm)
    {
        $checkForm->checkFormItems()->delete();
        $checkForm->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    //////
    public function data_master()
    {

        $data = P2HModel::with('details')->where('status', !'completed')->orderBy('tanggal', 'DESC')->get();
        return response()->json($data);
    }

    public function storeP2h(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_unit' => 'required|string|max:50',
            'dept'  => 'required|string|max:50',
        ]);

        try {
            $batch = P2HModel::create([
                'tanggal' => $request->tanggal,
                'status' => 'pending',
                'nomor_unit' => $request->nomor_unit,
                'dept' => $request->dept,
            ]);

            return response()->json(['success' => true, 'data' => $batch]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroyP2h($id)
    {
        $data = P2HModel::findOrFail($id);
        $data->details()->delete();
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'data berhasil dihapus!'
        ]);
    }

    public function updateP2h(Request $request, $id)
    {
        $data = P2HModel::findOrFail($id);

        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_unit' => 'required|string|max:50',
            'dept'  => 'required|string|max:50',
        ]);

        $data->update([
            'tanggal' => $request->tanggal,
            'nomor_unit' => $request->nomor_unit,
            'dept' => $request->dept,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui!'
        ]);
    }

    public function formDetailP2h($id)
    {
        $p2h = P2HModel::with('details')->findOrFail($id);

        // Hitung persentase kelayakan untuk setiap detail
        foreach ($p2h->details as $detail) {
            $detail->persentase_kelayakan = $detail->calculateKelayakan();
        }
        return view('user.operator.wh.detail_p2h', compact('p2h'));
    }

    public function storeDetailP2h(Request $request, $id)
    {
        $p2h = P2HModel::findOrFail($id);

        $existingCount = $p2h->details()->count();
        if ($existingCount >= 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'Maksimal 3 shift telah diisi untuk data ini.'
            ], 400);
        }

        // Cek apakah shift yang sama sudah ada
        $shiftExists = $p2h->details()->where('shift', $request->shift)->exists();
        if ($shiftExists) {
            return response()->json([
                'status' => 'error',
                'message' => $request->shift . ' sudah diisi sebelumnya.'
            ], 400);
        }

        $validated = $request->validate([
            'shift' => 'required',
            'operator_name' => 'required|string|max:100',
            'catatan' => 'nullable|string',
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
            'jam_operasional' => 'required|in:1,0',
            'air_aki' => 'required|in:1,0',
            'klakson' => 'required|in:1,0',
            'buzzer_mundur' => 'required|in:1,0',
            'kaca_spion' => 'required|in:1,0',
            'kondisi_ban' => 'required|in:1,0',
            'fungsi_rem' => 'required|in:1,0',
        ]);

        $validated['id_p2h'] = $id;

        $newDetail = detailP2HModel::create($validated);

        // Hitung persentase kelayakan langsung dari model
        $persentase = $newDetail->calculateKelayakan();

        return response()->json([
            'status' => 'success',
            'message' => 'Data shift berhasil disimpan. Persentase kelayakan: ' . $persentase . '%'
        ]);
    }


    //api

    // 1. Total pemeriksaan dan status
    public function summary()
    {
        $today = Carbon::today();

        return response()->json([
            'total' => P2HModel::count(),
            'today' => P2HModel::whereDate('tanggal', $today)->count(),
            'pending' => P2HModel::where('status', 'pending')->count(),
            'completed' => P2HModel::where(
                'status',
                'completed'
            )->count(),
        ]);
    }

    // 2. Persentase kelayakan rata-rata dan kategori
    public function kelayakanSummary()
    {
        $details = detailP2HModel::all();
        $total = $details->count();

        $kelayakan = [
            'less_than_60' => 0,
            'between_60_80' => 0,
            'above_80' => 0,
            'avg' => 0,
        ];

        if ($total > 0) {
            $kelayakanTotal = 0;

            foreach ($details as $d) {
                $k = $d->calculateKelayakan();
                $kelayakanTotal += $k;

                if ($k < 60) $kelayakan['less_than_60']++;
                elseif ($k < 80) $kelayakan['between_60_80']++;
                else $kelayakan['above_80']++;
            }

            $kelayakan['avg'] = round($kelayakanTotal / $total);
        }

        return response()->json($kelayakan);
    }

    // 3. Komponen paling sering rusak (nilai 0)
    public function topMasalah()
    {
        $fields = [
            'cek_baterai', 'cek_fork', 'kondisi_body_kebersihan', 'lampu_kiri', 'lampu_kanan',
            'lampu_sorot', 'lampu_sign_depan_kanan', 'lampu_sign_depan_kiri', 'kipas_belakang',
            'rantai_lift', 'sistem_hidrolik', 'kondisi_axle', 'sistem_kemudi', 'panel_display',
            'jam_operasional', 'air_aki', 'klakson', 'buzzer_mundur', 'kaca_spion', 'kondisi_ban',
            'fungsi_rem'
        ];

        $data = [];
        foreach ($fields as $field) {
            $data[$field] = detailP2HModel::where($field, 0)->count();
        }

        arsort($data); // sort desc
        $top5 = array_slice($data, 0, 5);

        return response()->json($top5);
    }

    // 4. Operator terbanyak + avg kelayakan
    public function operatorStat()
    {
        $operatorData = detailP2HModel::select('operator_name', DB::raw('COUNT(*) as total'))
            ->groupBy('operator_name')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $data = $operatorData->map(function ($op) {
            $details = detailP2HModel::where('operator_name', $op->operator_name)->get();
            $avg = $details->avg(fn ($d) => $d->calculateKelayakan());
            return [
                'operator' => $op->operator_name,
                'total' => $op->total,
                'avg_kelayakan' => round($avg),
            ];
        });

        return response()->json($data);
    }

    // 5. Distribusi shift
    public function shiftDistribusi()
    {
        $shifts = detailP2HModel::select('shift', DB::raw('count(*) as total'))
            ->groupBy('shift')
            ->orderBy('shift')
            ->get();

        return response()->json($shifts);
    }

    // 6. Progress pemeriksaan per unit
    public function unitProgress()
    {
        $units = P2HModel::select('nomor_unit')
            ->distinct()
            ->get()
            ->pluck('nomor_unit');

        $data = $units->map(function ($unit) {
            $p2h_ids = P2HModel::where('nomor_unit', $unit)->pluck('id');
            $details = detailP2HModel::whereIn('id_p2h', $p2h_ids)->get();
            return [
                'unit' => $unit,
                'count' => $p2h_ids->count(),
                'avg_kelayakan' => $details->count() ? round($details->avg(fn ($d) => $d->calculateKelayakan())) : 0
            ];
        });

        return response()->json($data);
    }

    // 7. Masalah berulang per unit
    public function masalahBerulang()
    {
        $fields = ['cek_fork', 'klakson', 'lampu_kiri', 'lampu_kanan']; // contoh komponen kritikal
        $unitData = [];

        foreach ($fields as $field) {
            $data = detailP2HModel::where($field, 0)
                ->join('master_p2h', 'detail_p2h.id_p2h', '=', 'master_p2h.id')
                ->select('master_p2h.nomor_unit', DB::raw("COUNT(*) as jumlah"))
                ->groupBy('master_p2h.nomor_unit')
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
        $data = P2HModel::with('details')
            ->whereDate('tanggal', $today)
            ->get();

        return response()->json($data);
    }
}
