@extends('layouts.app')

@section('title', $comic->title.' — Gomic')

@section('content')
<div class="card gomic-card border-0 shadow-sm p-4 mb-4">
  <div class="row g-4">
    <div class="col-md-4">
      @if($comic->cover_image_path)
        <img class="img-fluid rounded-3 w-100" src="<?= e(asset('storage/'.$comic->cover_image_path)) ?>" alt="<?= e($comic->title) ?>">
      @else
        <div class="gomic-cover__placeholder rounded-3" style="height:320px">📖</div>
      @endif
    </div>
    <div class="col-md-8">
      <h1 class="gomic-title mb-2"><?= e($comic->title) ?></h1>
      @if($comic->author)
        <div class="text-muted mb-2">Автор: <?= e($comic->author) ?></div>
      @endif
      <div class="mb-3">
        <span class="gomic-stars"><?= e(str_repeat('★', (int)round($avgRating)).str_repeat('☆', 5 - (int)round($avgRating))) ?></span>
        <span class="text-muted ms-1"><?= e(number_format($avgRating, 1)) ?> / 5</span>
      </div>
      @if($comic->genres->isNotEmpty())
        <div class="d-flex flex-wrap gap-1 mb-3">
          @foreach($comic->genres as $g)
            <span class="gomic-genre"><?= e($g->name) ?></span>
          @endforeach
        </div>
      @endif
      <p class="mb-3"><?= e($comic->description) ?></p>
      <div class="d-flex flex-wrap gap-3 text-muted small mb-3">
        @if($comic->pages_count)<span>📄 <?= e($comic->pages_count) ?> стр.</span>@endif
        @if($comic->published_year)<span>📅 <?= e($comic->published_year) ?></span>@endif
      </div>
      <div class="gomic-price gomic-price--lg mb-3"><?= e(number_format($comic->price, 0, '.', ' ')) ?> ₽</div>

      <div class="d-flex flex-wrap gap-2">
        @auth
          @if(auth()->user()->hasPurchased($comic->id))
            <a class="btn btn-success px-4" href="<?= e(route('profile.index')) ?>">✓ Уже куплено</a>
            <a class="btn btn-outline-secondary" href="<?= e(route('comics.download', $comic)) ?>">Скачать PDF</a>
          @else
            <form method="POST" action="<?= e(route('cart.add', $comic->id)) ?>">
              @csrf
              <button class="btn btn-primary px-4">В корзину</button>
            </form>
            <a class="btn btn-outline-secondary" href="<?= e(route('comics.download', $comic)) ?>">Скачать PDF</a>
          @endif
        @else
          <form method="POST" action="<?= e(route('cart.add', $comic->id)) ?>">
            @csrf
            <button class="btn btn-primary px-4">В корзину</button>
          </form>
        @endauth
      </div>
    </div>
  </div>
</div>

<div class="card gomic-card border-0 shadow-sm p-4">
  <h2 class="h5 mb-3">Отзывы</h2>

  @php
    $myReview = null;
    if (auth()->check()) {
      foreach ($reviews as $r) {
        if ((int)$r->user_id === (int)auth()->id()) { $myReview = $r; break; }
      }
    }
  @endphp

  @if($reviews->isEmpty())
    <p class="text-muted mb-0">Пока нет отзывов.</p>
  @else
    @foreach($reviews as $review)
      <div class="gomic-review mb-3">
        <div class="d-flex justify-content-between">
          <span class="fw-semibold"><?= e($review->user->name) ?></span>
          <span class="gomic-stars"><?= e(str_repeat('★', (int)$review->rating).str_repeat('☆', 5 - (int)$review->rating)) ?></span>
        </div>
        <div class="small text-muted mb-1"><?= e($review->created_at->format('d.m.Y')) ?></div>
        <div><?= e($review->body) ?></div>

        @auth
          @if((int)auth()->id() === (int)$review->user_id)
            <div class="mt-2 d-flex gap-2">
              <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleEditReview(<?= e($review->id) ?>)">Редактировать</button>
              <form method="POST" action="<?= e(route('reviews.destroy', $review)) ?>" onsubmit="return confirm('Удалить ваш отзыв?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">Удалить</button>
              </form>
            </div>
            <form method="POST" action="<?= e(route('reviews.update', $review)) ?>" id="edit-review-<?= e($review->id) ?>" class="mt-2" style="display:none">
              @csrf
              @method('PATCH')
              <div class="mb-2">
                <label class="form-label small">Оценка</label>
                <select class="form-select form-select-sm" name="rating" required>
                  @for($i = 5; $i >= 1; $i--)
                    <option value="<?= e($i) ?>" @selected((int)$review->rating === $i)><?= e($i) ?></option>
                  @endfor
                </select>
              </div>
              <div class="mb-2">
                <label class="form-label small">Текст</label>
                <textarea class="form-control form-control-sm" name="body" rows="3" required><?= e($review->body) ?></textarea>
              </div>
              <button class="btn btn-sm btn-success">Сохранить</button>
              <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleEditReview(<?= e($review->id) ?>)">Отмена</button>
            </form>
          @elseif(auth()->user()->is_admin)
            <form method="POST" action="<?= e(route('admin.reviews.destroy', $review)) ?>" class="mt-2" onsubmit="return confirm('Удалить отзыв?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Удалить отзыв</button>
            </form>
          @endif
        @endauth
      </div>
    @endforeach
  @endif

  @auth
    <hr class="my-4">
    @if($myReview)
      <p class="text-muted mb-0">Вы уже оставили отзыв — отредактируйте его выше.</p>
    @else
      <h3 class="h6 mb-3">Оставить отзыв <span class="text-muted small">(доступно после покупки)</span></h3>
      <form method="POST" action="<?= e(route('reviews.store', $comic)) ?>" class="col-lg-8">
        @csrf
        <div class="mb-2">
          <label class="form-label">Оценка</label>
          <select class="form-select" name="rating" required>
            @for($i = 5; $i >= 1; $i--)
              <option value="<?= e($i) ?>"><?= e($i) ?></option>
            @endfor
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Текст</label>
          <textarea class="form-control" name="body" rows="3" required></textarea>
        </div>
        <button class="btn btn-success">Отправить</button>
      </form>
    @endif
  @endauth
</div>

<script>
function toggleEditReview(id) {
  var f = document.getElementById('edit-review-' + id);
  if (f) { f.style.display = (f.style.display === 'none' || !f.style.display) ? 'block' : 'none'; }
}
</script>
@endsection
