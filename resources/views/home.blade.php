@extends('layouts.app')

@section('title', 'Gomic — магазин комиксов')

@section('content')
<div class="gomic-hero rounded-4 p-5 mb-4 text-white">
  <div class="gomic-hero__inner">
    <span class="badge gomic-badge mb-3">Цифровые комиксы в PDF</span>
    <h1 class="display-5 fw-bold mb-3">Твоя коллекция комиксов начинается здесь</h1>
    <p class="lead mb-4">Покупай, скачивай и читай любимые комиксы. Отзывы доступны только после покупки.</p>
    <a class="btn btn-light btn-lg fw-semibold px-4" href=" route('comics.index') ">Перейти в каталог →</a>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-4">
    <div class="gomic-feature h-100">
      <div class="gomic-feature__icon">\uD83D\uDCE5</div>
      <h2 class="h5">Мгновенная загрузка</h2>
      <p class="text-muted mb-0">PDF доступен сразу после оплаты заказа и навсегда остаётся в твоём аккаунте.</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="gomic-feature h-100">
      <div class="gomic-feature__icon">⭐</div>
      <h2 class="h5">Честные отзывы</h2>
      <p class="text-muted mb-0">Оставлять отзывы могут только покупатели — никаких фейковых оценок.</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="gomic-feature h-100">
      <div class="gomic-feature__icon">\uD83D\uDD12</div>
      <h2 class="h5">Безопасно</h2>
      <p class="text-muted mb-0">Файлы хранятся в защищённом хранилище и доступны только после покупки.</p>
    </div>
  </div>
</div>
@endsection
