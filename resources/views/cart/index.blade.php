@extends('layouts.app')

@section('title', 'Корзина — Gomic')

@section('content')
<h1 class="gomic-title mb-3">Корзина</h1>

@if(empty($items))
  <div class="gomic-empty text-center py-5">
    <div class="display-6 mb-2">🛒</div>
    <p class="text-muted mb-3">Корзина пуста.</p>
    <a class="btn btn-primary" href="<?= e(route('comics.index')) ?>">В каталог</a>
  </div>
@else
  <div class="card gomic-card border-0 shadow-sm">
    <table class="table align-middle mb-0">
      <thead>
        <tr>
          <th>Комикс</th>
          <th class="text-end">Цена</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $it)
          <tr>
            <td><a class="gomic-link" href="<?= e(route('comics.show', $it['comic']->slug)) ?>"><?= e($it['comic']->title) ?></a></td>
            <td class="text-end"><?= e(number_format($it['comic']->price, 0, '.', ' ')) ?> ₽</td>
            <td class="text-end">
              <form method="POST" action="<?= e(route('cart.remove', $it['comic']->id)) ?>">
                @csrf
                <button class="btn btn-sm btn-outline-danger">Удалить</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th class="text-end" colspan="2">Итого:</th>
          <th class="text-end gomic-price"><?= e(number_format($total, 0, '.', ' ')) ?> ₽</th>
        </tr>
      </tfoot>
    </table>
  </div>

  <div class="mt-3">
    @auth
      <a class="btn btn-success btn-lg" href="<?= e(route('checkout.index')) ?>">Оформить заказ</a>
    @else
      <div class="alert alert-info mb-0">Чтобы оформить заказ, <a href="<?= e(route('login')) ?>">войди в аккаунт</a>.</div>
    @endauth
  </div>
@endif
@endsection
