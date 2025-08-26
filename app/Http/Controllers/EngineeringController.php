<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\eng\PemakaianAirModel;
use App\Models\eng\PemakaianListrikModel;
use App\Models\eng\PemakaianChemicalModel;
use Illuminate\Support\Carbon;
use App\Services\TelegramService;
use App\Models\Boiler\ReadSensors_Boiler;
use App\Models\eng\AirArea;
use App\Models\eng\ChemicalType;
use App\Models\eng\ChemicalArea;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
    public function DataUtilitySupervisor()
    {
        if (Session::get('jabatan') == 'supervisor') {
            return view('user.supervisor.eng.data_utility');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    public function DashboardUtilitySupervisor()
    {
        if (Session::get('jabatan') == 'supervisor' || Session::get('jabatan') == 'dept_head') {
            return view('user.supervisor.eng.dashboard_utility');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    ////End View Supervisor ///////////

    //foreman
    public function dashboardForeman()
    {
        if (Session::get('jabatan') == 'foreman') {
            return view('user.foreman.eng.dashboard_utility');
        }
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    public function DataUtilityForeman()
    {
        if (Session::get('jabatan') !== 'foreman' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.foreman.eng.data_utility');
    }
    public function formUtilityForeman()
    {
        if (Session::get('jabatan') !== 'operator' && Session::get('departemen') !== 'engineering') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.foreman.eng.form_utility');
    }
    ////End View Foreman ///////////

    //operator
    // 🔹 Form untuk Operator


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

    public function storeAir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'pemakaian_liter_awal' => 'required',
            'pemakaian_liter_akhir' => 'required',
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


    // buatkan crud untuk pemakaian chemical api nya


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
            'running_hour' => 'nullable|array',
        ]);

        $tanggal = $request->input('tanggal');
        $shift = $request->input('shift');
        $chemical_area = $request->input('chemical_area');
        $keterangan = $request->input('keterangan');
        $jenisPemakaian = $request->input('jenis_pemakaian');
        $jumlahPemakaian = $request->input('jumlah_pemakaian');
        $running_hour = $request->input('running_hour');

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
                'running_hour' => $running_hour[$index],
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

        $data = PemakaianAirModel::orderBy('tanggal', 'desc')->get();

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
        $data = PemakaianChemicalModel::orderBy('tanggal', 'desc')->get();

        // Mapping satuan berdasarkan nama chemical yang dinormalisasi
        $satuanMap = ChemicalType::pluck('satuan', 'nama_chemical')->mapWithKeys(function ($satuan, $nama) {
            $key = strtolower(preg_replace('/[^a-z0-9]/', '', $nama));
            return [$key => $satuan];
        });

        $grouped = $data->groupBy(fn ($item) => date('Y-m-d', strtotime($item->tanggal)));
        $result = [];

        foreach ($grouped as $tanggal => $items) {
            $jenisGrouped = $items->groupBy('jenis_pemakaian');
            $jenisData = [];

            foreach ($jenisGrouped as $jenis => $entries) {
                $lookupKey = strtolower(preg_replace('/[^a-z0-9]/', '', $jenis));
                $satuanAsli = $satuanMap[$lookupKey] ?? null;

                // Detail per shift
                $shifts = $entries->map(function ($entry) use ($satuanAsli) {
                    $nilai = $entry->nilai_pemakaian;
                    $formatted = is_null($nilai) ? '-' : "{$nilai}" . ($satuanAsli ? " {$satuanAsli}" : '');
                    return [
                        'shift' => $entry->shift,
                        'nilai_pemakaian' => $formatted,
                        'area' => $entry->chemical_area,
                        'operator' => $entry->operator,
                        'notes' => $entry->notes,
                        'running_hour' => $entry->running_hour,
                        'created_at' => $entry->created_at,
                        'updated_at' => $entry->updated_at,
                    ];
                })->sortBy(fn ($s) => preg_replace('/\D/', '', strtolower($s['shift'])))->values();

                // Hitung total pemakaian dan tentukan satuannya
                $totalPemakaian = 0;
                $hasCustomRumus = false;

                foreach ($entries as $entry) {
                    $nilai = is_numeric($entry->nilai_pemakaian)
                        ? floatval($entry->nilai_pemakaian)
                        : floatval(preg_replace('/[^\d.]+/', '', $entry->nilai_pemakaian));
                    $rh = $entry->running_hour ?? 1;
                    $jenisAsli = trim($entry->jenis_pemakaian);

                    switch ($jenisAsli) {
                        case 'PAC powder 1':
                            $totalPemakaian += $rh * ($nilai * 60 * 7.6 / 100) / 1000;
                            $hasCustomRumus = true;
                            break;
                        case 'PAC powder 2':
                            $totalPemakaian += $rh * ($nilai * 60 * 12.5 / 100) / 1000;
                            $hasCustomRumus = true;
                            break;
                        case 'BE-100':
                            $totalPemakaian += $rh * ($nilai * 60 * 12.5 / 100) / 1000;
                            $hasCustomRumus = true;
                            break;
                        case 'C-204':
                            $totalPemakaian += $rh * ($nilai * 60 * 1 / 100) / 1000;
                            $hasCustomRumus = true;
                            break;
                        case 'C-9040 step 1':
                            $totalPemakaian += $rh * ($nilai * 60 * 0.11 / 100) / 1000;
                            $hasCustomRumus = true;
                            break;
                        case 'C-9040 step 2':
                            $totalPemakaian += $rh * ($nilai * 60 * 0.35 / 100) / 1000;
                            $hasCustomRumus = true;
                            break;
                        case 'Denfloc 260 PA':
                            $totalPemakaian += ($rh * ($nilai / 1000 * 60) * 480) / 1000 / 1000 / 1000;
                            $hasCustomRumus = true;
                            break;
                        case 'NaOH':
                            $totalPemakaian += $rh * ($nilai / 1000 * 60) * 1.5;
                            $hasCustomRumus = true;
                            break;
                        default:
                            $totalPemakaian += $nilai;
                            break;
                    }
                }

                $finalSatuan = $hasCustomRumus ? 'kg/hari' : ($satuanAsli ?? null);

                $jenisData[] = [
                    'jenis_pemakaian' => $jenis,
                    'total_pemakaian' => round($totalPemakaian, 3),
                    'satuan' => $finalSatuan,
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

        // Group by tanggal (YYYY-MM-DD)
        $grouped = $data->groupBy(function ($item) {
            return date('Y-m-d', strtotime($item->waktu));
        });

        $sortedDates = $grouped->keys()->sort()->values();
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

            // Ambil parameter-parameter
            $parameters = ['volt', 'a', 'kw', 'mwh', 'cos'];
            foreach ($parameters as $param) {
                $pivot[$param] = [];
                foreach ($panels as $panel) {
                    $panelItem = $items->firstWhere('panel_type', $panel);
                    $pivot[$param][$panel] = $panelItem?->$param ?? null;
                }
            }

            // Hitung usage berdasarkan mwh selisih antar hari
            if ($index < count($sortedDates) - 1) {
                $nextTanggal = $sortedDates[$index + 1];
                $nextItems = $grouped[$nextTanggal];

                foreach ($panels as $panel) {
                    $currentMwh = $items->firstWhere('panel_type', $panel)?->mwh;
                    $nextMwh = $nextItems->firstWhere('panel_type', $panel)?->mwh;

                    if (!is_null($currentMwh) && !is_null($nextMwh)) {
                        $usage[$panel] = $nextMwh - $currentMwh;
                    } else {
                        $usage[$panel] = null;
                    }
                }
            } else {
                // Tanggal terakhir: usage belum bisa dihitung
                foreach ($panels as $panel) {
                    $usage[$panel] = null;
                }
            }

            $result[] = [
                'tanggal' => $tanggal,
                'operator' => $operators,
                'panels' => $panels,
                'rows' => $pivot,
                'usage' => $usage,
            ];
        }

        return response()->json(array_reverse($result));
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


    //export excel
    public function exportPemakaianListrikSpreadsheet(Request $request)
    {
        $month = $request->input('bulan'); // format: 2025-06
        if (!$month) {
            return response()->json(['message' => 'Parameter bulan diperlukan (format: YYYY-MM)'], 400);
        }

        $defaultPanelOrder = ['MDP', 'SDP1', 'SDP2', 'SDP3', 'SDP4', 'SDP5', 'SDP6', 'SDP7', 'SDP8', 'SDP9', 'SDP10', 'SDP11', 'SDP12', 'SDP13', 'SDP14'];

        $data = PemakaianListrikModel::where('waktu', 'like', "$month%")->orderBy('waktu')->get();

        $grouped = $data->groupBy(fn ($item) => date('Y-m-d', strtotime($item->waktu)));
        $sortedDates = $grouped->keys()->sort()->values();
        $result = [];

        foreach ($sortedDates as $index => $tanggal) {
            $items = $grouped[$tanggal];
            $pivot = [];
            $usage = [];
            $operators = [];

            $availablePanels = $items->pluck('panel_type')->unique()->values()->all();
            $panels = array_values(array_intersect($defaultPanelOrder, $availablePanels));

            foreach ($panels as $panel) {
                $panelItem = $items->firstWhere('panel_type', $panel);
                $operators[$panel] = $panelItem?->operator;
            }

            $parameters = ['volt', 'a', 'kw', 'mwh', 'cos'];
            foreach ($parameters as $param) {
                $pivot[$param] = [];
                foreach ($panels as $panel) {
                    $panelItem = $items->firstWhere('panel_type', $panel);
                    $pivot[$param][$panel] = $panelItem?->$param ?? null;
                }
            }

            if ($index < count($sortedDates) - 1) {
                $nextItems = $grouped[$sortedDates[$index + 1]];
                foreach ($panels as $panel) {
                    $curr = $items->firstWhere('panel_type', $panel)?->mwh;
                    $next = $nextItems->firstWhere('panel_type', $panel)?->mwh;
                    $usage[$panel] = (!is_null($curr) && !is_null($next)) ? $next - $curr : null;
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
                'usage' => $usage,
            ];
        }

        // Generate Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $rowIndex = 1;

        foreach ($result as $day) {
            $panels = $day['panels'];
            $tanggal = $day['tanggal'];

            $sheet->setCellValue("A{$rowIndex}", 'Tanggal');
            $sheet->setCellValue("B{$rowIndex}", 'Parameter');
            $col = 'C';
            foreach ($panels as $panel) {
                $sheet->setCellValue("{$col}{$rowIndex}", $panel);
                $col++;
            }
            $rowIndex++;

            $params = [
                'Operator' => $day['operator'],
                'Volt'     => $day['rows']['volt'],
                'A'        => $day['rows']['a'],
                'kW'       => $day['rows']['kw'],
                'MWh'      => $day['rows']['mwh'],
                'Cos'      => $day['rows']['cos'],
                'Usage'    => $day['usage'],
            ];

            foreach ($params as $label => $dataRow) {
                $sheet->setCellValue("A{$rowIndex}", $tanggal);
                $sheet->setCellValue("B{$rowIndex}", $label);
                $col = 'C';
                foreach ($panels as $panel) {
                    $sheet->setCellValue("{$col}{$rowIndex}", $dataRow[$panel] ?? '');
                    $col++;
                }
                $tanggal = ''; // hanya tampil di baris pertama
                $rowIndex++;
            }

            $rowIndex++; // spasi antar tanggal
        }

        $fileName = 'Pemakaian-Listrik-' . $month . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $tempPath = tempnam(sys_get_temp_dir(), 'export-');
        $writer->save($tempPath);

        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }

    public function exportPemakaianAirSpreadsheet(Request $request)
    {
        $month = $request->input('bulan');
        if (!$month) {
            return response()->json(['message' => 'Parameter bulan diperlukan (format: YYYY-MM)'], 400);
        }

        $startDate = Carbon::create($month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        // Kategori sesuai template Excel
        $kategori = [
            'Outlet Storage WS',
            'Outlet Storage RO Reject',
            'Outlet Fresh Water 1',
            'Outlet Fresh Water 2',
            'Sumur 1',
            'Sumur 2',
            'Sumur 4',
            'Sumur 5',
            'PDAM',
            'CT RO',
            'CT WS',
            'Greenbelt',
        ];

        // Load template
        $templatePath = storage_path('app/templates/laporan_air_utility.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($kategori as $index => $jenis) {
            $data = PemakaianAirModel::where('jenis_pemakaian', $jenis)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->orderBy('tanggal')
                ->get()
                ->keyBy(function ($item) {
                    return Carbon::parse($item->tanggal)->day;
                });

            $startColumn = 2 + ($index * 3); // C = 2, F = 5, dst...
            $row = 5;

            for ($day = 1; $day <= $endDate->day; $day++) {
                $entry = $data->get($day);
                if ($entry) {
                    $colAwal = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startColumn);
                    $colAkhir = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startColumn + 1);
                    $colSelisih = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startColumn + 2);

                    $sheet->setCellValue("{$colAwal}{$row}", $entry->pemakaian_awal);
                    $sheet->setCellValue("{$colAkhir}{$row}", $entry->pemakaian_akhir);
                    $sheet->setCellValue("{$colSelisih}{$row}", $entry->pemakaian_akhir - $entry->pemakaian_awal);
                }
                $row++;
            }
        }

        // Simpan hasil export
        $filename = "Laporan_Air_Utility_{$month}.xlsx";
        $outputPath = storage_path("app/exports/{$filename}");
        $writer = new Xlsx($spreadsheet);
        $writer->save($outputPath);

        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    public function exportPemakaianChemicalSpreadsheet(Request $request)
    {
        $month = $request->input('bulan');
        if (!$month) {
            return response()->json(['message' => 'Parameter bulan diperlukan (format: YYYY-MM)'], 400);
        }

        $data = PemakaianChemicalModel::where('tanggal', 'like', "$month%")
            ->orderBy('tanggal')
            ->get();

        // Kelompokkan data berdasarkan tanggal, shift, dan area
        $grouped = $data->groupBy(fn ($item) => $item->tanggal . '|' . $item->shift . '|' . $item->chemical_area);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $rowIndex = 1;

        // Header
        $headers = ['Tanggal', 'Jenis Pemakaian', 'Shift', 'Nilai Pemakaian', 'Area', 'Operator', 'Notes', 'Running Hour'];
        foreach ($headers as $col => $label) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue("{$columnLetter}{$rowIndex}", $label);
        }
        $rowIndex++;

        foreach ($grouped as $key => $entries) {
            [$tanggal, $shift, $area] = explode('|', $key);
            $startMergeRow = $rowIndex;
            $mergeLength = count($entries);

            foreach ($entries as $entry) {
                $sheet->setCellValue("A{$rowIndex}", $tanggal);
                $sheet->setCellValue("B{$rowIndex}", $entry->jenis_pemakaian);
                $sheet->setCellValue("C{$rowIndex}", $shift);
                $sheet->setCellValue("D{$rowIndex}", $entry->nilai_pemakaian);
                $sheet->setCellValue("E{$rowIndex}", $area);
                $sheet->setCellValue("F{$rowIndex}", $entry->operator);
                $sheet->setCellValue("G{$rowIndex}", $entry->notes);
                $sheet->setCellValue("H{$rowIndex}", $entry->running_hour);
                $rowIndex++;
            }

            // Merge cells hanya jika lebih dari satu baris
            if ($mergeLength > 1) {
                $sheet->mergeCells("A{$startMergeRow}:A" . ($rowIndex - 1)); // Tanggal
                $sheet->mergeCells("C{$startMergeRow}:C" . ($rowIndex - 1)); // Shift
                $sheet->mergeCells("E{$startMergeRow}:E" . ($rowIndex - 1)); // Area
            }
        }

        $fileName = "Pemakaian-Chemical-{$month}.xlsx";
        $writer = new Xlsx($spreadsheet);
        $tempPath = tempnam(sys_get_temp_dir(), 'export-chemical-');
        $writer->save($tempPath);

        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }


    public function getTrendPemakaianAir(Request $request)
    {
        $tanggal = $request->query('tanggal'); // format: YYYY-MM-DD
        $bulan   = $request->query('bulan');   // format: YYYY-MM

        $query = PemakaianAirModel::query();

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        } elseif ($bulan) {
            $query->whereMonth('tanggal', substr($bulan, 5, 2))
                ->whereYear('tanggal', substr($bulan, 0, 4));
        } else {
            // 🔁 Default: seluruh data untuk bulan ini
            $query->whereMonth('tanggal', now()->format('m'))
                ->whereYear('tanggal', now()->format('Y'));
        }

        $data = $query->select(
            'tanggal',
            'jenis_pemakaian',
            DB::raw('SUM(pemakaian_akhir - pemakaian_awal) as total_pemakaian')
        )
            ->groupBy('tanggal', 'jenis_pemakaian')
            ->orderBy('tanggal')
            ->get()
            ->groupBy('jenis_pemakaian');

        $result = [];
        foreach ($data as $jenis => $records) {
            $result[] = [
                'name' => $jenis,
                'data' => $records->map(fn ($r) => [
                    'x' => $r->tanggal,
                    'y' => round($r->total_pemakaian, 2)
                ])->values()
            ];
        }

        return response()->json($result);
    }
    public function getTrendPemakaianListrik(Request $request)
    {
        $tanggal = $request->query('tanggal'); // format: YYYY-MM-DD
        $bulan   = $request->query('bulan');   // format: YYYY-MM

        $query = PemakaianListrikModel::query();

        if ($tanggal) {
            $query->whereDate('waktu', $tanggal);
        } elseif ($bulan) {
            $query->whereYear('waktu', substr($bulan, 0, 4))
                ->whereMonth('waktu', substr($bulan, 5, 2));
        } else {
            $query->whereYear('waktu', now()->format('Y'))
                ->whereMonth('waktu', now()->format('m'));
        }

        // Ambil data per panel_type dan tanggal, lalu hitung delta mwh antar hari berikutnya
        $data = $query->select('panel_type', 'waktu', 'mwh')
            ->orderBy('panel_type')
            ->orderBy('waktu')
            ->get()
            ->groupBy('panel_type');

        $result = [];

        foreach ($data as $panel => $records) {
            $recordsByDate = $records->groupBy(fn ($r) => \Carbon\Carbon::parse($r->waktu)->format('Y-m-d'));
            $dates = $recordsByDate->keys();

            $series = [];
            for ($i = 0; $i < count($dates) - 1; $i++) {
                $d1 = $dates[$i];
                $d2 = $dates[$i + 1];

                $mwh1 = optional($recordsByDate[$d1]->first())->mwh;
                $mwh2 = optional($recordsByDate[$d2]->first())->mwh;

                if (!is_null($mwh1) && !is_null($mwh2) && $mwh2 >= $mwh1) {
                    $usage = round($mwh2 - $mwh1, 3);
                    $series[] = [
                        'x' => $d1,
                        'y' => $usage
                    ];
                }
            }

            if (!empty($series)) {
                $result[] = [
                    'name' => $panel,
                    'data' => $series
                ];
            }
        }

        return response()->json($result);
    }

    public function getTrendPemakaianChemical(Request $request)
    {
        $tanggal = $request->query('tanggal'); // format: YYYY-MM-DD
        $bulan   = $request->query('bulan');   // format: YYYY-MM

        $query = PemakaianChemicalModel::query()
            ->join('chemical_types', 'pemakaian_chemical.jenis_pemakaian', '=', 'chemical_types.nama_chemical');

        if ($tanggal) {
            $query->whereDate('pemakaian_chemical.tanggal', $tanggal);
        } elseif ($bulan) {
            $query->whereYear('pemakaian_chemical.tanggal', substr($bulan, 0, 4))
                ->whereMonth('pemakaian_chemical.tanggal', substr($bulan, 5, 2));
        } else {
            $query->whereYear('pemakaian_chemical.tanggal', now()->format('Y'))
                ->whereMonth('pemakaian_chemical.tanggal', now()->format('m'));
        }

        $data = $query->select(
            'pemakaian_chemical.tanggal',
            'pemakaian_chemical.jenis_pemakaian',
            'chemical_types.satuan',
            DB::raw('SUM(nilai_pemakaian) as total_pemakaian')
        )
            ->groupBy('pemakaian_chemical.tanggal', 'pemakaian_chemical.jenis_pemakaian', 'chemical_types.satuan')
            ->orderBy('pemakaian_chemical.tanggal')
            ->get()
            ->groupBy('jenis_pemakaian');

        $result = [];

        foreach ($data as $jenis => $records) {
            $satuan = $records->first()->satuan ?? '-';
            $result[] = [
                'name' => "$jenis ($satuan)",
                'data' => $records->map(fn ($r) => [
                    'x' => $r->tanggal,
                    'y' => round($r->total_pemakaian, 2)
                ])->values()
            ];
        }

        return response()->json($result);
    }

    public function getTopJenisPemakaianAir(Request $request)
    {
        $start = $request->query('start_date');
        $end = $request->query('end_date');

        // Default ke bulan sekarang
        if (!$start || !$end) {
            $start = now()->startOfMonth()->format('Y-m-d');
            $end = now()->endOfMonth()->format('Y-m-d');
        }

        $excludedSources = ['PDAM', 'Sumur 1', 'Sumur 2', 'Sumur 4', 'Sumur 5'];
        $data = PemakaianAirModel::query()
            ->select('jenis_pemakaian', DB::raw('SUM(pemakaian_akhir - pemakaian_awal) AS total_pemakaian'))
            ->whereBetween('tanggal', [$start, $end])
            ->whereNotIn('jenis_pemakaian', $excludedSources)
            ->groupBy('jenis_pemakaian')
            ->orderByDesc('total_pemakaian')
            ->get()
            ->map(function ($item) use ($start, $end) {
                return [
                    'jenis_pemakaian' => $item->jenis_pemakaian,
                    'total_pemakaian' => $item->total_pemakaian,
                    'start_date'      => $start,
                    'end_date'        => $end,
                ];
            });

        return response()->json($data);
    }
    public function getTopJenisPemakaianAirRaw(Request $request)
    {
        $start = $request->query('start_date');
        $end = $request->query('end_date');

        // Default ke bulan sekarang
        if (!$start || !$end) {
            $start = now()->startOfMonth()->format('Y-m-d');
            $end = now()->endOfMonth()->format('Y-m-d');
        }
        $excludedSources = ['PDAM', 'Sumur 1', 'Sumur 2', 'Sumur 4', 'Sumur 5'];
        $data = PemakaianAirModel::query()
            ->select('jenis_pemakaian', DB::raw('SUM(pemakaian_akhir - pemakaian_awal) AS total_pemakaian'))
            ->whereBetween('tanggal', [$start, $end])
            ->whereIn('jenis_pemakaian', $excludedSources)
            ->groupBy('jenis_pemakaian')
            ->orderByDesc('total_pemakaian')
            ->get()
            ->map(function ($item) use ($start, $end) {
                return [
                    'jenis_pemakaian' => $item->jenis_pemakaian,
                    'total_pemakaian' => $item->total_pemakaian,
                    'start_date'      => $start,
                    'end_date'        => $end,
                ];
            });

        return response()->json($data);
    }

    public function getTopJenisPemakaianListrik(Request $request)
    {
        $start = $request->query('start_date');
        $end = $request->query('end_date');

        if (!$start || !$end) {
            $start = now()->startOfMonth()->format('Y-m-d');
            $end = now()->endOfMonth()->format('Y-m-d');
        }

        $panelTypes = PemakaianListrikModel::whereBetween('waktu', [$start, $end])
            ->groupBy('panel_type')
            ->pluck('panel_type');

        $usages = [];

        foreach ($panelTypes as $panel) {
            $data = PemakaianListrikModel::where('panel_type', $panel)
                ->whereBetween('waktu', [$start, $end])
                ->orderBy('waktu')
                ->pluck('mwh')
                ->values();

            $totalUsage = 0;
            for ($i = 0; $i < $data->count() - 1; $i++) {
                $delta = $data[$i + 1] - $data[$i];
                if ($delta >= 0) $totalUsage += $delta;
            }

            $usages[] = [
                'panel_type'   => $panel,
                'total_usage'  => round($totalUsage, 2),
                'start_date'   => $start,
                'end_date'     => $end
            ];
        }

        return response()->json(collect($usages)->sortByDesc('total_usage')->values());
    }

    public function getTopJenisPemakaianChemical(Request $request)
    {
        $start = $request->query('start_date');
        $end = $request->query('end_date');

        if (!$start || !$end) {
            $start = now()->startOfMonth()->format('Y-m-d');
            $end = now()->endOfMonth()->format('Y-m-d');
        }

        $data = PemakaianChemicalModel::whereBetween('tanggal', [$start, $end])->get();

        // Normalisasi satuan dari chemical type
        $satuanMap = ChemicalType::pluck('satuan', 'nama_chemical')->mapWithKeys(function ($satuan, $nama) {
            $key = strtolower(preg_replace('/[^a-z0-9]/', '', $nama));
            return [$key => $satuan];
        });

        $grouped = $data->groupBy('jenis_pemakaian');
        $result = [];

        foreach ($grouped as $jenis => $entries) {
            $totalPemakaian = 0;
            $hasCustomRumus = false;
            $lookupKey = strtolower(preg_replace('/[^a-z0-9]/', '', $jenis));
            $satuanAsli = $satuanMap[$lookupKey] ?? null;

            foreach ($entries as $entry) {
                $nilai = is_numeric($entry->nilai_pemakaian)
                    ? floatval($entry->nilai_pemakaian)
                    : floatval(preg_replace('/[^\d.]+/', '', $entry->nilai_pemakaian));
                $rh = $entry->running_hour ?? 1;
                $jenisAsli = trim($entry->jenis_pemakaian);

                switch ($jenisAsli) {
                    case 'PAC powder 1':
                        $totalPemakaian += $rh * ($nilai * 60 * 7.6 / 100) / 1000;
                        $hasCustomRumus = true;
                        break;
                    case 'PAC powder 2':
                        $totalPemakaian += $rh * ($nilai * 60 * 12.5 / 100) / 1000;
                        $hasCustomRumus = true;
                        break;
                    case 'BE-100':
                        $totalPemakaian += $rh * ($nilai * 60 * 12.5 / 100) / 1000;
                        $hasCustomRumus = true;
                        break;
                    case 'C-204':
                        $totalPemakaian += $rh * ($nilai * 60 * 1 / 100) / 1000;
                        $hasCustomRumus = true;
                        break;
                    case 'C-9040 step 1':
                        $totalPemakaian += $rh * ($nilai * 60 * 0.11 / 100) / 1000;
                        $hasCustomRumus = true;
                        break;
                    case 'C-9040 step 2':
                        $totalPemakaian += $rh * ($nilai * 60 * 0.35 / 100) / 1000;
                        $hasCustomRumus = true;
                        break;
                    case 'Denfloc 260 PA':
                        $totalPemakaian += ($rh * ($nilai / 1000 * 60) * 480) / 1000 / 1000 / 1000;
                        $hasCustomRumus = true;
                        break;
                    case 'NaOH':
                        $totalPemakaian += $rh * ($nilai / 1000 * 60) * 1.5;
                        $hasCustomRumus = true;
                        break;
                    default:
                        $totalPemakaian += $nilai;
                        break;
                }
            }


            $result[] = [
                'jenis_pemakaian' => $jenis,
                'total_pemakaian' => round($totalPemakaian, 3),
                'satuan'          => $hasCustomRumus ? 'kg/hari' : ($satuanAsli ?? '-'),
                'start_date'      => $start,
                'end_date'        => $end
            ];
        }

        return response()->json(collect($result)->sortByDesc('total_pemakaian')->values());
    }


    public function getTopOperatorPemakaianAir(Request $request)
    {
        $bulan = $request->query('bulan'); // contoh: 2025-06

        $tahun = $bulan ? substr($bulan, 0, 4) : now()->format('Y');
        $bulanAngka = $bulan ? substr($bulan, 5, 2) : now()->format('m');

        $data = PemakaianAirModel::query()
            ->select(
                'created_by',
                DB::raw('COUNT(*) as jumlah_pengisian')
            )
            ->whereMonth('tanggal', $bulanAngka)
            ->whereYear('tanggal', $tahun)
            ->groupBy('created_by')
            ->orderByDesc('jumlah_pengisian')
            // ->limit(5)
            ->get();

        return response()->json($data);
    }

    public function getTopOperatorPemakaianListrik(Request $request)
    {
        $bulan = $request->query('bulan'); // contoh: 2025-06

        $tahun = $bulan ? substr($bulan, 0, 4) : now()->format('Y');
        $bulanAngka = $bulan ? substr($bulan, 5, 2) : now()->format('m');

        $data = PemakaianListrikModel::query()
            ->select(
                'operator',
                DB::raw('COUNT(*) as jumlah_pengisian')
            )
            ->whereMonth('waktu', $bulanAngka)
            ->whereYear('waktu', $tahun)
            ->groupBy('operator')
            ->orderByDesc('jumlah_pengisian')
            // ->limit(5)
            ->get();

        return response()->json($data);
    }

    public function getTopOperatorPemakaianChemical(Request $request)
    {
        $bulan = $request->query('bulan'); // contoh: 2025-06

        $tahun = $bulan ? substr($bulan, 0, 4) : now()->format('Y');
        $bulanAngka = $bulan ? substr($bulan, 5, 2) : now()->format('m');

        $data = PemakaianChemicalModel::query()
            ->select(
                'operator',
                DB::raw('COUNT(*) as jumlah_pengisian')
            )
            ->whereMonth('tanggal', $bulanAngka)
            ->whereYear('tanggal', $tahun)
            ->groupBy('operator')
            ->orderByDesc('jumlah_pengisian')
            ->limit(5)
            ->get();

        return response()->json($data);
    }

    public function updateListrik(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'panel_type' => 'required|string',
            'volt' => 'nullable|numeric',
            'a' => 'nullable|numeric',
            'kw' => 'nullable|numeric',
            'mwh' => 'nullable|numeric',
            'cos' => 'nullable|numeric',
        ]);

        $data = PemakaianListrikModel::whereDate('waktu', $request->tanggal)
            ->where('panel_type', $request->panel_type)
            ->first();

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $data->update([
            'volt' => $request->volt,
            'a' => $request->a,
            'kw' => $request->kw,
            'mwh' => $request->mwh,
            'cos' => $request->cos,
        ]);

        return response()->json(['message' => 'Data berhasil diperbarui.']);
    }

    public function updateAir(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_pemakaian' => 'required|string',
            'pemakaian_awal' => 'required|numeric',
            'pemakaian_akhir' => 'required|numeric',
            'created_by' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $air = PemakaianAirModel::where('id', $request->id)
            ->first();

        if (!$air) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $air->update([
            'tanggal' => $request->tanggal,
            'jenis_pemakaian' => $request->jenis_pemakaian,
            'pemakaian_awal' => $request->pemakaian_awal,
            'pemakaian_akhir' => $request->pemakaian_akhir,
            'notes' => $request->notes,
        ]);

        return response()->json(['message' => 'Data Air berhasil diperbarui.']);
    }

    public function updateChemical(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_pemakaian' => 'required|string',
            'shift' => 'required|string',
            'nilai_pemakaian' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        $data = PemakaianChemicalModel::whereDate('tanggal', $request->tanggal)
            ->where('jenis_pemakaian', $request->jenis_pemakaian)
            ->where('shift', $request->shift)
            ->first();

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $data->update([
            'nilai_pemakaian' => $request->nilai_pemakaian,
            'jenis_pemakaian' => $request->jenis_pemakaian,
            'notes' => $request->notes,
        ]);

        return response()->json(['message' => 'Data Chemical berhasil diperbarui.']);
    }


    //export data ke template excel

    // public function export_template(Request $request)
    // {
    //     $bulan = $request->input('bulan', date('m'));
    //     $tahun = $request->input('tahun', date('Y'));

    //     $startDate = Carbon::create($tahun, $bulan, 1);
    //     $endDate = $startDate->copy()->endOfMonth();

    //     // Kategori sesuai template Excel
    //     $kategori = [
    //         'Outlet Storage WS',
    //         'CT RO',
    //         'Outlet Storage RO Reject',
    //         'CT WS',
    //         'Outlet Fresh Water 1',
    //         'Greenbelt',
    //         'Outlet Fresh Water 2',
    //         'Sumur 1',
    //         'Sumur 2',
    //         'Sumur 4',
    //         'Sumur 5',
    //         'PDAM'
    //     ];

    //     // Load template
    //     $templatePath = storage_path('app/templates/laporan_air_utility.xlsx');
    //     $spreadsheet = IOFactory::load($templatePath);
    //     $sheet = $spreadsheet->getActiveSheet();

    //     foreach ($kategori as $index => $jenis) {
    //         $data = PemakaianAirModel::where('jenis_pemakaian', $jenis)
    //         ->whereBetween('tanggal', [$startDate, $endDate])
    //         ->orderBy('tanggal')
    //             ->get()
    //             ->keyBy(function ($item) {
    //                 return Carbon::parse($item->tanggal)->day;
    //             });

    //         $startColumn = 2 + ($index * 3); // C = 2, F = 5, dst...
    //         $row = 5;

    //         for ($day = 1; $day <= $endDate->day; $day++) {
    //             $entry = $data->get($day);
    //             if ($entry) {
    //                 $colAwal = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startColumn);
    //                 $colAkhir = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startColumn + 1);
    //                 $colSelisih = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($startColumn + 2);

    //                 $sheet->setCellValue("{$colAwal}{$row}", $entry->pemakaian_awal);
    //                 $sheet->setCellValue("{$colAkhir}{$row}", $entry->pemakaian_akhir);
    //                 $sheet->setCellValue("{$colSelisih}{$row}", $entry->pemakaian_akhir - $entry->pemakaian_awal);
    //             }
    //             $row++;
    //         }
    //     }

    //     // Simpan hasil export
    //     $filename = "Laporan_Air_Utility_{$bulan}_{$tahun}.xlsx";
    //     $outputPath = storage_path("app/exports/{$filename}");
    //     $writer = new Xlsx($spreadsheet);
    //     $writer->save($outputPath);

    //     return response()->download($outputPath)->deleteFileAfterSend(true);
    // }
}
