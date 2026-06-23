<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','min:2','max:120','regex:/^[\\p{L}\\s\\-]+$/u'],
            'email' => ['required','email','max:190','regex:/^[A-Za-z0-9._%+\\-]+@[A-Za-z0-9.\\-]+\\.[A-Za-z]{2,}$/','unique:users,email'],
            'password' => ['required','string','min:6','confirmed'],
        ], [
            'name.required' => 'Введите имя',
            'name.min' => 'Имя слишком короткое',
            'name.regex' => 'Имя может содержать только буквы, пробелы и дефис',
            'email.required' => 'Введите email',
            'email.email' => 'Введите корректный email',
            'email.regex' => 'Email содержит недопустимые символы',
            'email.unique' => 'Этот email уже зарегистрирован',
            'password.min' => 'Пароль должен быть не короче 6 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => false,
        ]);

        Auth::login($user);
        return redirect()->route('home');
    }
}
