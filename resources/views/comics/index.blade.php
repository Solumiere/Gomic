@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Каталог</h1>

<form class="row g-2 mb-3" method="GET" action=" route('comics.index') ">
	<div class="col-md-4">
		<input class="form-control" name="q" value=" request('q') " placeholder="Поиск по названию">
	</div>
	<div class="col-md-2">
		<input class="form-control" name="min" value=" request('min') " placeholder="Цена от">
	</div>
	<div class="col-md-2">
		<input class="form-control" name="max" value=" request('max') " placeholder="Цена до">
	</div>
	<div class="col-md-2">
		<select class="form-select" name="sort">
			<option value="price_asc" @selected(request('sort','price_asc')==='price_asc')>Цена ↑</option>
			<option value="price_desc" @selected(request('sort')==='price_desc')>Цена ↓</option>
		</select>
	</div>
	<div class="col-md-2">
		<button class="btn btn-primary w-100" type="submit">Применить</button>
	</div>
</form>

<div class="row g-3">
	@foreach($comics as $comic)
		<div class="col-md-4">
			<div class="card h-100">
				@if($comic->cover_image_path)
					<img class="card-img-top" src=" asset('storage/'.$comic->cover_image_path) " alt="cover">
				@endif
				<div class="card-body">
					<h2 class="h6"><a href=" route('comics.show', $comic) "> $comic->title </a></h2>
					<div class="text-muted"> $comic->price  ₽</div>
				</div>
				<div class="card-footer bg-white border-0">
					<form method="POST" action=" route('cart.add', $comic) ">
						@csrf
						<button class="btn btn-sm btn-outline-primary">В корзину</button>
					</form>
				</div>
			</div>
		</div>
	@endforeach
</div>

<div class="mt-3"> $comics->links() </div>
@endsection
