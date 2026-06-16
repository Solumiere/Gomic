@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Вход</h1>

<form method="POST" action="/login" class="col-md-5">
	@csrf
	<div class="mb-2">
		<label class="form-label">Email</label>
		<input class="form-control" type="email" name="email" required>
	</div>
	<div class="mb-2">
		<label class="form-label">Пароль</label>
		<input class="form-control" type="password" name="password" required>
	</div>
	<div class="form-check mb-3">
		<input class="form-check-input" type="checkbox" name="remember" id="remember">
		<label class="form-check-label" for="remember">Запомнить</label>
	</div>
	<button class="btn btn-primary">Войти</button>
</form>
@endsection
