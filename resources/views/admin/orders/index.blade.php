@extends('layouts.app')

@section('title', 'Админ • Заказы')

@section('content')
<h1 class="gomic-title mb-3">Админ • Заказы</h1>

<div class="card gomic-card border-0 shadow-sm">
  <table class="table align-middle mb-0">
    <thead><tr><th>#</th><th>Пользователь</th><th>Статус</th><th>Сумма</th><th>Дата</th><th></th></tr></thead>
    <tbody>
    @foreach($orders as $order)
      <tr>
        <td> $order->id </td>
        <td> $order->user->email </td>
        <td><span class="gomic-status gomic-status-- $order->status "> $order->status </span></td>
        <td> number_format($order->total, 0, '.', ' ')  ₽</td>
        <td> $order->created_at->format('d.m.Y H:i') </td>
        <td class="text-end"><a class="btn btn-sm btn-outline-primary" href=" route('admin.orders.show', $order) ">Открыть</a></td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>

<div class="mt-3"> $orders->links() </div>
@endsection
