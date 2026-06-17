@extends('layouts.app')

@section('title', 'Мои заказы — Gomic')

@section('content')
<h1 class="gomic-title mb-3">Мои заказы</h1>

@if($orders->isEmpty())
  <div class="gomic-empty text-center py-5">
    <div class="display-6 mb-2">🧾</div>
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

  <div class="mt-3"><?= $orders->links() ?></div>
@endif
@endsection
