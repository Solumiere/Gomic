@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Админ • Заказы</h1>

<table class="table">
	<thead><tr><th>#</th><th>Пользователь</th><th>Статус</th><th>Сумма</th><th>Дата</th><th></th></tr></thead>
	<tbody>
	@foreach($orders as $order)
		<tr>
			<td> $order->id </td>
			<td> $order->user->email </td>
			<td> $order->status </td>
			<td> $order->total  ₽</td>
			<td> $order->created_at </td>
			<td class="text-end"><a class="btn btn-sm btn-outline-primary" href=" route('admin.orders.show', $order) ">Открыть</a></td>
		</tr>
	@endforeach
	</tbody>
</table>

 $orders->links() 
@endsection
