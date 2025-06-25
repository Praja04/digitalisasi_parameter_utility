<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\eng\PemakaianAirModel;
use App\Models\eng\PemakaianListrikModel;
use App\Models\eng\ListrikDetailModel;
use App\Models\eng\PemakaianChemicalModel;
use Illuminate\Support\Carbon;
use App\Services\TelegramService;
use App\Models\Boiler\ReadSensors_Boiler;
use App\Models\eng\AirArea;
use Illuminate\Support\Facades\DB;
use App\Models\eng\ChemicalType;
use App\Models\eng\ChemicalArea;

class EngineeringController extends Controller
{
    protected $telegramService;
    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }


    //View
    ///depthead
    public function dashboardEng()
    {
        if (Session::get('jabatan') == 'dept_head') {
            return view('user.dept_head.dashboard_eng');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    public function todoListEng()
    {
        if (Session::get('jabatan') == 'dept_head') {
            return view('user.dept_head.todo_list_eng');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    /////End View Depthead ///////////

    //supervisor
    public function dashboardSupervisorEng()
    {
        if (Session::get('jabatan') == 'supervisor') {
            return view('user.supervisor.eng.dashboard_eng');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    ////End View Supervisor ///////////

    //foreman

    public function menu_PemakaianAirforeman()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.menu_pemakaian_air');
    }
    public function formPemakaianAirforeman()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.form_pemakaian_air');
    }
    public function dataPemakaianAirforeman()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.data_pemakaian_air');
    }

    public function formPemakaianListrikforeman()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.form_pemakaian_listrik');
    }
    public function DetailPemakaianListrikforeman($id)
    {
        if (Session::get('jabatan') == 'operator' || Session::get('jabatan') == 'foreman') {
            $listrik = PemakaianListrikModel::findOrFail($id);
            return view('user.operator.eng.detail_pemakaian_listrik', compact('listrik'));
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    public function formPemakaianChemicalforeman()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.form_pemakaian_chemical');
    }
    ////End View Foreman ///////////

    //operator
    // 🔹 Form untuk Operator
    public function menu_PemakaianAir()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.menu_pemakaian_air');
    }
    public function formPemakaianAir()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.form_pemakaian_air');
    }
    public function dataPemakaianAir()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.data_pemakaian_air');
    }

    public function formPemakaianListrik()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.form_pemakaian_listrik');
    }
    public function DetailPemakaianListrik($id)
    {
        if (Session::get('jabatan') == 'operator' || Session::get('jabatan') == 'foreman') {
            $listrik = PemakaianListrikModel::findOrFail($id);
            return view('user.operator.eng.detail_pemakaian_listrik', compact('listrik'));
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    public function formPemakaianChemical()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.form_pemakaian_chemical');
    }

    public function formUtility()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.form_utility');
    }

    public function DataUtility()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.data_utility');
    }
    /////End View Operator ////////////////


    // Api crud operator
    public function indexAir()
    {
        $data = PemakaianAirModel::orderBy('tanggal', 'desc')->get();
        return response()->json($data);
    }
    public function storeAir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'pemakaian_liter_awal' => 'required|numeric',
            'pemakaian_liter_akhir' => 'required|numeric',
            'jenis_pemakaian' => 'required',
            'notes' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        } // Cek apakah data dengan tanggal + jenis_pemakaian sudah ada
        $exists = PemakaianAirModel::whereDate('tanggal', $request->input('tanggal'))
            ->where('jenis_pemakaian', $request->input('jenis_pemakaian'))
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Data dengan tanggal dan jenis pemakaian yang sama sudah ada.',
            ], 409); // 409 Conflict
        }



        try {
            $air = new PemakaianAirModel();
            $air->tanggal = $request->input('tanggal');
            $air->pemakaian_awal = $request->input('pemakaian_liter_awal');
            $air->pemakaian_akhir = $request->input('pemakaian_liter_akhir');
            $air->jenis_pemakaian = $request->input('jenis_pemakaian');
            $air->created_by = Session::get('username');
            $air->notes = $request->input('notes');
            $air->save();

            return response()->json([
                'message' => 'Data pemakaian air berhasil ditambahkan.',
                'data' => $air,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateAir(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'pemakaian_liter_awal' => 'required|numeric',
            'pemakaian_liter_akhir' => 'required|numeric',
            'jenis_pemakaian' => 'required|in:Outlet Storage RO,Outlet Storage RO Reject,Outlet Fresh Water 1,Outlet Fresh Water 2,WWTP - Boiler - Fasum3',
            'notes' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $air = PemakaianAirModel::find($id);
            if (!$air) {
                return response()->json([
                    'message' => 'Data tidak ditemukan.',
                ], 404);
            }

            $air->tanggal = $request->input('tanggal');
            $air->pemakaian_awal = $request->input('pemakaian_liter_awal');
            $air->pemakaian_akhir = $request->input('pemakaian_liter_akhir');
            $air->jenis_pemakaian = $request->input('jenis_pemakaian');
            $air->created_by = Session::get('username');
            $air->notes = $request->input('notes');
            $air->save();

            return response()->json([
                'message' => 'Data pemakaian air berhasil diupdate.',
                'data' => $air,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengupdate data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroyAir($id)
    {
        try {
            $air = PemakaianAirModel::find($id);
            if (!$air) {
                return response()->json([
                    'message' => 'Data tidak ditemukan.',
                ], 404);
            }

            $air->delete();

            return response()->json([
                'message' => 'Data pemakaian air berhasil dihapus.',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // buatkan crud untuk pemakaian chemical api nya
    public function indexChemical()
    {
        $data = PemakaianChemicalModel::orderBy('tanggal', 'desc')->get();
        return response()->json($data);
    }

    public function storeChemical(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'pemakaian_kg' => 'required|numeric',
            'nama_chemical' => 'required',
            'notes' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = new PemakaianChemicalModel();
            $data->tanggal = $request->input('tanggal');
            $data->pemakaian_kg = $request->input('pemakaian_kg');
            $data->nama_chemical = $request->input('nama_chemical');
            $data->created_by = Session::get('username');
            $data->notes = $request->input('notes');
            $data->save();

            return response()->json([
                'message' => 'Data pemakaian chemical berhasil ditambahkan.',
                'data' => $data,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function updateChemical(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'pemakaian_kg' => 'required|numeric',
            'nama_chemical' => 'required',
            'notes' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = PemakaianChemicalModel::find($id);
            if (!$data) {
                return response()->json([
                    'message' => 'Data tidak ditemukan.',
                ], 404);
            }

            $data->tanggal = $request->input('tanggal');
            $data->pemakaian_kg = $request->input('pemakaian_kg');
            $data->nama_chemical = $request->input('nama_chemical');
            $data->created_by = Session::get('username');
            $data->notes = $request->input('notes');
            $data->save();

            return response()->json([
                'message' => 'Data pemakaian chemical berhasil diupdate.',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengupdate data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroyChemical($id)
    {
        try {
            $data = PemakaianChemicalModel::find($id);
            if (!$data) {
                return response()->json([
                    'message' => 'Data tidak ditemukan.',
                ], 404);
            }

            $data->delete();

            return response()->json([
                'message' => 'Data pemakaian chemical berhasil dihapus.',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    // Api chemical
    public function ApiChemicalPerHari()
    {
        $today = Carbon::now()->toDateString(); // format: 'YYYY-MM-DD'

        $data = PemakaianChemicalModel::whereDate('tanggal', $today)
            ->select('nama_chemical')
            ->selectRaw('SUM(pemakaian_kg) as total')
            ->groupBy('nama_chemical')
            ->orderByDesc('total')
            ->get();

        $top3 = $data->take(3);

        return response()->json([
            'mode' => 'per_hari',
            'tanggal' => $today,
            'data' => $data,
            'top3' => $top3
        ]);
    }

    public function ApiChemicalPerMinggu()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $data = PemakaianChemicalModel::whereBetween('tanggal', [$startOfWeek, $endOfWeek])
            ->select('nama_chemical')
            ->selectRaw('SUM(pemakaian_kg) as total')
            ->groupBy('nama_chemical')
            ->orderByDesc('total')
            ->get();

        $top3 = $data->take(3);

        return response()->json([
            'mode' => 'per_minggu',
            'minggu' => $startOfWeek->toDateString() . ' - ' . $endOfWeek->toDateString(),
            'data' => $data,
            'top3' => $top3
        ]);
    }

    public function ApiChemicalPerBulan()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $data = PemakaianChemicalModel::whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->select('nama_chemical')
            ->selectRaw('SUM(pemakaian_kg) as total')
            ->groupBy('nama_chemical')
            ->orderByDesc('total')
            ->get();

        $top3 = $data->take(3);

        return response()->json([
            'mode' => 'per_bulan',
            'bulan' => $startOfMonth->format('F Y'),
            'data' => $data,
            'top3' => $top3
        ]);
    }



    //dipake
    //api air

    public function getPemakaianAir($mode)
    {
        $query = PemakaianAirModel::query();

        if ($mode == 'harian') {
            $query->whereDate('tanggal', Carbon::today());
        } elseif ($mode == 'mingguan') {
            $query->whereBetween('tanggal', [
                Carbon::now()->subDays(7)->startOfDay(),
                Carbon::now()->endOfDay()
            ]);
        } elseif ($mode == 'bulanan') {
            $query->whereMonth('tanggal', Carbon::now()->month);
        } elseif ($mode === 'terakhir') {
            $data = PemakaianAirModel::orderBy('tanggal', 'desc')->limit(7)->get();
            return response()->json($data);
        }


        $data = $query->orderBy('tanggal', 'desc')->limit(7)->get();

        return response()->json($data);
    }


    public function Notif_boiler()
    {
        $dataReadSensors = ReadSensors_Boiler::orderByDesc('waktu')->first();

        $pv = $dataReadSensors->PVSteam;
        $icon = '';
        $statusText = '';

        if ($pv > 7) {
            $icon = '🚨'; // Danger
            $statusText = 'Danger, tekanan lebih dari 7 bar';
        } elseif ($pv > 6) {
            $icon = '⚠️'; // Warning
            $statusText = 'Warning, tekanan lebih dari 6 bar';
        } else {
            $icon = '✅'; // Normal
            $statusText = 'Aman, tekanan normal';
        }

        $message = "{$icon} <b>Data PV steam</b>\n"
            . "🆔 Nilai PV Steam Now: {$pv} Bar\n"
            . "🕒 Waktu: {$dataReadSensors->waktu}\n"
            . "📌 Status: {$statusText}";

        $this->telegramService->sendMessage($message);

        return response()->json(['message' => 'send success'], 200);
    }

    // crud listrik
    public function data_listrik()
    {

        $data = PemakaianListrikModel::orderBy('waktu', 'desc')
            ->get();

        return response()->json($data);
    }


    public function storeListrik(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'waktu' => 'required|date',
            // 'operator' => 'required|string|max:100',
            'panel_type' => 'required|in:MDP,SDP1,SDP2,SDP3,SDP4,SDP5,SDP6,SDP7,SDP8,SDP9,SDP10,SDP11,SDP12,SDP13,SDP14',
            'volt' => 'nullable|numeric',
            'a' => 'nullable|numeric',
            'kw' => 'nullable|numeric',
            'mwh' => 'nullable|numeric',
            'cos' => 'nullable|numeric',
        ]);
        $operator = Session::get('username');
        try {
            $exists = PemakaianListrikModel::whereDate('waktu', $validated['waktu'])
                ->where('panel_type', $validated['panel_type'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data untuk panel tersebut pada tanggal yang sama sudah ada.',
                ], 409); // 409 = Conflict
            }
            // Simpan ke database
            $data = PemakaianListrikModel::create([
                'waktu' => $validated['waktu'],
                'operator' => $operator,
                'panel_type' => $validated['panel_type'],
                'volt' => $validated['volt'] ?? null,
                'a' => $validated['a'] ?? null,
                'kw' => $validated['kw'] ?? null,
                'mwh' => $validated['mwh'] ?? null,
                'cos' => $validated['cos'] ?? null,
            ]);

            return response()->json(['success' => true, 'message' => 'Data listrik berhasil disimpan.', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateListrik(Request $request, $id)
    {
        $data = PemakaianListrikModel::findOrFail($id);

        $request->validate([
            'waktu' => 'required',
            'operator' => 'required',

        ]);

        $data->update([
            'waktu' => $request->waktu,
            'operator' => $request->operator,

        ]);

        return response()->json([
            'message' => 'Data berhasil diperbarui!',
        ]);
    }

    public function data_listrik_detail($id)
    {

        $data = PemakaianListrikModel::with('details')->findOrFail($id);
        $data_detail = $data->details;
        return response()->json($data_detail);
    }

    public function storeListrikDetail(Request $request, $id)
    {

        $listrik = PemakaianListrikModel::findOrFail($id);

        $request->validate([
            'panel_type' => 'required',
            'volt' => 'required',
            'a' => 'required',
            'kw' => 'required',
            'mwh' => 'required',
        ]);

        // Cek apakah shift sudah ada
        $existingpanel = ListrikDetailModel::where('id_listrik', $listrik->id)
            ->where('panel_type', $request->panel_type)
            ->exists();

        if ($existingpanel) {
            return response()->json([
                'message' => 'Type panel sudah ada datanya untuk tanggal ini!',
                'status' => 'error'
            ], 400);
        }

        $listrikDetail = ListrikDetailModel::create([
            'id_listrik' => $id,
            'panel_type' => $request->panel_type,
            'volt' => $request->volt,
            'a' => $request->a,
            'kw' => $request->kw,
            'mwh' => $request->mwh,
        ]);

        $totalDetail = ListrikDetailModel::where('id_listrik', $id)->count();

        if ($totalDetail === 16) {
            // Update status batch menjadi completed
            PemakaianListrikModel::where('id', $id)->update(['status' => 'completed']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pemakaian berhasil ditambahkan!',
            'data' => $listrikDetail
        ]);
    }

    public function deletelistrikDetail($id)
    {
        $data = ListrikDetailModel::findOrFail($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data listrik ini berhasil dihapus!'
        ]);
    }

    // update shift
    public function updatelistrikDetail(Request $request, $id)
    {
        $data = ListrikDetailModel::findOrFail($id);

        $request->validate([
            'panel_type' => 'required',
            'volt' => 'required',
            'a' => 'required',
            'kw' => 'required',
            'mwh' => 'required',
        ]);

        $data->update([
            'panel_type' => $request->panel_type,
            'volt' => $request->volt,
            'a' => $request->a,
            'kw' => $request->kw,
            'mwh' => $request->mwh,
        ]);

        return response()->json([
            'message' => 'Data berhasil diperbarui!',
        ]);
    }


    // Api Pemakaian Listrik
    public function ApiListrikPerHari($mode)
    {
        if ($mode === 'terakhir') {
            $data = PemakaianListrikModel::with('details')
                ->orderBy('waktu', 'desc')
                ->limit(7)
                ->get()
                ->map(function ($item) {
                    return [
                        'tanggal' => optional($item->waktu)->format('Y-m-d'),
                        'operator' => $item->operator,
                        'status' => $item->status,
                        'details' => $item->details,
                    ];
                });
        } else {
            $query = PemakaianListrikModel::selectRaw('DATE(waktu) as tanggal, SUM(pemakaian_listrik_detail.mwh) as total_mwh')
                ->join('pemakaian_listrik_detail', 'pemakaian_listrik_eng.id', '=', 'pemakaian_listrik_detail.id_listrik');

            if ($mode === 'harian') {
                $query->whereDate('waktu', Carbon::today());
            } elseif ($mode === 'mingguan') {
                $query->whereBetween('waktu', [
                    Carbon::now()->subDays(7)->startOfDay(),
                    Carbon::now()->endOfDay()
                ]);
            } elseif ($mode === 'bulanan') {
                $query->whereMonth('waktu', Carbon::now()->month)
                    ->whereYear('waktu', Carbon::now()->year);
            }

            $raw = $query->groupBy(DB::raw('DATE(waktu)'))
                ->orderBy('tanggal', 'desc')
                ->get();

            // Map agar strukturnya mirip dengan 'terakhir'
            $data = $raw->map(function ($row) {
                return [
                    'tanggal' => $row->tanggal,
                    'total_mwh' => (float) $row->total_mwh,
                    'operator' => null,
                    'status' => null,
                    'details' => [], // atau bisa fetch detail panel jika perlu
                ];
            });
        }

        return response()->json([
            'success' => true,
            'mode' => $mode,
            'data' => $data,
        ]);
    }

    public function getTypesByArea($id)
    {
        $chemicals = ChemicalType::with('area')
            ->where('chemical_area_id', $id)
            ->get();

        if ($chemicals->isEmpty()) {
            return response()->json(['message' => 'No chemicals found for this area'], 404);
        }

        // Ubah ke format yang rapi
        $data = $chemicals->map(function ($chemical) {
            return [
                'id' => $chemical->id,
                'chemical_area_id' => $chemical->chemical_area_id,
                'nama_chemical' => trim($chemical->nama_chemical),
                'satuan' => $chemical->satuan,
                'nama_area' => $chemical->area->nama_area ?? '-',
                'created_at' => $chemical->created_at,
                'updated_at' => $chemical->updated_at,
            ];
        });

        return response()->json($data);
    }

    public function store_chemical(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'shift' => 'required',
            'jenis_pemakaian' => 'required|array',
            'chemical_area' => 'required',
            'jumlah_pemakaian' => 'required|array',
        ]);

        $tanggal = $request->input('tanggal');
        $shift = $request->input('shift');
        $chemical_area = $request->input('chemical_area');
        $keterangan = $request->input('keterangan');
        $jenisPemakaian = $request->input('jenis_pemakaian');
        $jumlahPemakaian = $request->input('jumlah_pemakaian');

        $operator = Session::get('username');
        if (count($jenisPemakaian) !== count($jumlahPemakaian)) {
            return response()->json(['message' => 'Data chemical tidak valid.'], 422);
        }

        foreach ($jenisPemakaian as $index => $jenis) {
            // Cek apakah data dengan kombinasi ini sudah ada
            $existing = PemakaianChemicalModel::where('tanggal', $tanggal)
                ->where('jenis_pemakaian', $jenis)
                ->where('shift', $shift)
                ->where('chemical_area', $chemical_area)
                ->first();

            if ($existing) {
                return response()->json([
                    'message' => 'Data untuk area "' . $chemical_area . '" pada tanggal dan shift ini sudah ada.'
                ], 422);
            }

            // Jika tidak ada, simpan data baru
            PemakaianChemicalModel::create([
                'tanggal' => $tanggal,
                'chemical_area' => $chemical_area,
                'jenis_pemakaian' => $jenis,
                'nilai_pemakaian' => $jumlahPemakaian[$index],
                'operator' => $operator,
                'shift' => $shift,
                'notes' => $keterangan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        return response()->json(['message' => 'Data pemakaian chemical berhasil disimpan.']);
    }

    public function getPemakaianAirData(Request $request)
    {
        
        $data = PemakaianAirModel::orderBy('tanggal')->get();

        // Kelompokkan berdasarkan tanggal
        $grouped = $data->groupBy(function ($item) {
            return date('Y-m-d', strtotime($item->tanggal));
        });

        $result = [];

        foreach ($grouped as $tanggal => $items) {
            $result[] = [
                'tanggal' => $tanggal,
                'data' => $items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'pemakaian_awal' => $item->pemakaian_awal,
                        'pemakaian_akhir' => $item->pemakaian_akhir,
                        'jenis_pemakaian' => $item->jenis_pemakaian,
                        'created_by' => $item->created_by,
                        'notes' => $item->notes,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                    ];
                })->values(),
            ];
        }

        return response()->json($result);
    }


    public function getPemakaianChemicalData(Request $request)
    {
        // Ambil data utama
        $data = PemakaianChemicalModel::orderBy('tanggal')->get();

        // Siapkan mapping satuan dengan key yang dinormalisasi
        $satuanMap = ChemicalType::pluck('satuan', 'nama_chemical')->mapWithKeys(function ($satuan, $nama) {
            $key = strtolower(preg_replace('/[^a-z0-9]/', '', $nama));
            return [$key => $satuan];
        });

        // Kelompokkan berdasarkan tanggal
        $grouped = $data->groupBy(fn ($item) => date('Y-m-d', strtotime($item->tanggal)));

        $result = [];

        foreach ($grouped as $tanggal => $items) {
            $jenisGrouped = $items->groupBy('jenis_pemakaian');

            $jenisData = [];

            foreach ($jenisGrouped as $jenis => $entries) {
                // Normalisasi untuk lookup
                $lookupKey = strtolower(preg_replace('/[^a-z0-9]/', '', $jenis));
                $satuan = $satuanMap[$lookupKey] ?? null;
                // Render shift detail
                $shifts = $entries->map(function ($entry) use ($satuan) {
                    $nilai = $entry->nilai_pemakaian;
                    $formatted = is_null($nilai) ? '-' : $nilai . ($satuan ? " {$satuan}" : '');
                    return [
                        'shift' => $entry->shift,
                        'nilai_pemakaian' => $formatted,
                        'area' => $entry->chemical_area,
                        'operator' => $entry->operator,
                        'notes' => $entry->notes,
                        'created_at' => $entry->created_at,
                        'updated_at' => $entry->updated_at,
                    ];
                })->sortBy(fn ($s) => preg_replace('/\D/', '', strtolower($s['shift'])))
                ->values();

                $jenisData[] = [
                    'jenis_pemakaian' => $jenis,
                    'shifts' => $shifts
                ];
            }

            $result[] = [
                'tanggal' => $tanggal,
                'data' => $jenisData
            ];
        }

        return response()->json($result);
    }

    public function getPemakaianListrikData(Request $request)
    {
        $defaultPanelOrder = ['MDP', 'SDP1', 'SDP2', 'SDP3', 'SDP4', 'SDP5', 'SDP6', 'SDP7', 'SDP8', 'SDP9', 'SDP10', 'SDP11', 'SDP12', 'SDP13', 'SDP14'];

        $data = PemakaianListrikModel::orderBy('waktu')->get();

        // Kelompokkan data berdasarkan tanggal
        $grouped = $data->groupBy(function ($item) {
            return date('Y-m-d', strtotime($item->waktu));
        });

        $sortedDates = $grouped->keys()->sort()->values(); // pastikan urut tanggal naik
        $result = [];

        foreach ($sortedDates as $index => $tanggal) {
            $items = $grouped[$tanggal];
            $pivot = [];
            $usage = [];
            $operators = [];

            // Panel tersedia dan terurut
            $availablePanels = $items->pluck('panel_type')->unique()->values()->all();
            $panels = array_values(array_intersect($defaultPanelOrder, $availablePanels));

            // Ambil operator
            foreach ($panels as $panel) {
                $panelItem = $items->firstWhere('panel_type', $panel);
                $operators[$panel] = $panelItem?->operator ?? null;
            }

            // Ambil semua parameter
            $parameters = ['volt', 'a', 'kw', 'mwh', 'cos'];
            foreach ($parameters as $param) {
                $pivot[$param] = [];
                foreach ($panels as $panel) {
                    $panelItem = $items->firstWhere('panel_type', $panel);
                    $pivot[$param][$panel] = $panelItem?->$param ?? null;
                }
            }

            if ($index < count($sortedDates) - 1) {
                $nextTanggal = $sortedDates[$index + 1];
                $nextItems = $grouped[$nextTanggal];

                foreach ($panels as $panel) {
                    $currVolt = $items->firstWhere('panel_type', $panel)?->volt;
                    $nextVolt = $nextItems->firstWhere('panel_type', $panel)?->volt;

                    if (!is_null($currVolt) && !is_null($nextVolt)) {
                        $usage[$panel] = $currVolt - $nextVolt;
                    } else {
                        $usage[$panel] = null;
                    }
                }
            } else {
                foreach ($panels as $panel) {
                    $usage[$panel] = null;
                }
            }

            $result[] = [
                'tanggal' => $tanggal,
                'operator' => $operators,
                'panels' => $panels,
                'rows' => $pivot,
                'usage' => $usage, // Tambahkan usage di sini
            ];
        }

        return response()->json($result);
    }

    public function getChemicalAreas()
    {
        $areas = ChemicalArea::orderBy('nama_area')->get();

        return response()->json($areas);
    }

    public function getAirAreas()
    {
        $areas = AirArea::orderBy('nama_area')->get();

        return response()->json($areas);
    }
}
