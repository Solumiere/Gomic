@extends('layouts.app')

@section('title', 'Админ • Отзывы')

@section('content')
<h1 class="gomic-title mb-3">Админ • Отзывы</h1>

<div class="card gomic-card border-0 shadow-sm">
  <table class="table align-middle mb-0">
    <thead><tr><th>ID</th><th>Комикс</th><th>Пользователь</th><th>Оценка</th><th>Дата</th><th></th></tr></thead>
    <tbody>
    @foreach($reviews as $r)
      <tr>
        <td> $r->id </td>
        <td> $r->comic->title </td>
        <td> $r->user->email </td>
        <td><span class="gomic-stars"> str_repeat('★', (int) $r->rating) </span></td>
        <td> $r->created_at->format('d.m.Y') </td>
        <td class="text-end">
          <form method="POST" action=" route('admin.reviews.destroy', $r) " onsubmit="return confirm('Удалить отзыв?')">
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

<div class="mt-3"> $reviews->links() </div>
@endsection
