@extends('layouts.app')

@section('title', 'Оформление заказа — Gomic')

@section('content')
<h1 class="gomic-title mb-3">Оформление заказа</h1>

<div class="card gomic-card border-0 shadow-sm p-3 mb-3 col-lg-7">
  <ul class="list-group list-group-flush mb-3">
    @foreach($comics as $comic)
      <li class="list-group-item d-flex justify-content-between align-items-center px-0">
        <span> $comic->title </span>
        <strong> number_format($comic->price, 0, '.', ' ')  ₽</strong>
      </li>
    @endforeach
    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
      <span class="fw-semibold">Итого</span>
      <strong class="gomic-price"> number_format($total, 2, '.', ' ')  ₽</strong>
    </li>
  </ul>

  <form method="POST" action=" route('orders.store') ">
    @csrf
    <button class="btn btn-success btn-lg w-100">Создать заказ</button>
  </form>
</div>
@endsection
