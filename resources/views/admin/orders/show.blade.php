@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Заказ # $order->id </h1>

<div class="mb-2"><strong>Пользователь:</strong>  $order->user->email </div>
<div class="mb-2"><strong>Сумма:</strong>  $order->total  ₽</div>
<div class="mb-3"><strong>Статус:</strong>  $order->status </div>

<form method="POST" action=" route('admin.orders.status', $order) " class="row g-2 mb-3">
	@csrf
	<div class="col-md-4">
		<select class="form-select" name="status">
			@foreach(['created','paid','cancelled','completed'] as $st)
				<option value=" $st "  $order->status===$st?'selected':'' > $st </option>
			@endforeach
		</select>
	</div>
	<div class="col-md-2">
		<button class="btn btn-primary w-100">Сохранить</button>
	</div>
</form>

<h2 class="h6">Позиции</h2>
<ul class="list-group">
	@foreach($order->items as $it)
		<li class="list-group-item d-flex justify-content-between">
			<span> $it->comic->title </span>
			<span> $it->unit_price  ₽</span>
		</li>
	@endforeach
</ul>
@endsection
