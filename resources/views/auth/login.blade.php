@extends('layouts.app')

@section('title', 'Вход — Gomic')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card gomic-card border-0 shadow-sm p-4">
      <h1 class="gomic-title h3 mb-3">Вход</h1>
      <form method="POST" action="<?= e(route('login.store')) ?>">
        @csrf
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input class="form-control" type="email" name="email" value="<?= e(old('email')) ?>" required autofocus>
        </div>
        <div class="mb-3">
          <label class="form-label">Пароль</label>
          <div class="input-group">
            <input class="form-control" type="password" name="password" id="login-password" required>
            <button class="btn btn-outline-secondary" type="button" onclick="togglePw('login-password', this)" aria-label="Показать пароль">👁</button>
          </div>
        </div>
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="remember" id="remember">
          <label class="form-check-label" for="remember">Запомнить меня</label>
        </div>
        <button class="btn btn-primary w-100">Войти</button>
      </form>
      <p class="text-center text-muted mt-3 mb-0">Нет аккаунта? <a href="<?= e(route('register')) ?>">Регистрация</a></p>
    </div>
  </div>
</div>

<script>
function togglePw(id, btn) {
  var input = document.getElementById(id);
  if (!input) return;
  if (input.type === 'password') { input.type = 'text'; btn.textContent = '🙈'; }
  else { input.type = 'password'; btn.textContent = '👁'; }
}
</script>
@endsection
