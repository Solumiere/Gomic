@extends('layouts.app')

@section('title', $comic->title.' — Gomic')

@section('content')
<div class="card gomic-card border-0 shadow-sm p-4 mb-4">
  <div class="row g-4">
    <div class="col-md-4">
      @if($comic->cover_image_path)
        <img class="img-fluid rounded-3 w-100" src=" asset('storage/'.$comic->cover_image_path) " alt=" $comic->title ">
      @else
        <div class="gomic-cover__placeholder rounded-3" style="height:320px">\uD83D\uDCD6</div>
      @endif
    </div>
    <div class="col-md-8">
      <h1 class="gomic-title mb-2"> $comic->title </h1>
      @if($comic->author)
        <div class="text-muted mb-2">Автор:  $comic->author </div>
      @endif
      <div class="mb-3">
        <span class="gomic-stars"> str_repeat('★', (int) round($avgRating))  str_repeat('☆', 5 - (int) round($avgRating)) </span>
        <span class="text-muted ms-1"> number_format($avgRating, 1)  / 5</span>
      </div>
      <p class="mb-3"> $comic->description </p>
      <div class="d-flex flex-wrap gap-3 text-muted small mb-3">
        @if($comic->pages_count)<span>\uD83D\uDCC4  $comic->pages_count  стр.</span>@endif
        @if($comic->published_year)<span>\uD83D\uDCC5  $comic->published_year </span>@endif
      </div>
      <div class="gomic-price gomic-price--lg mb-3"> number_format($comic->price, 0, '.', ' ')  ₽</div>

      <div class="d-flex flex-wrap gap-2">
        <form method="POST" action=" route('cart.add', $comic->id) ">
          @csrf
          <button class="btn btn-primary px-4">В корзину</button>
        </form>
        @auth
          <a class="btn btn-outline-secondary" href=" route('comics.download', $comic) ">Скачать PDF</a>
        @endauth
      </div>
    </div>
  </div>
</div>

<div class="card gomic-card border-0 shadow-sm p-4">
  <h2 class="h5 mb-3">Отзывы</h2>

  @if($reviews->isEmpty())
    <p class="text-muted mb-0">Пока нет отзывов.</p>
  @else
    @foreach($reviews as $review)
      <div class="gomic-review mb-3">
        <div class="d-flex justify-content-between">
          <span class="fw-semibold"> $review->user->name </span>
          <span class="gomic-stars"> str_repeat('★', (int) $review->rating)  str_repeat('☆', 5 - (int) $review->rating) </span>
        </div>
        <div class="small text-muted mb-1"> $review->created_at->format('d.m.Y') </div>
        <div> $review->body </div>
      </div>
    @endforeach
  @endif

  @auth
    <hr class="my-4">
    <h3 class="h6 mb-3">Оставить отзыв <span class="text-muted small">(доступно после покупки)</span></h3>
    <form method="POST" action=" route('reviews.store', $comic) " class="col-lg-8">
      @csrf
      <div class="mb-2">
        <label class="form-label">Оценка</label>
        <select class="form-select" name="rating" required>
          @for($i = 5; $i >= 1; $i--)
            <option value=" $i "> $i </option>
          @endfor
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Текст</label>
        <textarea class="form-control" name="body" rows="3" required></textarea>
      </div>
      <button class="btn btn-success">Отправить</button>
    </form>
  @endauth
</div>
@endsection
