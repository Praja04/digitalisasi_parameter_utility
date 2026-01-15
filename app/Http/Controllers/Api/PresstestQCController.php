<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QC\PresstestModel;
use Illuminate\Support\Facades\Validator;

class PresstestQCController extends Controller
{
    public function store_data(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'jarak' => 'required|numeric',
            'status' => 'required|string|in:AMAN,BOCOR'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Simpan data ke database
            $presstest = PresstestModel::create([
                'jarak' => $request->jarak,
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $presstest
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
