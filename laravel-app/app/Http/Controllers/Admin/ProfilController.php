<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        return view('admin.profil.index');
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . auth()->id(),
            ]);

            auth()
                ->user()
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);

            return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->route('profil.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate(
                [
                    'current_password' => 'required|string',
                    'password' => 'required|string|min:8|confirmed',
                ],
                [
                    'current_password.required' => 'Password lama wajib diisi.',
                    'password.required' => 'Password baru wajib diisi.',
                    'password.min' => 'Password baru minimal 8 karakter.',
                    'password.confirmed' => 'Konfirmasi password tidak cocok.',
                ],
            );

            $user = auth()->user();

            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('profil.index')->with('error', 'Password lama tidak sesuai.');
            }

            $user->update([
                'password' => bcrypt($request->password),
            ]);

            return redirect()->route('profil.index')->with('success', 'Password berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->route('profil.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
