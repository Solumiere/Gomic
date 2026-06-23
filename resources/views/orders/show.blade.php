@extends('layouts.app')

@section('title', 'Заказ #'.$order->id.' — Gomic')

@section('content')
<h1 class="gomic-title mb-3">Заказ #<?= e($order->id) ?></h1>

<div class="card gomic-card border-0 shadow-sm p-3 mb-3 col-lg-7">
  <h2 class="h6 mb-3">Данные покупателя</h2>
  <div class="d-flex justify-content-between mb-2"><span class="text-muted">Имя</span><span><?= e($order->user->name) ?></span></div>
  <div class="d-flex justify-content-between mb-2"><span class="text-muted">E-mail</span><span><?= e($order->user->email) ?></span></div>
  <div class="d-flex justify-content-between mb-2"><span class="text-muted">Дата заказа</span><span><?= e($order->created_at->format('d.m.Y H:i')) ?></span></div>
  <hr>
  <div class="d-flex justify-content-between mb-2"><span class="text-muted">Статус</span><span class="gomic-status gomic-status--<?= e($order->status) ?>"><?= e($order->status) ?></span></div>
  <div class="d-flex justify-content-between mb-2"><span class="text-muted">Сумма</span><strong><?= e(number_format($order->total, 0, '.', ' ')) ?> ₽</strong></div>
  @if($order->paid_at)
    <div class="d-flex justify-content-between"><span class="text-muted">Оплачен</span><span><?= e($order->paid_at->format('d.m.Y H:i')) ?></span></div>
  @endif
</div>

<h2 class="h6 mb-2">Комиксы в заказе</h2>
<ul class="list-group mb-3 col-lg-7">
  @foreach($order->items as $it)
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <a class="gomic-link" href="<?= e(route('comics.show', $it->comic->slug)) ?>"><?= e($it->comic->title) ?></a>
      <span><?= e(number_format($it->unit_price, 0, '.', ' ')) ?> ₽</span>
    </li>
  @endforeach
</ul>

<div class="d-flex flex-wrap gap-2">
  @if($order->status === \\App\\Models\\Order::STATUS_CREATED)
    <form method="POST" action="<?= e(route('orders.pay', $order)) ?>">
      @csrf
      <button class="btn btn-success btn-lg">Оплатить</button>
    </form>
  @elseif(in_array($order->status, [\\App\\Models\\Order::STATUS_PAID, \\App\\Models\\Order::STATUS_COMPLETED]))
    <a class="btn btn-primary btn-lg" href="<?= e(route('profile.index')) ?>">Перейти в профиль и скачать</a>
    <a class="btn btn-outline-secondary btn-lg" href="<?= e(route('orders.receipt', $order)) ?>" target="_blank">Чек / квитанция</a>
  @endif
</div>
@endsection
