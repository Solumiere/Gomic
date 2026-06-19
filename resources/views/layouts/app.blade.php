<!doctype html>
<html lang="ru" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.name', 'Gomic'))</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="<?= e(asset('css/app.css')) ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark gomic-nav sticky-top">
  <div class="container">
    <a class="navbar-brand" href="<?= e(route('home')) ?>">📚 Gomic</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-3">
        <li class="nav-item"><a class="nav-link" href="<?= e(route('comics.index')) ?>">Каталог</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= e(route('cart.index')) ?>">Корзина</a></li>
        @auth
          <li class="nav-item"><a class="nav-link" href="<?= e(route('profile.index')) ?>">Профиль</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= e(route('orders.index')) ?>">Заказы</a></li>
          @if(auth()->user()->is_admin)
            <li class="nav-item"><a class="nav-link" href="<?= e(route('admin.comics.index')) ?>">Админ</a></li>
          @endif
        @endauth
      </ul>
      <form class="d-flex gomic-search me-auto my-2 my-lg-0" method="GET" action="<?= e(route('comics.index')) ?>" role="search">
        <input class="form-control form-control-sm" type="search" name="q" value="<?= e(request('q')) ?>" placeholder="Поиск комиксов">
        <button class="btn btn-sm btn-light ms-2" type="submit">Найти</button>
      </form>
      <ul class="navbar-nav ms-auto align-items-lg-center">
        @guest
          <li class="nav-item"><a class="nav-link" href="<?= e(route('login')) ?>">Вход</a></li>
          <li class="nav-item"><a class="btn btn-sm btn-light fw-semibold ms-lg-2" href="<?= e(route('register')) ?>">Регистрация</a></li>
        @else
          <li class="nav-item"><span class="navbar-text text-white me-3">👋 <?= e(auth()->user()->name) ?></span></li>
          <li class="nav-item">
            <form method="POST" action="<?= e(route('logout')) ?>">
              @csrf
              <button class="btn btn-sm btn-outline-light" type="submit">Выйти</button>
            </form>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

<main class="container py-4 flex-grow-1">
  @if(session('success'))
    <div class="alert alert-success shadow-sm"><?= e(session('success')) ?></div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger shadow-sm"><?= e(session('error')) ?></div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger shadow-sm">
      <ul class="mb-0">
        @foreach($errors->all() as $e)
          <li><?= e($e) ?></li>
        @endforeach
      </ul>
    </div>
  @endif

  @yield('content')
</main>

<footer class="gomic-footer">
  <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
    <span>© <?= e(date('Y')) ?> Gomic — магазин комиксов</span>
    <span class="text-white-50 small">Покупай и читай комиксы в PDF</span>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
