@extends('layouts.app')

@section('title', 'Заказ #'.$order->id)

@section('content')
<h1 class="gomic-title mb-3">Заказ # $order->id </h1>

<div class="card gomic-card border-0 shadow-sm p-3 mb-3 col-lg-7">
  <div class="d-flex justify-content-between mb-2"><span class="text-muted">Пользователь</span><span> $order->user->email </span></div>
  <div class="d-flex justify-content-between mb-2"><span class="text-muted">Сумма</span><strong> number_format($order->total, 0, '.', ' ')  ₽</strong></div>
  <div class="d-flex justify-content-between"><span class="text-muted">Статус</span><span class="gomic-status gomic-status-- $order->status "> $order->status </span></div>
</div>

<form method="POST" action=" route('admin.orders.status', $order) " class="row g-2 mb-4 col-lg-7">
  @csrf
  <div class="col-md-8">
    <select class="form-select" name="status">
      @foreach(['created','paid','cancelled','completed'] as $st)
        <option value=" $st " @selected($order->status === $st)> $st </option>
      @endforeach
    </select>
  </div>
  <div class="col-md-4">
    <button class="btn btn-primary w-100">Сохранить</button>
  </div>
</form>

<h2 class="h6 mb-2">Позиции</h2>
<ul class="list-group col-lg-7">
  @foreach($order->items as $it)
    <li class="list-group-item d-flex justify-content-between">
      <span> $it->comic->title </span>
      <span> number_format($it->unit_price, 0, '.', ' ')  ₽</span>
    </li>
  @endforeach
</ul>
@endsection
