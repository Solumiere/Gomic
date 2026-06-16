@extends('layouts.app')

@section('content')
	<div class="p-4 bg-light rounded">
		<h1 class="h3 mb-2">Интернет-магазин комиксов</h1>
		<p class="mb-3">Покупай и скачивай комиксы в PDF. Отзывы доступны только после покупки.</p>
		<a class="btn btn-primary" href=" route('comics.index') ">Перейти в каталог</a>
	</div>
@endsection
