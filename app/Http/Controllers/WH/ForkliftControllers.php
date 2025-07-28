<?php

namespace App\Http\Controllers\WH;

use App\Http\Controllers\Controller;
use App\Models\Warehouse\ForkliftModel;
use App\Models\User;
use App\Models\Warehouse\UserForkliftAssignmentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ForkliftControllers extends Controller
{
    //
    // 1. Menampilkan halaman register forklift
    public function showForkliftRegistration()
    {
        if (!in_array(Session::get('jabatan'), ['supervisor', 'dept_head'])) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Ambil semua forklift beserta relasi assignedOperators
        $forkliftRaw = ForkliftModel::with('assignedOperators')->orderBy('nomor_unit')->get();

        // Format forklifts untuk DataTable atau view blade
        $forklifts = $forkliftRaw->map(function ($forklift) {
            $primaryOperator = $forklift->assignedOperators
                ->where('pivot.is_primary', true)
                ->first();

            $backupOperators = $forklift->assignedOperators
                ->where('pivot.is_primary', false)
                ->map(function ($user) {
                    return $user->username;
                });

            return [
                'id' => $forklift->id,
                'nomor_unit' => $forklift->nomor_unit,
                'departemen' => $forklift->departemen,
                'status' => $forklift->status,
                'description' => $forklift->description,
                'primary_operator' => $primaryOperator ? $primaryOperator->username : '-',
                'backup_operators' => $backupOperators,
                'created_at' => $forklift->created_at->format('d/m/Y H:i')
            ];
        });

        // Ambil daftar operator warehouse untuk dropdown assignment
        $operators = User::where('jabatan', 'operator')
            ->where('departemen', 'warehouse')
            ->select('id', 'username', 'nik')
            ->get();

        return view(
            'user.supervisor.wh.forklift_registration',
            compact('forklifts', 'operators')
        );
    }

    // 2. Get data forklift untuk DataTable (READ) - FIXED
    public function getForkliftData()
    {
        $forklifts = ForkliftModel::with('assignedOperators')->orderBy('nomor_unit')->get();

        $data = $forklifts->map(function ($forklift) {
            $primary = $forklift->assignedOperators->where('pivot.is_primary', true)->first();
            $backup = $forklift->assignedOperators->where('pivot.is_primary', false);

            return [
                'id' => $forklift->id,
                'nomor_unit' => $forklift->nomor_unit,
                'status' => ucfirst($forklift->status),
                'departemen' => ucfirst($forklift->departemen),
                'primary_operator' => $primary ? $primary->username : '-',
                'backup_count' => $backup->count(),
                'created_at' => $forklift->created_at->format('d/m/Y H:i'),
            ];
        });

        return response()->json(['data' => $data]);
    }

    // 3. Store forklift baru (CREATE) - NO CHANGES NEEDED
    public function storeForklift(Request $request)
    {
        if (!in_array(Session::get('jabatan'), ['supervisor', 'dept_head'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'nomor_unit' => 'required|string|max:10|unique:forklifts,nomor_unit',
            'departemen' => 'required|in:warehouse,produksi',
            'status' => 'required|in:active,maintenance,inactive',
            'description' => 'nullable|string|max:255'
        ]);

        try {
            $forklift = ForkliftModel::create([
                'nomor_unit' => strtoupper(trim($request->nomor_unit)),
                'departemen' => $request->departemen,
                'status' => $request->status,
                'description' => $request->description
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Forklift berhasil didaftarkan',
                'data' => $forklift
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 4. Update forklift data (UPDATE) - NO CHANGES NEEDED
    public function updateForklift(Request $request, $id)
    {
        if (!in_array(Session::get('jabatan'), ['supervisor', 'dept_head'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'nomor_unit' => 'required|string|max:10|unique:forklifts,nomor_unit,' . $id,
            'departemen' => 'required|in:warehouse,produksi',
            'status' => 'required|in:active,maintenance,inactive',
            'description' => 'nullable|string|max:255'
        ]);

        try {
            $forklift = ForkliftModel::findOrFail($id);

            $forklift->update([
                'nomor_unit' => strtoupper(trim($request->nomor_unit)),
                'departemen' => $request->departemen,
                'status' => $request->status,
                'description' => $request->description
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data forklift berhasil diupdate',
                'data' => $forklift
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 5. Delete forklift (DELETE) - FIXED
    public function deleteForklift($id)
    {
        if (!in_array(Session::get('jabatan'), ['supervisor', 'dept_head'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $forklift = ForkliftModel::findOrFail($id);

            // Hapus semua assignment terlebih dahulu
            $forklift->userAssignments()->delete();

            // Lanjut hapus forklift
            $forklift->delete();

            return response()->json([
                'success' => true,
                'message' => 'Forklift dan semua assignment berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getForkliftDetail($id)
    {
        if (!in_array(Session::get('jabatan'), ['supervisor', 'dept_head'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $forklift = ForkliftModel::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $forklift->id,
                    'nomor_unit' => $forklift->nomor_unit,
                    'departemen' => $forklift->departemen,
                    'status' => $forklift->status,
                    'description' => $forklift->description
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getBackupOperators($id)
    {
        $forklift = ForkliftModel::with('assignedOperators')->findOrFail($id);

        $backups = $forklift->assignedOperators
            ->where('pivot.is_primary', false)
            ->map(function ($user) {
                return [
                    'username' => $user->username,
                    'nik' => $user->nik
                ];
            });

        return response()->json(['backups' => $backups]);
    }

    /**
     * ============================================
     * USER FORKLIFT ASSIGNMENT CONTROLLER METHODS
     * ============================================
     */

    // 6. Get warehouse operators untuk dropdown - NO CHANGES NEEDED
    public function getWarehouseOperators()
    {
        if (!in_array(Session::get('jabatan'), ['supervisor', 'dept_head'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $operators = User::where('jabatan', 'operator')
            ->where('departemen', 'warehouse')
            ->select('id', 'username', 'nik')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $operators
        ]);
    }

    // 7. Store user assignment ke forklift (CREATE ASSIGNMENT) - IMPROVED
    public function storeUserAssignment(Request $request)
    {
        if (!in_array(Session::get('jabatan'), ['supervisor', 'dept_head'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'forklift_id' => 'required|exists:forklifts,id',
            'is_primary' => 'required|boolean',
            'notes' => 'nullable|string|max:255'
        ]);

        // Validasi user adalah operator warehouse
        $user = User::find($request->user_id);
        if ($user->jabatan !== 'operator' || $user->departemen !== 'warehouse') {
            return response()->json([
                'success' => false,
                'message' => 'User harus memiliki jabatan operator dan departemen warehouse'
            ], 422);
        }

        try {
            // Check if assignment already exists and is active
            $existingAssignment = UserForkliftAssignmentModel::where('user_id', $request->user_id)
                ->where('forklift_id', $request->forklift_id)
                ->where('is_active', true)
                ->first();

            if ($existingAssignment) {
                return response()->json([
                    'success' => false,
                    'message' => 'User sudah di-assign ke forklift ini'
                ], 422);
            }

            // Create assignment - menggunakan model method untuk handle primary logic
            $assignment = UserForkliftAssignmentModel::create([
                'user_id' => $request->user_id,
                'forklift_id' => $request->forklift_id,
                'is_primary' => $request->is_primary,
                'assigned_date' => now(),
                'assigned_by' => Session::get('user_id'),
                'notes' => $request->notes,
                'is_active' => true
            ]);

            // Jika set sebagai primary, model boot event akan handle logic
            // atau bisa dipanggil manual jika menggunakan method model
            if ($request->is_primary) {
                $assignment->setPrimary();
            }

            $forklift = ForkliftModel::find($request->forklift_id);
            $assignmentType = $request->is_primary ? 'Primary' : 'Backup';

            return response()->json([
                'success' => true,
                'message' => "User {$user->username} berhasil di-assign sebagai {$assignmentType} operator untuk {$forklift->nomor_unit}",
                'data' => $assignment
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function editAssignment($id)
    {
        $forklift = ForkliftModel::with('assignedOperators')->findOrFail($id);

        $primary = $forklift->assignedOperators->where('pivot.is_primary', true)->first();
        $backups = $forklift->assignedOperators->where('pivot.is_primary', false)->pluck('id')->toArray();

        $operators = User::where('jabatan', 'operator')
            ->where('departemen', 'warehouse')
            ->select('id', 'username', 'nik')->get();

        return response()->json([
            'primary_operator_id' => $primary ? $primary->id : null,
            'backup_operator_ids' => $backups,
            'operators' => $operators
        ]);
    }

    public function updateAssignment(Request $request)
    {
        $request->validate([
            'forklift_id' => 'required|exists:forklifts,id',
            'primary_operator_id' => 'nullable|exists:users,id',
            'backup_operator_ids' => 'array'
        ]);

        $forklift = ForkliftModel::findOrFail($request->forklift_id);

        // Reset assignment
        $forklift->assignedOperators()->detach();

        // Assign operator utama
        if ($request->primary_operator_id) {
            $forklift->assignedOperators()->attach($request->primary_operator_id, ['is_primary' => true]);
        }

        // Assign backup
        if ($request->has('backup_operator_ids')) {
            foreach ($request->backup_operator_ids as $id) {
                $forklift->assignedOperators()->attach($id, ['is_primary' => false]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Assignment berhasil diupdate']);
    }



    ///////////////// End Forklift Assignment Methods /////////////////

}
