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
    // Menyediakan data untuk DataTables
    public function getUsers()
    {
        $users = User::select('id', 'username', 'jabatan', 'email', 'image', 'created_at', 'departemen')->get();

        return response()->json($users);
    }

    // Menyimpan data pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'email' => 'required|email',
            'jabatan' => 'required',
            'departemen' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/users'), $imageName);
        }

        User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'departemen' => $request->departemen,
            'image' => $imageName,
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
            'email' => 'required|email',
            'jabatan' => 'required',
            'departemen' => 'required',
            'password' => 'nullable|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    
        $user = User::findOrFail($id);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            if ($user->image && file_exists(public_path('uploads/users/' . $user->image))) {
                unlink(public_path('uploads/users/' . $user->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/users'), $imageName);
            $user->image = $imageName;
        }
    
        // Update data user
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'departemen' => $request->departemen,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);
    
        return response()->json(['success' => 'User updated successfully.']);
    }

    // Menghapus data pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->image && file_exists(public_path('uploads/users/' . $user->image))) {
            unlink(public_path('uploads/users/' . $user->image));
        }
        $user->delete();
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
