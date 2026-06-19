@extends('layouts.app')

@section('title', 'Оформление заказа — Gomic')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <h1 class="gomic-title mb-3 text-center">Оформление заказа</h1>

    <div class="card gomic-card border-0 shadow-sm p-4">
      <h2 class="h6 text-muted mb-3">Ваш заказ</h2>
      <ul class="list-group list-group-flush mb-4">
        @foreach($comics as $comic)
          <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
            <span><?= e($comic->title) ?></span>
            <strong><?= e(number_format($comic->price, 0, '.', ' ')) ?> ₽</strong>
          </li>
        @endforeach
        <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
          <span class="fw-semibold">Итого</span>
          <strong class="gomic-price"><?= e(number_format($total, 2, '.', ' ')) ?> ₽</strong>
        </li>
      </ul>

      <h2 class="h6 mb-3">💳 Данные карты</h2>
      <form method="POST" action="<?= e(route('orders.store')) ?>" autocomplete="off">
        @csrf
        <div class="mb-3">
          <label class="form-label" for="card_number">Номер карты</label>
          <input class="form-control form-control-lg" id="card_number" name="card_number" inputmode="numeric" maxlength="19" placeholder="0000 0000 0000 0000" value="<?= e(old('card_number')) ?>" required>
        </div>
        <div class="row g-3">
          <div class="col-6">
            <label class="form-label" for="card_exp">Срок действия</label>
            <input class="form-control form-control-lg" id="card_exp" name="card_exp" inputmode="numeric" maxlength="5" placeholder="ММ/ГГ" value="<?= e(old('card_exp')) ?>" required>
          </div>
          <div class="col-6">
            <label class="form-label" for="card_cvv">CVV</label>
            <input class="form-control form-control-lg" id="card_cvv" name="card_cvv" inputmode="numeric" maxlength="4" placeholder="000" value="<?= e(old('card_cvv')) ?>" required>
          </div>
        </div>
        <p class="text-muted small mt-2 mb-3">🔒 Демо-оплата. Данные карты нигде не сохраняются.</p>
        <button class="btn btn-success btn-lg w-100" type="submit">Создать заказ</button>
      </form>
    </div>
  </div>
</div>

<script>
(function(){
  function onlyDigits(v){ return v.replace(/\D/g, ''); }
  var num = document.getElementById('card_number');
  var cvv = document.getElementById('card_cvv');
  var exp = document.getElementById('card_exp');
  if (num) num.addEventListener('input', function(){
    var d = onlyDigits(num.value).slice(0, 16);
    num.value = d.replace(/(.{4})/g, '$1 ').trim();
  });
  if (cvv) cvv.addEventListener('input', function(){
    cvv.value = onlyDigits(cvv.value).slice(0, 4);
  });
  if (exp) exp.addEventListener('input', function(){
    var d = onlyDigits(exp.value).slice(0, 4);
    exp.value = d.length >= 3 ? d.slice(0, 2) + '/' + d.slice(2) : d;
  });
})();
</script>
@endsection
