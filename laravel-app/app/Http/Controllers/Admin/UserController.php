<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'admin')->latest()->get();

        return view('admin.manajemenUser.index', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string|min:8',
            ], [
                'name.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
                'password_confirmation.min' => 'Konfirmasi password minimal 8 karakter.',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'admin',
                'status' => 'aktif',
            ]);

            return redirect()->route('manajemen-user.index')->with('success', 'User baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('manajemen-user.index')->with('error', 'Terjadi kesalahan saat menambahkan user: ' . $e->getMessage());
        }
    }

    public function resetPassword(User $user)
    {
        try {
            $user->update([
                'password' => bcrypt('12345678'),
            ]);

            return redirect()->route('manajemen-user.index')->with('success', 'Password user berhasil direset ke default (12345678).');
        } catch (\Exception $e) {
            return redirect()->route('manajemen-user.index')->with('error', 'Terjadi kesalahan saat mereset password: ' . $e->getMessage());
        }
    }

    public function status(User $user)
    {
        try {
            $newStatus = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
            $user->update([
                'status' => $newStatus,
            ]);

            return redirect()->route('manajemen-user.index')->with('success', 'Status user berhasil diubah menjadi ' . $newStatus . '.');
        } catch (\Exception $e) {
            return redirect()->route('manajemen-user.index')->with('error', 'Terjadi kesalahan saat mengubah status: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ], [
                'name.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return redirect()->route('manajemen-user.index')->with('success', 'User berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('manajemen-user.index')->with('error', 'Terjadi kesalahan saat mengupdate user: ' . $e->getMessage());
        }
    }
}
