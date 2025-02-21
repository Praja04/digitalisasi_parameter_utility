<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Cek apakah pengguna sudah login
        if (Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah login.',
            ]);
        }
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        // Proses login
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Session::put('username', $user->username);
            Cookie::queue('username', $user->username, 60); 
            Log::info('Username saved in session: ' .Session::get('username'));
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                // 'redirect' => url('dashboard'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Login gagal. Periksa username atau password Anda.',
        ], 401);
    }



    public function logout(Request $request)
    {
        // Hapus session yang ada
        Auth::logout();

        // Hapus token CSRF jika menggunakan token untuk API
        $request->session()->invalidate();
        $request->session()->flush();
        Cookie::forget('username');
        // Menghancurkan semua session yang tersimpan
        $request->session()->regenerateToken();

        // Menghapus semua cookies yang terkait dengan aplikasi
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    
}
