@extends('layout.site', ['title' => 'Оформить заказ'])

@section('content')
    <h1 class="mb-4">Оформить заказ</h1>

    <!-- Блок выбора профиля -->
    @if ($profiles && $profiles->count())
        <div class="mb-4">
            @include('basket.select', ['current' => $profile->id ?? 0])
        </div>
    @endif

    <!-- Форма оформления заказа -->
    <form method="post" action="{{ route('basket.saveorder') }}" id="checkout">
        @csrf

        <!-- Имя и фамилия -->
        <div class="form-group mb-3">
            <label for="name" class="form-label fw-bold">Имя, Фамилия</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Имя, Фамилия"
                   required maxlength="255" value="{{ old('name') ?? $profile->name ?? '' }}">
        </div>

        <!-- Email -->
        <div class="form-group mb-3">
            <label for="email" class="form-label fw-bold">Адрес почты</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Адрес почты"
                   required maxlength="255" value="{{ old('email') ?? $profile->email ?? '' }}">
        </div>

        <!-- Телефон -->
        <div class="form-group mb-3">
            <label for="phone" class="form-label fw-bold">Номер телефона</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Номер телефона"
                   required maxlength="255" value="{{ old('phone') ?? $profile->phone ?? '' }}">
        </div>

        <!-- Адрес доставки -->
        <div class="form-group mb-3">
            <label for="address" class="form-label fw-bold">Адрес доставки</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Адрес доставки"
                   required maxlength="255" value="{{ old('address') ?? $profile->address ?? '' }}">
        </div>

        <!-- Комментарий -->
        <div class="form-group mb-3">
            <label for="comment" class="form-label fw-bold">Комментарий</label>
            <textarea class="form-control" id="comment" name="comment" placeholder="Комментарий"
                      maxlength="255" rows="2">{{ old('comment') ?? $profile->comment ?? '' }}</textarea>
        </div>

        <!-- Кнопка "Оформить" -->
        <div class="form-group">
            <button type="submit" class="btn btn-success w-100">Оформить</button>
        </div>
    </form>
@endsection