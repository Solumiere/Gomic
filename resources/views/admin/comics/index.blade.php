@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Админ • Комиксы</h1>
<a class="btn btn-sm btn-success mb-3" href=" route('admin.comics.create') ">Добавить</a>

<table class="table">
	<thead><tr><th>ID</th><th>Название</th><th>Цена</th><th>Активен</th><th></th></tr></thead>
	<tbody>
	@foreach($comics as $comic)
		<tr>
			<td> $comic->id </td>
			<td> $comic->title </td>
			<td> $comic->price  ₽</td>
			<td> $comic->is_active ? 'Да' : 'Нет' </td>
			<td class="text-end">
				<a class="btn btn-sm btn-outline-primary" href=" route('admin.comics.edit', $comic) ">Ред.</a>
				<form class="d-inline" method="POST" action=" route('admin.comics.destroy', $comic) " onsubmit="return confirm('Удалить?')">
					@csrf
					@method('DELETE')
					<button class="btn btn-sm btn-outline-danger">Удалить</button>
				</form>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

 $comics->links() 
@endsection
