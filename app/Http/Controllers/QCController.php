<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QC\AfterCooling;
use App\Models\QC\AfterCoolingDetail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class QCController extends Controller
{

    // 🔹 Dashboard untuk Dept Head
    public function dashboardQC()
    {
        if (Session::get('jabatan') == 'dept_head') {
            return view('user.dept_head.dashboard_qc');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    // End Dept Head

    // 🔹 Dashboard untuk Supervisor
    public function dashboardSupervisorQC()
    {
        if (Session::get('jabatan') == 'supervisor' && Session::get('departemen') == 'qc') {
            return view('user.supervisor.dashboard_qc');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    // End Supervisor

    // Dashboard untuk foreman
    public function dashboardForemanQC()
    {
        if (Session::get('jabatan') == 'foreman' && Session::get('departemen') == 'qc') {
            return view('user.foreman.dashboard_qc');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    // End Foreman




    // 🔹 Dashboard untuk Operator
    public function dashboardOperatorQC()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'qc') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.qc.dashboard_qc');
    }

    public function detailAfterCoolingOperatorQC($id)
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'qc') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $data = AfterCooling::with('details')->findOrFail($id);
        return view('user.operator.qc.detail_after_cooling', compact('data'));
    }

    public function listAfterCoolingOperatorQC()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'qc') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.operator.qc.list_after_cooling');
    }





    public function index()
    {
        $data = AfterCooling::withCount('details') // hitung jumlah detail
            ->having('details_count', '<', 3)      // hanya yang kurang dari 3 detail
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($data);
    }

    // 🔹 Simpan Data Baru (Store)
    public function storeData(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'batch' => 'required',
        ]);

        try {
            // Simpan batch baru
            $nama_user = Session::get('username');
            $data = AfterCooling::create([
                'tanggal' => $request->tanggal,
                'batch' => $request->batch,
                'created_by_user' => $nama_user,
            ]);

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showData()
    {
        // $data = AfterCooling::with('details')->get();
        // return response()->json($data);
        $data = AfterCooling::with(['details' => function ($query) {
            $query->orderBy('shift', 'desc'); // Optional: order detail by shift
        }])
            ->orderBy('tanggal', 'desc') // Urutkan berdasarkan tanggal secara descending
            ->get();

        return response()->json($data);
    }

    public function deleteData(Request $request, $id)
    {
        $data = AfterCooling::findOrFail($id);
        $data->details()->delete();
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus!'
        ]);
    }



    public function storeDetail(Request $request, $id)
    {
        $data = AfterCooling::findOrFail($id);
        $request->validate([
            'viscositas' => 'required|numeric',
            'brix' => 'required|numeric',
            'ph' => 'required|numeric',
            'bj' => 'required|numeric',
            'aw' => 'required|numeric',
            'buih' => 'required|numeric',
            'endapan' => 'required',
            'organo' => 'required',
            'warna' => 'required',
            'shift' => 'required|integer|min:1|max:3',
        ]);
        // Cek apakah shift sudah ada
        $existingShift = AfterCoolingDetail::where('id_after_cooling', $data->id)
            ->where('shift', $request->shift)
            ->exists();

        if ($existingShift) {
            return response()->json([
                'message' => 'Sudah ada dalam shift tersebut!',
                'status' => 'error'
            ], 400);
        }

        $dataDetail = AfterCoolingDetail::create([
            'id_after_cooling' => $data->id,
            'viscositas' => $request->viscositas,
            'brix' => $request->brix,
            'ph' => $request->ph,
            'bj' => $request->bj,
            'aw' => $request->aw,
            'buih' => $request->buih,
            'endapan' => $request->endapan,
            'organo' => $request->organo,
            'warna' => $request->warna,
            'shift' => $request->shift,
            'created_by_user' => session('username')
        ]);

        // Cek apakah semua shift (1,2,3) sudah ada
        $totalShifts = AfterCoolingDetail::where('id_after_cooling', $id)->count();

        if ($totalShifts === 3) {
            // Update status batch menjadi completed
            AfterCooling::where('id', $id)->update(['status' => 'completed']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data After Cooling shift ini berhasil ditambahkan!',
            'data' => $dataDetail
        ]);
    }

    public function getDetail($id)
    {
        $shifts = AfterCoolingDetail::where('id_after_cooling', $id)->get();
        return response()->json($shifts);
    }

    public function updateDetail(Request $request, $id_detail)
    {
        $request->validate([
            'viscositas' => 'required|numeric',
            'brix' => 'required|numeric',
            'ph' => 'required|numeric',
            'bj' => 'required|numeric',
            'aw' => 'required|numeric',
            'buih' => 'required|numeric',
            'endapan' => 'required',
            'organo' => 'required',
            'warna' => 'required',
            'shift' => 'required|integer|min:1|max:3',
        ]);

        $detail = AfterCoolingDetail::findOrFail($id_detail);
        $detail->update([
            'viscositas' => $request->viscositas,
            'brix' => $request->brix,
            'ph' => $request->ph,
            'bj' => $request->bj,
            'aw' => $request->aw,
            'buih' => $request->buih,
            'endapan' => $request->endapan,
            'organo' => $request->organo,
            'warna' => $request->warna,
            'shift' => $request->shift,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data detail berhasil diupdate!',
            'data' => $detail
        ]);
    }

    public function deleteDetail($id_detail)
    {
        $detail = AfterCoolingDetail::findOrFail($id_detail);
        $detail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Detail berhasil dihapus!'
        ]);
    }

    public function AfterCoolingCompleted()
    {
        $completedCount = AfterCooling::where('status', 'completed')->count();
        $notCompletedCount = AfterCooling::where('status', NULL)->count();

        return response()->json([
            'completed' => $completedCount,
            'not_completed' => $notCompletedCount
        ]);
    }



    public function olahAfterCooling()
    {
        $data = AfterCooling::with('details')->get();
        $hasil = [];

        foreach ($data as $ac) {
            $total = $ac->details->count();

            $bjUnder = $ac->details->where('bj', '<', 1.39)->count();
            $bjOver = $ac->details->where('bj', '>', 1.41)->count();
            $bjOkPercent = ($total > 0) ? round(($total - ($bjUnder + $bjOver)) / $total * 100, 2) : 0;

            $brixUnder = $ac->details->where('brix', '<', 77)->count();
            $brixOkPercent = ($total > 0) ? round(($total - $brixUnder) / $total * 100, 2) : 0;

            $phUnder = $ac->details->where('ph', '<', 4.3)->count();
            $phOver = $ac->details->where('ph', '>', 5)->count();
            $phOkPercent = ($total > 0) ? round(($total - ($phUnder + $phOver)) / $total * 100, 2) : 0;

            $viscoUnder = $ac->details->where('viscositas', '<', 17)->count();
            $viscoOver = $ac->details->where('viscositas', '>', 28)->count();
            $viscoOkPercent = ($total > 0) ? round(($total - ($viscoUnder + $viscoOver)) / $total * 100, 2) : 0;

            $awOver = $ac->details->where('aw', '>', 0.70)->count();
            $awOkPercent = ($total > 0) ? round(($total - $awOver) / $total * 100, 2) : 0;
            $awPresOverPercent = ($total > 0) ? round($awOver / $total * 100, 2) : 0;

            $buihOver = $ac->details->where('buih', '>', 0.5)->count();
            $buihOkPercent = ($total > 0) ? round(($total - $buihOver) / $total * 100, 2) : 0;

            $endapanNotStandar = $ac->details->filter(fn ($d) => strtolower(trim($d->endapan)) !== '<0,1')->count();
            $endapanOkPercent = ($total > 0) ? round(($total - $endapanNotStandar) / $total * 100, 2) : 0;

            $organoNotStandar = $ac->details->filter(fn ($d) => strtolower(trim($d->organo)) !== 'standar')->count();
            $organoOkPercent = ($total > 0) ? round(($total - $organoNotStandar) / $total * 100, 2) : 0;

            // Ambil 3 data detail
            $detailSample = $ac->details->take(3)->map(function ($item) {
                return [
                    'id' => $item->id,
                    'created_at' => $item->created_at,
                    'shift' => $item->shift,
                    'user' => $item->user,
                    'bj' => $item->bj,
                    'brix' => $item->brix,
                    'ph' => $item->ph,
                    'viscositas' => $item->viscositas,
                    'aw' => $item->aw,
                    'buih' => $item->buih,
                    'endapan' => $item->endapan,
                    'organo' => $item->organo,
                    'warna' => $item->warna,
                ];
            });

            $hasil[] = [
                'id' => $ac->id,
                'batch' => $ac->batch,
                'tanggal' => $ac->tanggal,
                'created_by_user' => $ac->created_by_user,
                'status' => $ac->status,
                'jumlah_data' => $total,

                // Persentase OK
                'bj_under' => $bjUnder,
                'bj_over' => $bjOver,
                'bj_ok_percent' => $bjOkPercent,

                'brix_under' => $brixUnder,
                'brix_ok_percent' => $brixOkPercent,

                'ph_under' => $phUnder,
                'ph_over' => $phOver,
                'ph_ok_percent' => $phOkPercent,

                'visco_under' => $viscoUnder,
                'visco_over' => $viscoOver,
                'visco_ok_percent' => $viscoOkPercent,

                'aw_over' => $awOver,
                'aw_ok_percent' => $awOkPercent,
                'aw_pres_over_percent' => $awPresOverPercent,

                'buih_over' => $buihOver,
                'buih_ok_percent' => $buihOkPercent,

                'endapan_not_standar' => $endapanNotStandar,
                'endapan_ok_percent' => $endapanOkPercent,

                'organo_not_standar' => $organoNotStandar,
                'organo_ok_percent' => $organoOkPercent,

                // Tambahan: sample 3 data detail
                'detail_sample' => $detailSample,
            ];
        }

        return response()->json($hasil);
    }


    //statistik
    public function statistik(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $query = DB::table('after_cooling_detail')
            ->join('after_cooling', 'after_cooling.id', '=', 'after_cooling_detail.id_after_cooling')
            ->select(
                DB::raw('MIN(bj) as bj_min'),
                DB::raw('MAX(bj) as bj_max'),
                DB::raw('AVG(bj) as bj_avg'),
                DB::raw('STDDEV_POP(bj) as bj_std'),

                DB::raw('MIN(brix) as brix_min'),
                DB::raw('MAX(brix) as brix_max'),
                DB::raw('AVG(brix) as brix_avg'),
                DB::raw('STDDEV_POP(brix) as brix_std'),

                DB::raw('MIN(ph) as ph_min'),
                DB::raw('MAX(ph) as ph_max'),
                DB::raw('AVG(ph) as ph_avg'),
                DB::raw('STDDEV_POP(ph) as ph_std'),

                DB::raw('MIN(viscositas) as visco_min'),
                DB::raw('MAX(viscositas) as visco_max'),
                DB::raw('AVG(viscositas) as visco_avg'),
                DB::raw('STDDEV_POP(viscositas) as visco_std'),

                DB::raw('MIN(aw) as aw_min'),
                DB::raw('MAX(aw) as aw_max'),
                DB::raw('AVG(aw) as aw_avg'),
                DB::raw('STDDEV_POP(aw) as aw_std'),

                DB::raw('MIN(buih) as buih_min'),
                DB::raw('MAX(buih) as buih_max'),
                DB::raw('AVG(buih) as buih_avg'),
                DB::raw('STDDEV_POP(buih) as buih_std'),

                // DB::raw('MIN(endapan) as endapan_min'),
                // DB::raw('MAX(endapan) as endapan_max'),
                // DB::raw('AVG(endapan) as endapan_avg'),
                // DB::raw('STDDEV_POP(endapan) as endapan_std')
            );

        // if ($start && $end) {
        //     $query->whereBetween('aftercoolings.tanggal', [$start, $end]);
        // }

        $statistik = $query->first();

        return response()->json($statistik);
    }


    // chart grafik line 
    // public function getChartData()
    // {
    //     $data = AfterCoolingDetail::select('*')->orderBy('id_after_cooling', 'DESC')->get();
    //     return response()->json($data);
    // }

    public function getChartData(Request $request)
    {
        $filter = $request->get('filter');
        $startDate = null;
        $endDate = null;

        if ($filter === 'today') {
            $startDate = now()->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($filter === 'date') {
            $startDate = Carbon::parse($request->get('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->get('start_date'))->endOfDay();
        } elseif ($filter === 'range') {
            $startDate = Carbon::parse($request->get('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->get('end_date'))->endOfDay();
        }

        $query = AfterCoolingDetail::query();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $data = $query->orderBy('created_at', 'ASC')->get();

        return response()->json($data);
    }
}
