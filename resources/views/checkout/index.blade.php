@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Оформление заказа</h1>

<ul class="list-group mb-3">
	@foreach($comics as $comic)
		<li class="list-group-item d-flex justify-content-between align-items-center">
			<span> $comic->title </span>
			<strong> $comic->price  ₽</strong>
		</li>
	@endforeach
	<li class="list-group-item d-flex justify-content-between align-items-center">
		<span>Итого</span>
		<strong> number_format($total, 2, '.', '')  ₽</strong>
	</li>
</ul>

<form method="POST" action=" route('orders.store') ">
	@csrf
	<button class="btn btn-success">Создать заказ</button>
</form>
@endsection
