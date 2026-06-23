@extends('layouts.app')

@section('title', 'Редактировать комикс')

@section('content')
<h1 class="gomic-title mb-3">Редактировать комикс</h1>

<div class="card gomic-card border-0 shadow-sm p-4 col-lg-8">
  <form method="POST" action="<?= e(route('admin.comics.update', $comic)) ?>" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3"><label class="form-label">Название</label><input class="form-control" name="title" value="<?= e(old('title', $comic->title)) ?>" required></div>
    <div class="mb-3"><label class="form-label">Описание</label><textarea class="form-control" name="description" rows="3"><?= e(old('description', $comic->description)) ?></textarea></div>
    <div class="row g-2">
      <div class="col-md-4 mb-3"><label class="form-label">Цена</label><input class="form-control" type="number" min="0" step="0.01" inputmode="decimal" onkeydown="return !['e','E','+','-'].includes(event.key)" name="price" value="<?= e(old('price', $comic->price)) ?>" required></div>
      <div class="col-md-4 mb-3"><label class="form-label">Страниц</label><input class="form-control" type="number" min="1" step="1" inputmode="numeric" onkeydown="return !['e','E','+','-','.',','].includes(event.key)" name="pages_count" value="<?= e(old('pages_count', $comic->pages_count)) ?>"></div>
      <div class="col-md-4 mb-3"><label class="form-label">Год</label><input class="form-control" type="number" min="1900" max="<?= e(date('Y')) ?>" step="1" inputmode="numeric" onkeydown="return !['e','E','+','-','.',','].includes(event.key)" name="published_year" value="<?= e(old('published_year', $comic->published_year)) ?>"></div>
    </div>
    <div class="mb-3">
      <label class="form-label">Жанры</label>
      <select class="form-select" name="genres[]" multiple size="6">
        @foreach($genres as $g)
          <option value="<?= e($g->id) ?>" @selected(collect(old('genres', $comic->genres->pluck('id')->all()))->contains($g->id))><?= e($g->name) ?></option>
        @endforeach
      </select>
      <div class="form-text">Удерживайте Ctrl (Cmd) для выбора нескольких</div>
    </div>
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="is_active" id="active" value="1" @checked(old('is_active', $comic->is_active))>
      <label class="form-check-label" for="active">Активен</label>
    </div>
    <div class="mb-3"><label class="form-label">Новая обложка (необязательно)</label><input class="form-control" type="file" name="cover"></div>
    <div class="mb-3"><label class="form-label">Новый PDF (необязательно)</label><input class="form-control" type="file" name="pdf"></div>
    <button class="btn btn-primary">Обновить</button>
  </form>
</div>
@endsection
