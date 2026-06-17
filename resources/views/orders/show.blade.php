@extends('layouts.app')

@section('title', 'Заказ #'.$order->id.' — Gomic')

@section('content')
<h1 class="gomic-title mb-3">Заказ # $order->id </h1>

<div class="card gomic-card border-0 shadow-sm p-3 mb-3 col-lg-7">
  <div class="d-flex justify-content-between mb-2"><span class="text-muted">Статус</span><span class="gomic-status gomic-status-- $order->status "> $order->status </span></div>
  <div class="d-flex justify-content-between mb-2"><span class="text-muted">Сумма</span><strong> number_format($order->total, 0, '.', ' ')  ₽</strong></div>
  @if($order->paid_at)
    <div class="d-flex justify-content-between"><span class="text-muted">Оплачен</span><span> $order->paid_at->format('d.m.Y H:i') </span></div>
  @endif
</div>

<h2 class="h6 mb-2">Состав</h2>
<ul class="list-group mb-3 col-lg-7">
  @foreach($order->items as $it)
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <span> $it->comic->title </span>
      <span> number_format($it->unit_price, 0, '.', ' ')  ₽</span>
    </li>
  @endforeach
</ul>

@if($order->status === \App\Models\Order::STATUS_CREATED)
  <form method="POST" action=" route('orders.pay', $order) ">
    @csrf
    <button class="btn btn-success btn-lg">Оплатить (имитация)</button>
  </form>
@elseif(in_array($order->status, [\App\Models\Order::STATUS_PAID, \App\Models\Order::STATUS_COMPLETED]))
  <div class="alert alert-success col-lg-7">Заказ оплачен — доступ к PDF открыт. Скачать можно со страницы комикса.</div>
@endif
@endsection
