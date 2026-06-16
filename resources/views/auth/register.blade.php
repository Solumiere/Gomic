@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Регистрация</h1>

<form method="POST" action="/register" class="col-md-6">
	@csrf
	<div class="mb-2">
		<label class="form-label">Имя</label>
		<input class="form-control" name="name" required>
	</div>
	<div class="mb-2">
		<label class="form-label">Email</label>
		<input class="form-control" type="email" name="email" required>
	</div>
	<div class="mb-2">
		<label class="form-label">Пароль</label>
		<input class="form-control" type="password" name="password" required>
	</div>
	<div class="mb-3">
		<label class="form-label">Повтори пароль</label>
		<input class="form-control" type="password" name="password_confirmation" required>
	</div>
	<button class="btn btn-success">Создать аккаунт</button>
</form>
@endsection
