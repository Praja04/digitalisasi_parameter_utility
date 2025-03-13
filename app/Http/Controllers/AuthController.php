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
                'success' => true,
                'message' => 'Anda sudah login.',
                'redirect' => $this->redirectUser(Auth::user()), // Redirect sesuai jabatan
            ]);
        }

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Simpan informasi user ke dalam session
            Session::put('username', $user->username);
            Session::put('jabatan', $user->jabatan);
            Session::put('departemen', $user->departemen);
            Cookie::queue('username', $user->username, 60);

            Log::info('Username saved in session: ' . Session::get('username'));

            // Redirect berdasarkan jabatan
            if ($user->jabatan === 'dept_head') {
                $redirectUrl = url('/eng/dept_head/dashboard');
            } elseif (in_array($user->jabatan, ['operator', 'foreman', 'supervisor'])) {
                $redirectUrl = url('/operator/dashboard'); // Ubah sesuai kebutuhan
            } else {
                $redirectUrl = url('/login'); // Default jika jabatan tidak dikenali
            }

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
        if ($user->jabatan === 'dept_head') {
            return url('/eng/dept_head/dashboard');
        } elseif (in_array($user->jabatan, ['operator', 'foreman', 'supervisor'])) {
            return url('/operator/dashboard');
        }
    
        return url('/login'); // Default jika jabatan tidak dikenali
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

    public function dashboardQC()
    {
        if (Session::get('jabatan') !== 'dept_head') {
            return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.dept_head.dashboard_qc');
    }

    public function dashboardProduksi()
    {
        if (Session::get('jabatan') !== 'dept_head') {
            return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.dept_head.dashboard_produksi');
    }

    public function dashboardEng()
    {
        if (Session::get('jabatan') !== 'dept_head') {
            return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('user.dept_head.dashboard_eng');
    }


    public function todoListEng()
    {
        if (Session::get('jabatan') !== 'dept_head') {
            return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman
            ini.');
        }
        return view('user.dept_head.todo_list_eng');
    }
}
