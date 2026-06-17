@extends('layouts.app')

@section('title', 'Регистрация — Gomic')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card gomic-card border-0 shadow-sm p-4">
      <h1 class="gomic-title h3 mb-3">Регистрация</h1>
      <form method="POST" action=" route('register.store') ">
        @csrf
        <div class="mb-3">
          <label class="form-label">Имя</label>
          <input class="form-control" name="name" value=" old('name') " required autofocus>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input class="form-control" type="email" name="email" value=" old('email') " required>
        </div>
        <div class="mb-3">
          <label class="form-label">Пароль</label>
          <input class="form-control" type="password" name="password" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Повтори пароль</label>
          <input class="form-control" type="password" name="password_confirmation" required>
        </div>
        <button class="btn btn-success w-100">Создать аккаунт</button>
      </form>
      <p class="text-center text-muted mt-3 mb-0">Уже есть аккаунт? <a href=" route('login') ">Войти</a></p>
    </div>
  </div>
</div>
@endsection
