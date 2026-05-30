<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginProses(Request $request)
    {
        try {
            $credentials = $request->validate(
                [
                    'email' => ['required', 'email'],
                    'password' => ['required'],
                ],
                [
                    'email.required' => 'Email harus diisi.',
                    'email.email' => 'Silakan masukkan alamat email yang valid.',
                    'password.required' => 'Password harus diisi.',
                ],
            );

            if (auth()->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard.index'));
            }

            return back()->withErrors([
                'email' => 'Kredensial yang diberikan tidak sesuai dengan catatan kami.',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan selama login. Silakan coba lagi.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
