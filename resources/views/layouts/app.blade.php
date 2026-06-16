<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> config('app.name','Gomic') </title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
		<a class="navbar-brand" href=" route('home') ">Gomic</a>
		<div class="collapse navbar-collapse">
			<ul class="navbar-nav me-auto">
				<li class="nav-item"><a class="nav-link" href=" route('comics.index') ">Каталог</a></li>
				<li class="nav-item"><a class="nav-link" href=" route('cart.index') ">Корзина</a></li>
				@auth
					<li class="nav-item"><a class="nav-link" href=" route('orders.index') ">Заказы</a></li>
					@if(auth()->user()->is_admin)
						<li class="nav-item"><a class="nav-link" href=" url('/admin') ">Админ</a></li>
					@endif
				@endauth
			</ul>
			<ul class="navbar-nav ms-auto">
				@guest
					<li class="nav-item"><a class="nav-link" href="/login">Вход</a></li>
					<li class="nav-item"><a class="nav-link" href="/register">Регистрация</a></li>
				@else
					<li class="nav-item"><span class="navbar-text me-2"> auth()->user()->name </span></li>
					<li class="nav-item">
						<form method="POST" action="/logout">
							@csrf
							<button class="btn btn-sm btn-outline-light" type="submit">Выйти</button>
						</form>
					</li>
				@endguest
			</ul>
		</div>
	</div>
</nav>

<main class="container py-4">
	@if(session('success'))
		<div class="alert alert-success"> session('success') </div>
	@endif
	@if(session('error'))
		<div class="alert alert-danger"> session('error') </div>
	@endif
	@yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
