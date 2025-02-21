<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Mail;
use App\Mail\ExampleMail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index'); // Menampilkan halaman DataTable
    }

    // Menyediakan data untuk DataTables
    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('id', 'username', 'created_at')->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-warning btn-sm edit" data-id="' . $row->id . '">Edit</button>
                            <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">Delete</button>';
                })
                ->make(true);
        }
    }

    // Menyimpan data pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['success' => 'User created successfully.']);
    }

    // Menampilkan data pengguna untuk di-edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    

    // Mengupdate data pengguna
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return response()->json(['success' => 'User updated successfully.']);
    }

    // Menghapus data pengguna
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }

    public function sendEmail()
    {
        $fromAddress = env('MAIL_FROM_ADDRESS');
        $fromName = env('MAIL_FROM_NAME');

        Log::info('MAIL_FROM_ADDRESS:', ['address' => $fromAddress]);
        Log::info('MAIL_FROM_NAME:', ['name' => $fromName]);

        if (empty($fromAddress) || empty($fromName)) {
            return response()->json(['error' => 'MAIL_FROM_ADDRESS or MAIL_FROM_NAME is not configured in .env'], 500);
        }

        // Lanjutkan dengan pengiriman email
        Mail::raw('This is a test email.', function ($message) use ($fromAddress, $fromName) {
            $message->from($fromAddress, $fromName)
                ->to('rajadamang13@gmail.com')
                ->subject('Hello from MailerSend!');
        });

        return response()->json(['message' => 'Email sent successfully!']);
    }

    public function getTotalUsers()
    {
        // Mengambil jumlah total user
        $totalUsers = User::count();

        // Mengembalikan response dalam bentuk JSON
        return response()->json([
            'success' => true,
            'total_users' => $totalUsers,
        ]);
    }
}
