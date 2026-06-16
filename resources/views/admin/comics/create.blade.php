@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Добавить комикс</h1>

<form method="POST" action=" route('admin.comics.store') " enctype="multipart/form-data" class="col-md-8">
	@csrf
	<div class="mb-2"><label class="form-label">Название</label><input class="form-control" name="title" required></div>
	<div class="mb-2"><label class="form-label">Описание</label><textarea class="form-control" name="description" rows="3"></textarea></div>
	<div class="row g-2">
		<div class="col-md-4 mb-2"><label class="form-label">Цена</label><input class="form-control" name="price" required></div>
		<div class="col-md-4 mb-2"><label class="form-label">Страниц</label><input class="form-control" name="pages_count"></div>
		<div class="col-md-4 mb-2"><label class="form-label">Год</label><input class="form-control" name="published_year"></div>
	</div>
	<div class="form-check mb-2">
		<input class="form-check-input" type="checkbox" name="is_active" id="active" checked>
		<label class="form-check-label" for="active">Активен</label>
	</div>
	<div class="mb-2"><label class="form-label">Обложка (jpg/png)</label><input class="form-control" type="file" name="cover"></div>
	<div class="mb-3"><label class="form-label">PDF (обязательно)</label><input class="form-control" type="file" name="pdf" required></div>
	<button class="btn btn-success">Сохранить</button>
</form>
@endsection
