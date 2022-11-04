<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginContronller extends Controller
{
    // TODO: Lanjut bikin view untuk login sama dashboard terus lanjut bikin fungsi-fungsi untuk login

    public function index()
    {
        // TODO: Lanjut buat halaman dashboard sama, yang lain-lain
        return view('login.index', [
            'title' => 'login',
        ]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    { // TODO: Lanjut ke tabel kas
        $credentials = $request->validate([
            'username' => ['required'], // email:dns untuk mengecek apakah domainnya sudah betul
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'Login failed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
