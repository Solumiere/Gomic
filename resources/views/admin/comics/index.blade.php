@extends('layouts.app')

@section('title', 'Админ • Комиксы')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <h1 class="gomic-title mb-0">Админ • Комиксы</h1>
  <a class="btn btn-success" href="<?= e(route('admin.comics.create')) ?>">+ Добавить</a>
</div>

<div class="card gomic-card border-0 shadow-sm">
  <table class="table align-middle mb-0">
    <thead><tr><th>ID</th><th>Название</th><th>Цена</th><th>Активен</th><th></th></tr></thead>
    <tbody>
    @foreach($comics as $comic)
      <tr>
        <td><?= e($comic->id) ?></td>
        <td><?= e($comic->title) ?></td>
        <td><?= e(number_format($comic->price, 0, '.', ' ')) ?> ₽</td>
        <td>
          @if($comic->is_active)
            <span class="badge bg-success">Да</span>
          @else
            <span class="badge bg-secondary">Нет</span>
          @endif
        </td>
        <td class="text-end">
          <a class="btn btn-sm btn-outline-primary" href="<?= e(route('admin.comics.edit', $comic)) ?>">Ред.</a>
          <form class="d-inline" method="POST" action="<?= e(route('admin.comics.destroy', $comic)) ?>" onsubmit="return confirm('Удалить?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-outline-danger">Удалить</button>
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>

<div class="mt-3"><?= $comics->links() ?></div>
@endsection
