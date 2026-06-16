@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Корзина</h1>

@if(empty($items))
	<p>Корзина пуста.</p>
@else
	<table class="table align-middle">
		<thead>
			<tr>
				<th>Комикс</th>
				<th class="text-end">Цена</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($items as $it)
				<tr>
					<td>
						<a href=" route('comics.show', $it['comic']->slug) "> $it['comic']->title </a>
					</td>
					<td class="text-end"> $it['comic']->price  ₽</td>
					<td class="text-end">
						<form method="POST" action=" route('cart.remove', $it['comic']->id) ">
							@csrf
							<button class="btn btn-sm btn-outline-danger">Удалить</button>
						</form>
					</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th class="text-end" colspan="2">Итого:</th>
				<th class="text-end"> $total  ₽</th>
			</tr>
		</tfoot>
	</table>

	@auth
		<a class="btn btn-success" href=" route('checkout.index') ">Оформить заказ</a>
	@else
		<p>Чтобы оформить заказ, войди в аккаунт.</p>
	@endauth
@endif
@endsection
