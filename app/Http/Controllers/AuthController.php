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
    private $redirects = [
        'engineering' => [
            'dept_head' => '/eng/dept_head/dashboard',
            'supervisor' => '/eng/supervisor/dashboard',
            'foreman' => '/eng/foreman/dashboard', // <-- sesuaikan
            'operator' => '/eng/operator/menu/air',
        ],
        'qc' => [
            'dept_head' => '/qc/dept_head/dashboard',
            'supervisor' => '/qc/supervisor/dashboard',
            'foreman' => '/qc/foreman/dashboard',
            'operator' => '/qc/operator/dashboard',
        ],
        'produksi' => [
            'dept_head' => '/prd/dept_head/dashboard',
            'supervisor' => '/prd/supervisor/dashboard',
            'foreman' => '/prd/foreman/dashboard',
            'operator' => '/prd/operator/dashboard',
        ],
        'warehouse' => [
            'dept_head' => '/warehouse/dept_head/dashboard',
            'supervisor' => '/warehouse/supervisor/dashboard',
            'foreman' => '/warehouse/operator/dashboard',
            'operator' => '/warehouse/operator/dashboard',
        ],
    ];

    public function login(Request $request)
    {
        if (Auth::check()) {
            return response()->json([
                'success' => true,
                'message' => 'Anda sudah login.',
                'redirect' => $this->redirectUser(Auth::user()),
            ]);
        }

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            Session::put('username', $user->username);
            Session::put('jabatan', $user->jabatan);
            Session::put('departemen', $user->departemen);
            Cookie::queue('username', $user->username, 60);

            Log::info('Username saved in session: ' . Session::get('username'));

            $redirectUrl = $this->redirectUser($user);

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'redirect' => $redirectUrl,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Login gagal. Periksa username atau password Anda.',
        ], 401);
    }

    private function redirectUser($user)
    {
        $departemen = strtolower($user->departemen);
        $jabatan = strtolower($user->jabatan);

        $path = $this->redirects[$departemen][$jabatan] ?? '/';

        return url($path);
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
