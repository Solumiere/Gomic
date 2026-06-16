@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Редактировать комикс</h1>

<form method="POST" action=" route('admin.comics.update', $comic) " enctype="multipart/form-data" class="col-md-8">
	@csrf
	@method('PUT')
	<div class="mb-2"><label class="form-label">Название</label><input class="form-control" name="title" value=" $comic->title " required></div>
	<div class="mb-2"><label class="form-label">Описание</label><textarea class="form-control" name="description" rows="3"> $comic->description </textarea></div>
	<div class="row g-2">
		<div class="col-md-4 mb-2"><label class="form-label">Цена</label><input class="form-control" name="price" value=" $comic->price " required></div>
		<div class="col-md-4 mb-2"><label class="form-label">Страниц</label><input class="form-control" name="pages_count" value=" $comic->pages_count "></div>
		<div class="col-md-4 mb-2"><label class="form-label">Год</label><input class="form-control" name="published_year" value=" $comic->published_year "></div>
	</div>
	<div class="form-check mb-2">
		<input class="form-check-input" type="checkbox" name="is_active" id="active" @checked($comic->is_active)>
		<label class="form-check-label" for="active">Активен</label>
	</div>
	<div class="mb-2"><label class="form-label">Новая обложка (необязательно)</label><input class="form-control" type="file" name="cover"></div>
	<div class="mb-3"><label class="form-label">Новый PDF (необязательно)</label><input class="form-control" type="file" name="pdf"></div>
	<button class="btn btn-primary">Обновить</button>
</form>
@endsection
