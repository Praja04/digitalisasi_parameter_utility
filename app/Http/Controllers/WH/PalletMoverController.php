<?php

namespace App\Http\Controllers\WH;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\PalletMoverModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PalletMoverController extends Controller
{
    // 1. Menampilkan halaman registrasi pallet mover
    public function showPalletMoverRegistration()
    {
        if (!in_array(Session::get('jabatan'), ['supervisor', 'dept_head', 'foreman'])) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $pallets = PalletMoverModel::with('assignedOperators')->orderBy('nomor_unit')->get();

        $data = $pallets->map(function ($pallet) {
            $primary = $pallet->assignedOperators->where('pivot.is_primary', true)->first();
            $backup = $pallet->assignedOperators->where('pivot.is_primary', false)->pluck('username');

            return [
                'id' => $pallet->id,
                'nomor_unit' => $pallet->nomor_unit,
                'departemen' => $pallet->departemen,
                'status' => $pallet->status,
                'description' => $pallet->description,
                'primary_operator' => $primary ? $primary->username : '-',
                'backup_operators' => $backup,
                'created_at' => $pallet->created_at->format('d/m/Y H:i')
            ];
        });

        $operators = User::where('jabatan', 'operator')
            ->where('departemen', 'warehouse')
            ->select('id', 'username', 'nik')
            ->get();

        return view('user.supervisor.wh.pallet_mover_registration', compact('data', 'operators'));
    }

    // 2. Get Data Pallet Mover
    public function getPalletData()
    {
        $pallets = PalletMoverModel::with('assignedOperators')->orderBy('nomor_unit')->get();

        $data = $pallets->map(function ($pallet) {
            $primary = $pallet->assignedOperators->where('pivot.is_primary', true)->first();
            $backup = $pallet->assignedOperators->where('pivot.is_primary', false);

            return [
                'id' => $pallet->id,
                'nomor_unit' => $pallet->nomor_unit,
                'status' => ucfirst($pallet->status),
                'notes' => ucfirst($pallet->notes),
                'departemen' => ucfirst($pallet->departemen),
                'primary_operator' => $primary ? $primary->username : '-',
                'backup_count' => $backup->count(),
                'created_at' => $pallet->created_at->format('d/m/Y H:i'),
            ];
        });

        return response()->json(['data' => $data]);
    }

    // 3. Store Pallet Mover
    public function storePalletMover(Request $request)
    {
        if (!in_array(Session::get('jabatan'), ['supervisor', 'dept_head', 'foreman'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'nomor_unit' => 'required|string|max:10|unique:pallet_movers,nomor_unit',
            'departemen' => 'required|in:warehouse,produksi',
            'status' => 'required|in:active,maintenance,inactive',
            'description' => 'nullable|string|max:255'
        ]);

        $pallet = PalletMoverModel::create([
            'nomor_unit' => strtoupper(trim($request->nomor_unit)),
            'departemen' => $request->departemen,
            'status' => $request->status,
            'description' => $request->description
        ]);

        return response()->json(['success' => true, 'data' => $pallet]);
    }

    // 4. Update Pallet Mover
    public function updatePalletMover(Request $request, $id)
    {
        if (!in_array(Session::get('jabatan'), ['supervisor', 'dept_head','foreman'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'nomor_unit' => 'required|string|max:10|unique:pallet_movers,nomor_unit,' . $id,
            'departemen' => 'required|in:warehouse,produksi',
            'status' => 'required|in:active,maintenance,inactive',
            'description' => 'nullable|string|max:255'
        ]);

        $pallet = PalletMoverModel::findOrFail($id);
        $pallet->update($request->only(['nomor_unit', 'departemen', 'status', 'description']));

        return response()->json(['success' => true, 'data' => $pallet]);
    }

    // 5. Delete Pallet Mover
    public function deletePalletMover($id)
    {
        if (!in_array(Session::get('jabatan'), ['supervisor', 'dept_head', 'foreman'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $pallet = PalletMoverModel::findOrFail($id);
        $pallet->assignedOperators()->detach();
        $pallet->delete();

        return response()->json(['success' => true, 'message' => 'Pallet mover berhasil dihapus.']);
    }

    // 6. Get Detail
    public function getPalletMoverDetail($id)
    {
        $pallet = PalletMoverModel::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $pallet->id,
                'nomor_unit' => $pallet->nomor_unit,
                'departemen' => $pallet->departemen,
                'status' => $pallet->status,
                'description' => $pallet->description
            ]
        ]);
    }

    // 7. Get daftar operator warehouse
    public function getWarehouseOperators()
    {
        $operators = User::where('jabatan', 'operator')
            ->where('departemen', 'warehouse')
            ->select('id', 'username', 'nik')
            ->get();

        return response()->json(['success' => true, 'data' => $operators]);
    }

    // 8. Store assignment ke pallet mover
    public function storeAssignment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pallet_mover_id' => 'required|exists:pallet_movers,id',
            'is_primary' => 'required|boolean'
        ]);

        $user = User::findOrFail($request->user_id);
        if ($user->jabatan !== 'operator' || $user->departemen !== 'warehouse') {
            return response()->json(['success' => false, 'message' => 'User bukan operator warehouse'], 422);
        }

        $exists = PalletMoverModel::findOrFail($request->pallet_mover_id)
            ->assignedOperators()
            ->wherePivot('user_id', $user->id)
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'User sudah di-assign ke pallet mover ini'], 422);
        }

        $pallet = PalletMoverModel::findOrFail($request->pallet_mover_id);
        $pallet->assignedOperators()->attach($user->id, ['is_primary' => $request->is_primary]);

        return response()->json(['success' => true, 'message' => 'Assignment berhasil']);
    }

    // 9. Edit assignment pallet mover
    public function editAssignment($id)
    {
        $pallet = PalletMoverModel::with('assignedOperators')->findOrFail($id);

        $primary = $pallet->assignedOperators->where('pivot.is_primary', true)->first();
        $backups = $pallet->assignedOperators->where('pivot.is_primary', false)->pluck('id')->toArray();

        $operators = User::where('jabatan', 'operator')
            ->where('departemen', 'warehouse')
            ->select('id', 'username', 'nik')
            ->get();

        return response()->json([
            'primary_operator_id' => $primary?->id,
            'backup_operator_ids' => $backups,
            'operators' => $operators
        ]);
    }

    // 10. Update assignment pallet mover
    public function updateAssignment(Request $request)
    {
        $request->validate([
            'pallet_mover_id' => 'required|exists:pallet_movers,id',
            'primary_operator_id' => 'nullable|exists:users,id',
            'backup_operator_ids' => 'array'
        ]);

        $pallet = PalletMoverModel::findOrFail($request->pallet_mover_id);
        $pallet->assignedOperators()->detach();

        if ($request->primary_operator_id) {
            $pallet->assignedOperators()->attach($request->primary_operator_id, ['is_primary' => true]);
        }

        if ($request->backup_operator_ids) {
            foreach ($request->backup_operator_ids as $id) {
                $pallet->assignedOperators()->attach($id, ['is_primary' => false]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Assignment berhasil diperbarui']);
    }

    // 11. Get Backup Operator
    public function getBackupOperators($id)
    {
        $pallet = PalletMoverModel::with('assignedOperators')->findOrFail($id);
        $backups = $pallet->assignedOperators
            ->where('pivot.is_primary', false)
            ->map(fn ($u) => ['username' => $u->username, 'nik' => $u->nik]);

        return response()->json(['backups' => $backups]);
    }
}
