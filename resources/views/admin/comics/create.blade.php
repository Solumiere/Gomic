@extends('layouts.app')

@section('title', 'Добавить комикс')

@section('content')
<h1 class="gomic-title mb-3">Добавить комикс</h1>

<div class="card gomic-card border-0 shadow-sm p-4 col-lg-8">
  <form method="POST" action="<?= e(route('admin.comics.store')) ?>" enctype="multipart/form-data">
    @csrf
    <div class="mb-3"><label class="form-label">Название</label><input class="form-control" name="title" value="<?= e(old('title')) ?>" required></div>
    <div class="mb-3"><label class="form-label">Описание</label><textarea class="form-control" name="description" rows="3"><?= e(old('description')) ?></textarea></div>
    <div class="row g-2">
      <div class="col-md-4 mb-3"><label class="form-label">Цена</label><input class="form-control" name="price" value="<?= e(old('price')) ?>" required></div>
      <div class="col-md-4 mb-3"><label class="form-label">Страниц</label><input class="form-control" name="pages_count" value="<?= e(old('pages_count')) ?>"></div>
      <div class="col-md-4 mb-3"><label class="form-label">Год</label><input class="form-control" name="published_year" value="<?= e(old('published_year')) ?>"></div>
    </div>
    <div class="mb-3">
      <label class="form-label">Жанры</label>
      <select class="form-select" name="genres[]" multiple size="6">
        @foreach($genres as $g)
          <option value="<?= e($g->id) ?>" @selected(collect(old('genres', []))->contains($g->id))><?= e($g->name) ?></option>
        @endforeach
      </select>
      <div class="form-text">Удерживайте Ctrl (Cmd) для выбора нескольких</div>
    </div>
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="is_active" id="active" value="1" checked>
      <label class="form-check-label" for="active">Активен</label>
    </div>
    <div class="mb-3"><label class="form-label">Обложка (jpg/png)</label><input class="form-control" type="file" name="cover"></div>
    <div class="mb-3"><label class="form-label">PDF (обязательно)</label><input class="form-control" type="file" name="pdf" required></div>
    <button class="btn btn-success">Сохранить</button>
  </form>
</div>
@endsection
