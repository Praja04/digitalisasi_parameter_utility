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
use Illuminate\Support\Facades\DB;

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

    public function dashboardForemanEng()
    {
        if (Session::get('jabatan') == 'foreman') {
            return view('user.foreman.eng.data_pemakaian_air');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    public function dataPemakaianListrikForemanEng()
    {
        if (Session::get('jabatan') == 'foreman') {
            return view('user.foreman.eng.data_pemakaian_listrik');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    public function dataPemakaianChemicalForemanEng()
    {
        if (Session::get('jabatan') == 'foreman') {
            return view('user.foreman.eng.data_pemakaian_chemical');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
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
        $request->validate([
            'waktu' => 'required',
            'operator' => 'required',
        ]);

        try {
            // Simpan batch baru
            $nama_user = Session::get('username');
            $batch = PemakaianListrikModel::create([
                'waktu' => $request->waktu,
                'operator' => $request->operator,
                // 'operator' => $nama_user, 
            ]);

            return response()->json(['success' => true, 'data' => $batch]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
}
