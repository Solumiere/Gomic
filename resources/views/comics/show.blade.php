@extends('layouts.app')

@section('content')
<div class="row g-4">
	<div class="col-md-4">
		@if($comic->cover_image_path)
			<img class="img-fluid rounded" src=" asset('storage/'.$comic->cover_image_path) " alt="cover">
		@else
			<div class="bg-light rounded p-5 text-center text-muted">Нет обложки</div>
		@endif
	</div>
	<div class="col-md-8">
		<h1 class="h3"> $comic->title </h1>
		<div class="mb-2 text-muted">Средний рейтинг:  number_format($avgRating, 1) /5</div>
		<div class="mb-3"> $comic->description </div>
		<div class="h5 mb-3"> $comic->price  ₽</div>

		<form method="POST" action=" route('cart.add', $comic) " class="d-inline">
			@csrf
			<button class="btn btn-primary">В корзину</button>
		</form>
		@auth
			<a class="btn btn-outline-secondary" href=" route('comics.download', $comic) ">Скачать PDF</a>
		@endauth
	</div>
</div>

<hr class="my-4">
<h2 class="h5">Отзывы</h2>

@if($reviews->isEmpty())
	<p class="text-muted">Пока нет отзывов.</p>
@endif

@foreach($reviews as $review)
	<div class="border rounded p-3 mb-2">
		<div class="small text-muted"> $review->user->name  •  $review->created_at </div>
		<div class="fw-semibold">Оценка:  $review->rating /5</div>
		<div> $review->body </div>
	</div>
@endforeach

@auth
	<hr class="my-4">
	<h3 class="h6">Оставить отзыв (после покупки)</h3>
	<form method="POST" action=" route('reviews.store', $comic) ">
		@csrf
		<div class="mb-2">
			<label class="form-label">Оценка</label>
			<select class="form-select" name="rating" required>
				@for($i=5;$i>=1;$i--)
					<option value=" $i "> $i </option>
				@endfor
			</select>
		</div>
		<div class="mb-2">
			<label class="form-label">Текст</label>
			<textarea class="form-control" name="body" rows="3" required></textarea>
		</div>
		<button class="btn btn-sm btn-success">Отправить</button>
	</form>
@endauth
@endsection
