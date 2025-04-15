<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\eng\PemakaianAirModel;
use App\Models\eng\PemakaianListrikModel;
use App\Models\eng\PemakaianChemicalModel;
use Illuminate\Support\Carbon;


class EngineeringController extends Controller
{
    //
    // 🔹 Form untuk Operator
    public function formPemakaianAir()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.form_pemakaian_air');
    }
    public function formPemakaianListrik()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.form_pemakaian_listrik');
    }
    public function formPemakaianChemical()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.eng.form_pemakaian_chemical');
    }

    // buatkan crud untuk pemakaian air api nya
    public function indexAir()
    {
        $data = PemakaianAirModel::orderBy('tanggal', 'desc')->get();
        return response()->json($data);
    }
    public function storeAir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'pemakaian_liter' => 'required|numeric',
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
            $air->pemakaian_liter = $request->input('pemakaian_liter');
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
            'pemakaian_liter' => 'required|numeric',
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
            $air->pemakaian_liter = $request->input('pemakaian_liter');
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

    // buatkan crud untuk pemakaian listrik api nya
    public function indexListrik()
    {
        $data = PemakaianListrikModel::orderBy('tanggal', 'desc')->get();
        return response()->json($data);
    }

    public function storeListrik(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'pemakaian_kwh' => 'required|numeric',
            'notes' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = new PemakaianListrikModel();
            $data->tanggal = $request->input('tanggal');
            $data->pemakaian_kwh = $request->input('pemakaian_kwh');
            $data->created_by = Session::get('username');
            $data->notes = $request->input('notes');
            $data->save();

            return response()->json([
                'message' => 'Data pemakaian listrik berhasil ditambahkan.',
                'data' => $data,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function updateListrik(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'pemakaian_kwh' => 'required|numeric',
            'notes' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = PemakaianListrikModel::find($id);
            if (!$data) {
                return response()->json([
                    'message' => 'Data tidak ditemukan.',
                ], 404);
            }

            $data->tanggal = $request->input('tanggal');
            $data->pemakaian_kwh = $request->input('pemakaian_kwh');
            $data->created_by = Session::get('username');
            $data->notes = $request->input('notes');
            $data->save();

            return response()->json([
                'message' => 'Data pemakaian listrik berhasil diupdate.',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengupdate data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function destroyListrik($id)
    {
        try {
            $data = PemakaianListrikModel::find($id);
            if (!$data) {
                return response()->json([
                    'message' => 'Data tidak ditemukan.',
                ], 404);
            }

            $data->delete();

            return response()->json([
                'message' => 'Data pemakaian listrik berhasil dihapus.',
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
        }
        elseif ($mode === 'terakhir') {
            $data = PemakaianAirModel::orderBy('tanggal', 'desc')->limit(7)->get();
            return response()->json($data);
        }


        $data = $query->orderBy('tanggal', 'desc')->limit(7)->get();

        return response()->json($data);
    }

    //api listrik

    public function getPemakaianListrik($mode)
    {
        $query = PemakaianListrikModel::query();

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
            $data = PemakaianListrikModel::orderBy('tanggal', 'desc')->limit(7)->get();
            return response()->json($data);
        }


        $data = $query->orderBy('tanggal', 'desc')->limit(7)->get();

        return response()->json($data);
    }

}
