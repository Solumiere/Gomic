<!doctype html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> config('app.name') </title>
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
						<li class="nav-item"><a class="nav-link" href=" route('admin.comics.index') ">Админ</a></li>
					@endif
				@endauth
			</ul>
		</div>
	</div>
</nav>

<main class="container py-4">
	@yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
