@extends('layouts.app')

@section('title', 'Мой профиль — Gomic')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <h1 class="gomic-title mb-0">Мой профиль</h1>
  <a class="btn btn-outline-primary" href="<?= e(route('cart.index')) ?>">🛒 Корзина</a>
</div>

<div class="card gomic-card border-0 shadow-sm p-3 mb-4 col-lg-7">
  <div class="d-flex justify-content-between mb-2"><span class="text-muted">Имя</span><span class="fw-semibold"><?= e($user->name) ?></span></div>
  <div class="d-flex justify-content-between"><span class="text-muted">E-mail</span><span><?= e($user->email) ?></span></div>
</div>

<h2 class="h5 mb-3">📥 Мои покупки</h2>
@if($purchasedComics->isEmpty())
  <div class="gomic-empty text-center py-5 mb-4">
    <div class="display-6 mb-2">📚</div>
    <p class="text-muted mb-3">У вас пока нет купленных комиксов.</p>
    <a class="btn btn-primary" href="<?= e(route('comics.index')) ?>">Перейти в каталог</a>
  </div>
@else
  <div class="row g-4 mb-4">
    @foreach($purchasedComics as $comic)
      <div class="col-sm-6 col-lg-4">
        <div class="card gomic-card h-100 border-0 shadow-sm">
          <a href="<?= e(route('comics.show', $comic->slug)) ?>" class="gomic-cover">
            @if($comic->cover_image_path)
              <img src="<?= e(asset('storage/'.$comic->cover_image_path)) ?>" alt="<?= e($comic->title) ?>">
            @else
              <div class="gomic-cover__placeholder">📖</div>
            @endif
          </a>
          <div class="card-body d-flex flex-column">
            <h3 class="h6 mb-2"><a class="gomic-link" href="<?= e(route('comics.show', $comic->slug)) ?>"><?= e($comic->title) ?></a></h3>
            <a class="btn btn-primary w-100 mt-auto" href="<?= e(route('comics.download', $comic->id)) ?>">📥 Скачать PDF</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endif

<h2 class="h5 mb-3">🧾 История заказов</h2>
@if($orders->isEmpty())
  <div class="gomic-empty text-center py-4">
    <p class="text-muted mb-0">Заказов пока нет.</p>
  </div>
@else
  <div class="card gomic-card border-0 shadow-sm">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th>#</th>
          <th>Статус</th>
          <th>Сумма</th>
          <th>Дата</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
          <tr>
            <td><?= e($order->id) ?></td>
            <td><span class="gomic-status gomic-status--<?= e($order->status) ?>"><?= e($order->status) ?></span></td>
            <td><?= e(number_format($order->total, 0, '.', ' ')) ?> ₽</td>
            <td><?= e($order->created_at->format('d.m.Y H:i')) ?></td>
            <td class="text-end"><a class="btn btn-sm btn-outline-primary" href="<?= e(route('orders.show', $order)) ?>">Открыть</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endif
@endsection
