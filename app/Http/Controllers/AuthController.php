<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin');
            }

            return redirect()->intended('/items');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username'              => ['required', 'string', 'max:50', 'unique:users'],
            'password'              => ['required', 'string', 'min:6', 'confirmed'],
            'nickname'              => ['required', 'string', 'max:100'],
            'phone_number'          => ['required', 'string', 'max:20'],
        ]);

        $user = User::create([
            'username'     => $validated['username'],
            'password'     => $validated['password'],
            'nickname'     => $validated['nickname'],
            'phone_number' => $validated['phone_number'],
            'role'         => 'user',
        ]);

        Auth::login($user);

        return redirect('/items');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
