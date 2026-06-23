<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function show()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Пробелы в пароле не учитываем
        $request->merge([
            'password' => str_replace(' ', '', (string) $request->input('password')),
        ]);

        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        if (Auth::attempt($credentials, (bool)$request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->with('error', 'Неверный email или пароль');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
