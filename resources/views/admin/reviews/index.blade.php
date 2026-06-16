@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Админ • Отзывы</h1>

<table class="table">
	<thead><tr><th>ID</th><th>Комикс</th><th>Пользователь</th><th>Оценка</th><th>Дата</th><th></th></tr></thead>
	<tbody>
	@foreach($reviews as $r)
		<tr>
			<td> $r->id </td>
			<td> $r->comic->title </td>
			<td> $r->user->email </td>
			<td> $r->rating </td>
			<td> $r->created_at </td>
			<td class="text-end">
				<form method="POST" action=" route('admin.reviews.destroy', $r) " onsubmit="return confirm('Удалить отзыв?')">
					@csrf
					@method('DELETE')
					<button class="btn btn-sm btn-outline-danger">Удалить</button>
				</form>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

 $reviews->links() 
@endsection
