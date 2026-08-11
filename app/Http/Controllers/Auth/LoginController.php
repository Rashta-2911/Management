<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            $selectedRole = $request->input('role');

            if (! $user->hasRole($selectedRole)) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Akun ini tidak memiliki akses sebagai '.$selectedRole.'.',
                ])->withInput($request->only('email'));
            }

            if ($user->hasRole('admin')) {
                return redirect('/admin');
            } elseif ($user->hasRole('pemilik')) {
                return redirect('/admin');
            }

            Auth::logout();

            return back()->withErrors(['email' => 'Akun tidak memiliki akses']);
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        return view('login');
    }
}
