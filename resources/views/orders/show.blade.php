@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Заказ # $order->id </h1>

<div class="mb-3">
	<div><strong>Статус:</strong>  $order->status </div>
	<div><strong>Сумма:</strong>  $order->total  ₽</div>
	@if($order->paid_at)
		<div><strong>Оплачен:</strong>  $order->paid_at->format('d.m.Y H:i') </div>
	@endif
</div>

<h2 class="h6">Состав</h2>
<ul class="list-group mb-3">
	@foreach($order->items as $it)
		<li class="list-group-item d-flex justify-content-between align-items-center">
			<span> $it->comic->title </span>
			<span> $it->unit_price  ₽</span>
		</li>
	@endforeach
</ul>

@if($order->status === \App\Models\Order::STATUS_CREATED)
	<form method="POST" action=" route('orders.pay', $order) ">
		@csrf
		<button class="btn btn-success">Оплатить (имитация)</button>
	</form>
@else
	<p class="text-muted">Если статус paid/completed — доступ к PDF уже открыт.</p>
@endif
@endsection
