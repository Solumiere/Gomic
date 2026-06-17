@extends('layouts.app')

@section('title', 'Каталог — Gomic')

@section('content')
<h1 class="gomic-title mb-3">Каталог</h1>

<form class="card gomic-card border-0 shadow-sm p-3 mb-4" method="GET" action=" route('comics.index') ">
  <div class="row g-2 align-items-end">
    <div class="col-md-4">
      <label class="form-label small text-muted">Поиск</label>
      <input class="form-control" name="q" value=" request('q') " placeholder="Название комикса">
    </div>
    <div class="col-md-2">
      <label class="form-label small text-muted">Цена от</label>
      <input class="form-control" name="min" value=" request('min') " placeholder="0">
    </div>
    <div class="col-md-2">
      <label class="form-label small text-muted">Цена до</label>
      <input class="form-control" name="max" value=" request('max') " placeholder="9999">
    </div>
    <div class="col-md-2">
      <label class="form-label small text-muted">Сортировка</label>
      <select class="form-select" name="sort">
        <option value="price_asc" @selected(request('sort','price_asc')==='price_asc')>Цена ↑</option>
        <option value="price_desc" @selected(request('sort')==='price_desc')>Цена ↓</option>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100" type="submit">Применить</button>
    </div>
  </div>
</form>

@if($comics->isEmpty())
  <div class="gomic-empty text-center py-5">
    <div class="display-6 mb-2">\uD83D\uDD0D</div>
    <p class="text-muted mb-0">Ничего не найдено. Попробуй изменить фильтры.</p>
  </div>
@else
  <div class="row g-4">
    @foreach($comics as $comic)
      <div class="col-sm-6 col-lg-4">
        <div class="card gomic-card h-100 border-0 shadow-sm">
          <a href=" route('comics.show', $comic->slug) " class="gomic-cover">
            @if($comic->cover_image_path)
              <img src=" asset('storage/'.$comic->cover_image_path) " alt=" $comic->title ">
            @else
              <div class="gomic-cover__placeholder">\uD83D\uDCD6</div>
            @endif
          </a>
          <div class="card-body d-flex flex-column">
            <h2 class="h6 mb-1"><a class="gomic-link" href=" route('comics.show', $comic->slug) "> $comic->title </a></h2>
            @if($comic->author)
              <div class="small text-muted mb-2"> $comic->author </div>
            @endif
            <div class="gomic-price mt-auto"> number_format($comic->price, 0, '.', ' ')  ₽</div>
          </div>
          <div class="card-footer bg-white border-0 pt-0">
            <form method="POST" action=" route('cart.add', $comic->id) ">
              @csrf
              <button class="btn btn-outline-primary w-100">В корзину</button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-4"> $comics->links() </div>
@endif
@endsection
