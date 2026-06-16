@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Мои заказы</h1>

@if($orders->isEmpty())
	<p>Заказов пока нет.</p>
@else
	<table class="table">
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
					<td> $order->id </td>
					<td> $order->status </td>
					<td> $order->total  ₽</td>
					<td> $order->created_at?->format('d.m.Y H:i') </td>
					<td><a class="btn btn-sm btn-outline-primary" href=" route('orders.show', $order) ">Открыть</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>

	 $orders->links() 
@endif
@endsection
