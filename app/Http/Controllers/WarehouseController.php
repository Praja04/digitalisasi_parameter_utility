<?php

namespace App\Http\Controllers;

use App\Models\Warehouse\CheckForm;
use App\Models\Warehouse\CheckFormItem;
use App\Models\Warehouse\CheckItem;
use App\Models\Warehouse\Forklift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WarehouseController extends Controller
{
    ///////////End View foreman ///////////////////

    /////////////// 🔹 Dashboard untuk Operator //////////////////
    public function DashboardOperatorWarehouse()
    {
        // if (Session::get('jabatan') == 'operator') {
            return view('user.operator.wh.dashboard_wh');
        // }
        // return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    public function DetailP2HOperatorWarehouse($id)
    {
        if (Session::get('jabatan') == 'operator') {
            return view('user.operator.wh.detail_p2h', ['id' => $id]);
        }
        return redirect('/')->with('error',
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }
    
   
    ////////////End View Operator /////////////////

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
}
